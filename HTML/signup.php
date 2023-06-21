<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idno = $_POST['idno'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $depname = $_POST['depname'];
    $pass = $_POST['pass'];
    $pass2 = $_POST['pass2'];

    if ($pass!=$pass2){
        echo "<script>alert('Password mismatch! '); window.location.href='signup.php';</script>";
    }else{
    $sql = "SELECT* from admin where idno=?";
    $query = $conn->prepare($sql);
    $query->bind_param("s", $idno);   
    $query->execute();
    
    $query->store_result();

    if($query->num_rows > 0){
        echo "<script>alert('ID number is already in used! '); window.location.href='signup.php';</script>";
    }else{

        $sql1 = "INSERT INTO admin (idno,fname,lname,depname,pass) VALUES (?,?,?,?,?)";
        $query1 = $conn->prepare($sql1);
        $query1->bind_param("sssss",$idno,$fname,$lname,$depname,$pass);
        $query1->execute();
        $query1->store_result();

            echo "<script>alert('Account added!');</script>";
            echo "<script>alert('Redirecting to dashboard'); window.location.href='dashboard.php';</script>";
    }
}
}

?>

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
            margin-top:1.5in;
            margin-left:auto;
            margin-right:auto;
            display:block;
            background-color: white;
            border-radius:3px;
            box-shadow: 10px 10px 10px;
            padding: 20px;
            width:400px;
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
    <h2 align="center">Add Account</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" onsubmit="return confirmSubmit();">
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
            <td><input type="password" name="pass" id="pass"></td>
        </tr>
        <tr>
            <td><label for="pass">Confirm password:</label></td>
            <td><input type="password" name="pass2" id="pass2"></td>
        </tr>
    </table>
    <input type="submit" value="Signup" id="submit">
</form>
<a href="login.php">Already have an account?</a>
    </body>
    </div>
    </html>
<script>


</script>

