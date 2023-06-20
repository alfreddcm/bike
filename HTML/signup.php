<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>

    <style>
        body{
            font-family: Poppins-Regular, sans-serif;
            background-color: #f9df30;
        }
        .container {
            display:block;
            background-color: white;
            border-radius:3px;
            box-shadow: 10px 10px 10px;
            padding: 20px;
            width:400px;
            margin:auto;
        }

        .container input[type="text"],
        .container input[type="password"] {
            font-size:15px;
            border: none;
            border-bottom: 1px solid black;
            padding: 5px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
    <h2 align="center">Adding admin account</h2>
<form action="process_signup.php" method="POST" onsubmit="return confirmSubmit();">
    <table>
        <tr>
            <td><label for="idno">ID Number:</label></td>
            <td><input type="text" name="idno" id="idno" required></td>
        </tr>
        <tr>
            <td><label for="fname">First Name:</label></td>
            <td><input type="text" name="fname" id="fname" required></td>
        </tr>
        <tr>
            <td><label for="lname">Last Name:</label></td>
            <td><input type="text" name="lname" id="lname" required></td>
        </tr>
        <tr>
            <td><label for="depname">Department Name:</label></td>
            <td><input type="text" name="depname" id="depname" required></td>
        </tr>
        <tr>
            <td><label for="pass">Password:</label></td>
            <td><input type="password" name="pass" id="pass" required onkeyup="validatePassword(this.value)"></td>
        </tr>
    </table>
    <input type="submit" value="Signup">
</form>
<a href="login.php">Already have an account?</a>

<!-- Password validation indicator -->
<span id="password-validation" class="invalid">At least one uppercase letter and one numeric digit</span>

<script>
    var password = document.getElementById("password-validation");

    function validatePassword(password) {
        const length = password.length >= 8,
            upper = /[A-Z]/g,
            numbers = /[0-9]/g,
            symbols = /[\W_]/g;

        var isValid = length && password.match(upper) && password.match(numbers) && password.match(symbols);

        if(isvalid){

        }

        passwordValidation.classList.toggle("valid", isValid);
        passwordValidation.classList.toggle("invalid", !isValid);
    }

    function confirmSubmit() {
        var isConfirmed = confirm("Are you sure you want to submit the form?");
        return isConfirmed;
    }
</script>

