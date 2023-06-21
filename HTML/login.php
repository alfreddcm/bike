<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('connection.php');

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $idno=$_POST['idno'];
    $pass=$_POST['pass'];

    $sql = "SELECT * FROM admin WHERE idno= ? ";
    $query = $conn->prepare($sql);
    $query->bind_param("s", $idno);   
    $query->execute();
    $query->store_result();

    if ($query->num_rows > 0) {
        $sql1 = "SELECT * FROM admin WHERE idno= ? and pass = ?";
    $query1= $conn->prepare($sql1);
    $query1->bind_param("ss", $idno, $pass);   
    $query1->execute();
    $query1->store_result();
    
        if($query1->num_rows > 0){
            echo "<script>alert('Redirecting to dashboard!.'); window.location.href='dashboard.php';</script>";
        }else{
            echo "<script>alert('Incorrect Password!.'); window.location.href='login.php';</script>";
        }

    } else {
        echo "<script>alert('Id no not found!.'); window.location.href='login.php';</script>";
    }

};
?>
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

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login form</title>
</head>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <div class="container">
        
    
    <h2>Login</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <table>
            <tr><td><label for="idno">ID No : </label></td>
                <td><input type="text" name="idno" id="idno" required></td>
            </tr>
            <tr><td><label for="pass">Password: </label></td>
                <td><input type="password" name="pass" id="pass" required></td>
            </tr>
            </table>
        <input type="submit" value="Login">
    </form>
    <button onclick="gosignup()">Create new account</button>
    <button onclick="gohome()">Return home</button>
    </div>
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
