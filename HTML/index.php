<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('connection.php');
$sql = "SELECT * FROM bikeinfo where stat='available'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bike Management System</title>
</head>
<style>
    body{
    
    display:flex;        
	height: 100%;
    font-family: Poppins-Regular, sans-serif;
    background-color: #f9df30;
}
        
.column1 {
  float: left;
  width: 60%;
  padding: 10px;
}
.column2 {
  float: left;
  width: 40%;
  padding: 10px;
  height: 300px;
}
#idno{
    margin-top:5px;
    width:50px;
}
#fname,#lname{
    width: 150px;
}

.con{
    background-color:white;
    border-radius:3px;
    margin-top:6rem;
    width:400px;
    box-shadow:10px 10px 10px;
    padding:20px;
}
.con input[type="text"]{
    margin-top:2px;
    margin-bottom:3px;
    padding:5px;
    font-size:15px;
    border: none;
    border-bottom: 1px solid black;
}
#status, #bikeid{
    border-radius:3px;
    background-color:gren;
    font-size:15px;
    text-align:center;
    display: block;
  margin-left: auto;
  margin-right: auto;
    width:100%;
}
.side{
    
  display: flex;
  flex-direction: row-reverse;
  align-content:space-around;
  padding:20px;
}
.side button{
    cursor: pointer;
    background-color: transparent;
  text-decoration:none;
  margin: 10px;
  border:none;
}


</style>

<body>
    <div class="column1">
        <h1>Welcome to Bike Management System</h1>
        <div class="p">
            <?php echo "Today is " . date("l"); ?>
        </div>

    </div>

    <div class="column2">
        <div class="side">
            <button href="">Help and Support</button>
            <button onclick="gologin()">Login as administrator</button>
        </div>
        <div class="con"> 
            <label for="">Select action:</label><br>
            <select name="status" id="status" required>
                <option value="borrow">BORROWING</option>
                <option value="return">RETURNING</option>
            </select><br>

            <div id="borrow">
                <form action="borrow.php" method="POST" id="borrowform" onsubmit="return validateForm();">
                <?php echo "Number available bikes: " . $result->num_rows;?><br>
                <label for="">Choose bike id:</label><br>
                <select name="dropd" id="bikeid">
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <option value="<?php echo $row["bikeid"]; ?>">
                    <?php echo $row["bikeid"]; ?>
                        </option>
                    <?php endwhile; ?>
                    </select>

                    <input type="text" name="idno" id="idno" placeholder="ID No" require>
                    <input type="text" name="fname" id="fname" placeholder="First Name" require>
                    <input type="text" name="lname" id="lname" placeholder="Last Name" require><br>
                    <input type="text" name="course" id="course" placeholder="Course" require>
                    <input type="text" name="dep" id="dep" placeholder="Department" require><br>
                    <input type="datetime-local" name="datetime" id="datetime" require> 
                    <br>
                    <input type="submit" name="submit">
                </form>
                </div>
        

                    <div id="return">
                        <form action="return.php" method="POST" id="returnform" onsubmit="return validateForm2();">
                        <label for="">Enter bike id:</label><br>
                            <input type="text" name="bikeidr" id="bikeidr" placeholder="Bike ID">
                            <input type="text" name="idnor" id="idnor" placeholder="ID No"><br>
                            <input type="datetime-local" name="datetimer" id="datetimer" require> 
                            <br>
                            <input type="submit" name="submit">
                        </form>
                        </div>
    </div>
</body>


<script>

    function gologin(){
        window.location.href="login.php";
    }
function validateForm() {
        const idno = document.getElementById("idno").value;
        const fname = document.getElementById("fname").value;
        const lname = document.getElementById("lname").value;
        const course = document.getElementById("course").value;
        const dep = document.getElementById("dep").value;

        if (idno === "" || fname === "" || lname === "" || course=== "" || dep=== "" ) {
            alert("Please fill in all required fields.");
            return false;
        }
        
        return true;
    }
    function validateForm2() {
        const idno = document.getElementById("idnor").value;
        const bikeid = document.getElementById("bikeidr").value;

        if (idno === "" || bikeid === "") {
            alert("Please fill in all required fields.");
            return false;
        }     
        return true;
    }
    const statusSelect = document.getElementById('status');
    const borrowDiv = document.getElementById('borrow');
    const returnDiv = document.getElementById('return');
    returnDiv.style.display = 'none';
    
    statusSelect.addEventListener('change', function() {
        const selectedOption = statusSelect.value;
        if (selectedOption === 'borrow') {
            borrowDiv.style.display = 'block';
            returnDiv.style.display = 'none';
        } else if (selectedOption === 'return') {
            borrowDiv.style.display = 'none';
            returnDiv.style.display = 'block';
        }
    });
</script>

</html>
