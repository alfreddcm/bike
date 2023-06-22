<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require('connection.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
      <style>
          body {
            height: 100%;
    font-family: Poppins-Regular, sans-serif;
    background-color: #E7E9EB;
    background-image: url("bg.png");
    background-repeat: repeat-y;
          }
          .con{
            width: 80%;
            background-color: #f8f9fc;
            margin-left: auto;
            margin-right: auto;
          }
          .user{
            margin-top: 100px;
            margin-bottom: 0.5rem;
             line-height: 1.2;
             display: flex;
             flex-direction: column;
            width: 75%;
            margin-left: auto;
            margin-right: auto;
          }
  
          .dashboard {
            width: 80%;
              display: flex;
              flex-direction: row;
              justify-content: space-evenly;
              align-items: center;
              margin-left: auto;
              margin-right: auto;
          }
  
          fieldset {
              border-radius: 10px;
              border: 3px solid white;
              width: 2in;
              height: 1in;
              margin-bottom: 1in;
              box-shadow: 10px 10px 10px;
          }
          fieldset legend{
            background-color: white;
              border-radius: 3px;
              border: 1px solid white;
              font-size: large;
          }
          .fieldset1{
            background-color: red;
          }
          .fieldset1:hover{
            background-color: pink;
          }
          .fieldset2{
            background-color: blue;
          }
          .fieldset3{
            background-color: orange; 
          }
          .logout{
            display: flex;
            flex-direction: row-reverse;
            margin-right:20px;
            
          }

      </style>
</head>
<body>
  <div class="con">
  <div class="user">
    <h1>hello Jaymar Chaves</h1>
    <h3>CCSICT Department</h3>
  </div>
    <div class="dashboard">
        <fieldset class="fieldset1">
            <legend>BIKE LIST</legend>
            <?php
                $sql = "SELECT * FROM bikeinfo";
                $query = $conn->query($sql);
                $result = $query->fetch_all(MYSQLI_ASSOC);
                $rowCount = count($result);
                echo $rowCount . " registered Bike";
            ?><br><a href="bikelist.php">See list</a>
        </fieldset>

        <fieldset class="fieldset2">
            <legend>TRANSACTIONS</legend>
            <?php
                $sql = "SELECT * FROM bikeinfo where stat='borrowed'";
                $query = $conn->query($sql);
                $result = $query->fetch_all(MYSQLI_ASSOC);
                $rowCount = count($result);
                echo $rowCount . " borrowed bike";
            ?><br>
            <br><a href="historylist.php">See list</a>

        </fieldset>

        <fieldset class="fieldset3">
            <legend>REPAIR LIST</legend>
            <?php
                $sql = "SELECT * FROM repairlist ";
                $query = $conn->query($sql);
                $result = $query->fetch_all(MYSQLI_ASSOC);
                $rowCount = count($result);
                echo $rowCount . " listed bike ";
            ?><br><a href="repairlist.php">See list</a>

        </fieldset>
    </div>
    <div class="logout"><button onclick="logout()">LOG OUT</button></div>
</div>
  </body>
  <script>
    function logout(){
      window.location.href="login.php"
    }
  </script>
</html>
