<?php
session_start();

if (!isset($_SESSION['expression'])) {
    $_SESSION['expression'] = '';
}

if (isset($_POST['input']) && $_SESSION['expression'] !== 'Error') {
    $_SESSION['expression'] .= $_POST['input'];
} 

if (isset($_POST['operator']) && $_SESSION['expression'] !== 'Error') {
    $_SESSION['expression'] .= ' ' . $_POST['operator'] . ' ';
} 

if (isset($_POST['dot']) && $_SESSION['expression'] !== 'Error') {
    $lastChar = substr($_SESSION['expression'], -1);
    if ($lastChar !== '.' && !preg_match('/\d+\.\d*$/', $_SESSION['expression'])) {
        if (empty($_SESSION['expression']) || preg_match('/[+\-*\/]\s*$/', $_SESSION['expression'])) {
            $_SESSION['expression'] .= '0';
        }
        $_SESSION['expression'] .= '.';
    }
}

if (isset($_POST['clear'])) {
    $_SESSION['expression'] = '';
}

if (isset($_POST['back']) && $_SESSION['expression'] !== 'Error') {
    $_SESSION['expression'] = substr($_SESSION['expression'], 0, -1); // Remove the last character
}

if (isset($_POST['equal']) && $_SESSION['expression'] !== 'Error') {
    $expression = $_SESSION['expression'];
    if (!preg_match('/^\d+(\.\d+)?\s*([+\-*\/]\s*\d+(\.\d+)?\s*)*$/', $expression)) {
        $_SESSION['expression'] = 'Error';
    } else {
        $result = @eval('return ' . $expression . ';');
        if ($result === false) {
            $_SESSION['expression'] = 'Error';
        } else {
            $_SESSION['expression'] = $result;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Calculator</title>
    <style>
        body {
            background-image: url(p.jpg);
            background-size: cover;
            background-position: center;
            background-repeat: repeat;
            font-family: Consolas, monospace;
            margin: 0;
            padding: 0;
        }

        .calc {
            text-align: center;
            margin: 50px auto;
            background-color: rgba(255, 255, 255, 0.8);
            border: 2px solid black;
            width: 300px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
            padding: 20px;
        }

        .maininput {
            background-color: #f0f0f0;
            border: none;
            height: 60px;
            width: 100%;
            font-size: 24px;
            text-align: right;
            color: black;
            border-radius: 10px;
            margin-bottom: 20px;
            padding: 10px;
            box-sizing: border-box;
        }

        .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .btn {
            flex: 1;
            padding: 15px;
            border-radius: 10px;
            font-size: 18px;
            transition: background-color 0.3s ease;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #ddd;
        }

        .equal {
            background-color: #4caf50;
            color: white;
        }

        .equal:hover {
            background-color: #45a049;
        }

        .clear {
            background-color: #f44336;
            color: white;
        }

        .clear:hover {
            background-color: #d32f2f;
        }

        .back {
            background-color: #2196f3;
            color: white;
        }

        .back:hover {
            background-color: #1e87f0;
        }
    </style>
</head>
<body>
<div class="calc">
    <h2>Basic Calculator</h2>
    <form action="" method="post">
        <input type="text" id="mainInput" class="maininput" name="expression"
               value="<?php echo htmlspecialchars(@$_SESSION['expression']) ?>"
               <?php if ($_SESSION['expression'] === 'Error') {
                   echo 'style="color: #ff0000;"';
               } ?>>
        <div class="row">
            <input type="submit" class="btn back" name="back" value="&larr;">
            <input type="submit" class="btn clear" name="clear" value="C">
        </div>
        <div class="row">
            <input type="submit" class="btn" name="input" value="7">
            <input type="submit" class="btn" name="input" value="8">
            <input type="submit" class="btn" name="input" value="9">
            <input type="submit" class="btn" name="operator" value="/">
        </div>
        <div class="row">
            <input type="submit" class="btn" name="input" value="4">
            <input type="submit" class="btn" name="input" value="5">
            <input type="submit" class="btn" name="input" value="6">
            <input type="submit" class="btn" name="operator" value="*">
        </div>
        <div class="row">
            <input type="submit" class="btn" name="input" value="1">
            <input type="submit" class="btn" name="input" value="2">
            <input type="submit" class="btn" name="input" value="3">
            <input type="submit" class="btn" name="operator" value="-">
        </div>
        <div class="row">
            <input type="submit" class="btn" name="input" value="0">
            <input type="submit" class="btn" name="dot" value=".">
            <input type="submit" class="btn equal" name="equal" value="=">
            <input type="submit" class="btn" name="operator" value="+">
        </div>
    </form>
</div>
<script>
    // Function to adjust text alignment based on content length
    function adjustTextAlignment() {
        var inputField = document.getElementById("mainInput");
        if (inputField.scrollWidth > inputField.clientWidth) {
            inputField.style.textAlign = "left"; // Align text to the left if it overflows
            inputField.scrollLeft = inputField.scrollWidth - inputField.clientWidth; // Scroll to the end
        } else {
            inputField.style.textAlign = "right"; // Align text to the right if it fits
            inputField.scrollLeft = 0; // Reset scroll to the rightmost position
        }
    }

    // Call the function whenever there's a change in the input field
    document.getElementById("mainInput").addEventListener("input", adjustTextAlignment);

    // Call the function initially to set the initial text alignment
    adjustTextAlignment();
</script>
</body>
</html>
