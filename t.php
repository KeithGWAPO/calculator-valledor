<?php
session_start();

// Initialize session variables if not set
if (!isset($_SESSION['expression'])) {
    $_SESSION['expression'] = '';
}

// Handle number and operator inputs
if (isset($_POST['input']) && $_SESSION['expression'] !== 'Error') {
    $_SESSION['expression'] .= $_POST['input'];
} 

if (isset($_POST['operator']) && $_SESSION['expression'] !== 'Error') {
    $_SESSION['expression'] .= ' ' . $_POST['operator'] . ' ';
} 

// Handle dot input
if (isset($_POST['dot']) && $_SESSION['expression'] !== 'Error') {
    // Check if there's already a dot in the expression
    if (!strpos($_SESSION['expression'], '.')) {
        $_SESSION['expression'] .= '.';
    } else {
        // If dot is already present, display an error message
        $_SESSION['expression'] = 'Error';
    }
}

// Clear the calculator
if (isset($_POST['clear'])) {
    $_SESSION['expression'] = '';
}

// Backspace functionality
if (isset($_POST['back']) && $_SESSION['expression'] !== 'Error') {
    $_SESSION['expression'] = substr($_SESSION['expression'], 0, -1); // Remove the last character
}

// Calculate the result only when equals is pressed
if (isset($_POST['equal']) && $_SESSION['expression'] !== 'Error') {
    // Attempt to calculate the result
    $expression = $_SESSION['expression'];
    if (!preg_match('/^\d+(\.\d+)?\s*([+\-*\/]\s*\d+(\.\d+)?\s*)*$/', $expression)) {
        $_SESSION['expression'] = 'Error';
    } else {
        $result = @eval('return ' . $expression . ';');
        if ($result === false) {
            $_SESSION['expression'] = 'Error';
        } else {
            // Store the result back into expression
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
        body{
            background-image: url(p.jpg);
            background-size:cover;
            background-position:center;
            background-repeat:repeat;
            font-family: Consolas, monospace;
        }
        .calc{
            text-align:center;
            margin: auto;
            background-color: darkgray;
            border:5px solid black;
            width: 30.5%;
            height: 650px; /* Increased height to accommodate the display */
            border-radius: 25px;
            box-shadow: 0 5px 40px black;
        }
        .maininput{
            margin-top:80px;
            background-color: darkgreen;
            border: 1px solid gray;
            height: 60px; /* Adjusted height to fit inside the border */
            width: 89%; /* Adjusted width to fit inside the border */
            font-size: 40px;
            text-align:right;
            color: whitesmoke;
            font-weight: 00;
            padding: 10px;
            margin: 10px auto; /* Center the display horizontally */
            border-radius: 5px;
            pointer-events: none;
            border:5px solid black;
            border-radius:15px;
            overflow-x: auto; /* Allow horizontal scrolling */
        }
        .numbtn{
            padding: 25px 30px;
            border-radius: 10px;
            font-weight: 500;
            background-color: #E1D9D1;
            color:black;
        }
        .numbtn:hover{
            background-color: #DCD7C8;
            color: black;
        }
        .calbtn{
            padding: 25px 30px;
            border-radius: 10px;
            font-weight: 500;
            background-color: #2C2D2D;
            color:white;
            float:-px;
        }
        .calbtn:hover{
            background-color: black;
            color: white;
        }
        .c{
            padding: 25px 30px;
            border-radius: 10px;
            font-weight: 500;
            background-color: red;
            color:black;
            float: right; 
        }
        .c:hover{
            background-color: rgb(237, 45, 45);
            color: whitesmoke;
        }
        .back{
            padding: 25px 30px;
            border-radius: 10px;
            font-weight: 500;
            background-color: #2C2D2D;
            color:white;
            float:right;     
        }
        .back:hover{
            background-color: black;
            color: white;
        }
        .equal{
            padding: 25px 30px;
            border-radius: 10px;
            font-weight: 500;
            background-color: #2C2D2D;
            color:white;
        }
        .equal:hover{
            background-color: black;
            color: white;
        }
        h2{
            color:black;
            font-size:x-large;
            text-align:center;
            margin-top:10px;
            margin-bottom:20px;
            border:2px solid black;
            width:60%;
            margin-left:72px;
            text-align:center;
            margin-top:35px;
            border-radius:5px;
        }

        .numbtn,
        .calbtn,
        .c,
        .equal,
        .back {
            padding: 25px 30px;
            border-radius: 15px;
            font-weight: 500;
            font-size: medium;
            transition: transform 0.2s ease;
            margin: 5px; 
        }
        .numbtn:hover,
        .calbtn:hover,
        .c:hover,
        .back,
        .equal:hover {
            transform: translateY(2px);
        }
        .numbtn:active,
        .calbtn:active,
        .c:active,
        .back:active,
        .equal:active {
            transform: translateY(4px);
        }
    </style>
</head>
<body>
<div class="calc">
    <h2>Basic Calculator</h2>
    <form action="" method="post">
        <input type="text" id="mainInput" class="maininput" name="expression" value="<?php echo htmlspecialchars(@$_SESSION['expression']) ?>" <?php if($_SESSION['expression'] === 'Error') { echo 'style="color: #ff0000;"'; } ?>>


        <br><br>
        
        <input type="submit" class="c" name="clear" value="c">
        <input type="submit" class="back" name="back" value="<"><br><br><br><br><br>
        <input type="submit" class="numbtn" name="input" value="7">
        <input type="submit" class="numbtn" name="input" value="8">
        <input type="submit" class="numbtn" name="input" value="9">
        <input type="submit" class="calbtn" name="operator" value="/"><br>
        <input type="submit" class="numbtn" name="input" value="4">
        <input type="submit" class="numbtn" name="input" value="5">
        <input type="submit" class="numbtn" name="input" value="6">
        <input type="submit" class="calbtn" name="operator" value="*"><br>
        <input type="submit" class="numbtn" name="input" value="1">
        <input type="submit" class="numbtn"name="input" value="2">
        <input type="submit" class="numbtn"name="input" value="3">
        <input type="submit" class="calbtn"name="operator" value="-"><br>
        <input type="submit" class="numbtn" name="input" value="0">
        <input type="submit" class="equal" name="dot" value=".">
        <input type="submit" class="equal" name="equal" value="=">
        <input type="submit" class="calbtn" name="operator" value="+">
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
