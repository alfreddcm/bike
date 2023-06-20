<?php
    
    require('connection.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $username = $_POST["username"];
        $password = $_POST["password"];

        //create query
        if ($username == "admin" && $password == "password") {
            echo "Login successful!";
        } else {
            echo "Invalid username or password!";
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form action="login.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br><br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br><br>
        <input type="submit" value="Login">
    </form>
    <button onclick="gosignup()">Create new account.</button>
    <button onclick="gohome()">return home</button>
</body>
</html>
<script>
    function gohome(){
        window.location.href="index.php";
    }
    function gosignup(){
        window.location.href="signup.php";
    }
</script>
