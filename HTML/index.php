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
    <title>Form Submission</title>
</head>
<script>
    function submitForm() {
        document.getElementById("myForm").reset();
    }
</script>
<style>
body {
    display: flex;
}
.div1 {
    border: 1px solid black;
    width: 60%;
    height: 100%;
}
form{
    display: block;
}
#bikeid {
    text-align: center;
    padding: auto;
    width: 100%;
}
#idno {
    width: 20%;
}
</style>
<body>
    <div class="div1">
        <h1>Welcome to Bike Management System</h1>
    </div>
    <div> 
            <select name="status" id="status" required>
            <option value="borrow">Borrow</option>
            <option value="return">Return</option>
        </select>

        <div id="borrow">
            <form action="borrow.php" method="POST" id="borrowform" onsubmit="return validateForm();">
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
                <input type="time" name="time" id="time" required>
                <input type="date" name="date" id="date" required> 
                <br>
                <input type="submit" name="submit">
            </form>
        </div>

        <div id="return">
            <form action="return.php" method="POST" id="returnform" onsubmit="return validateForm2();">
                <input type="text" name="bikeidr" id="bikeidr" placeholder="Enter Bike ID"><br>
                <input type="text" name="idnor" id="idnor" placeholder="ID No"><br>
                <input type="time" name="timer" id="timer" required>
                <input type="date" name="dater" id="dater" required> 
                <br>
                <input type="submit" name="submit">
            </form>
        </div>
</body>
<script>

function validateForm() {
        const idno = document.getElementById("idno").value;
        const fname = document.getElementById("fname").value;
        const lname = document.getElementById("lname").value;
        const course = document.getElementById("course").value;
        const dep = document.getElementById("dep").value;

        if (idno === "" || fname === "" || lname === "" || course==="" || dep==="") {
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

    const now = new Date();
    const datenow = now.toISOString().slice(0, 10);
    const timenow = now.toTimeString().slice(0, 5);
  document.getElementById("date").value = datenow;
  document.getElementById("time").value = timenow;
  document.getElementById("dater").value = datenow;
  document.getElementById("timer").value = timenow;

</script>

</html>
