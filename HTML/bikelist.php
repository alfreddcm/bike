<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'connection.php';
$sql = "SELECT * FROM bikeinfo";
$result = $conn->query($sql);

// Adding
if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $bikeid = $_POST["bikeid"];
        $biketype = $_POST["biketype"];
        $bikecolor = $_POST["bikecolor"];
        $bikedep = $_POST["bikedep"];
        $stat = $_POST["stat"];

        $checkQuery = "SELECT * FROM bikeinfo WHERE bikeid = ?";
        $checkStmt = $conn->prepare($checkQuery);
        $checkStmt->bind_param("s", $bikeid);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            echo "<script>alert('Bike ID is already in the list!'); window.location.href='bikelist.php';</script>";
        } else {
            $insertQuery = "INSERT INTO bikeinfo (bikeid, biketype, bikecolor, bikedep, stat) VALUES (?, ?, ?, ?, ?)";
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->bind_param("sssss", $bikeid, $biketype, $bikecolor, $bikedep, $stat);
            $insertStmt->execute();

            if ($insertStmt->affected_rows > 0) {
                echo "<script>alert('Record has been saved!'); window.location.href='bikelist.php';</script>";
                exit;
            } else {
                echo "<script>alert('No record has been saved!');</script>";
            }
        }
}

// Deleting
if(isset($_GET['delete_id']))
{
        $bikeid = $_GET['delete_id'];
        $stmt = $conn->prepare("DELETE FROM bikeinfo WHERE bikeid = ?");
        $stmt->bind_param("s", $bikeid);
        
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo "<script>alert('Record Deleted!'); window.location.href='bikelist.php';</script>";
            } else {
                echo "<script>alert('No record found to delete!'); window.location.href='bikelist.php';</script>";
            }
        } else {
            echo "Error executing the delete query: " . $stmt->error;
        }
        
        $stmt->close();

}

?>

<style>
#add, #update {
    display: none;
}
.grid-container {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        grid-gap: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        padding: 20px;
        background-color: #f0f0f0;
    }

    .grid-item {
        border-radius: 5px;
        padding: 10px;
        background-color: #ffffff;
        line-height: 0.1;
        flex-direction: column; 
        align-items: flex-start;
        justify-content: center;


    }
    .remove-button, .repair-button {
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        background: none;
        text-decoration: none;
    }

    .icon{
        width: 20px;
        height: 20px;
        margin-right: 5px;
    }

    .remove-text, .repair-text{
        display: inline;
    }
    
</style>

<script>
    
function showadd() {
    var addDiv = document.getElementById("add");
    var updateDiv = document.getElementById("update");

    // Show the 'add' div and hide the 'update' div
    addDiv.style.display = "block";
    updateDiv.style.display = "none";
    event.preventDefault();

}

function updatebike() {
    var addDiv = document.getElementById("add");
    var updateDiv = document.getElementById("update");

    // Show the 'update' div and hide the 'add' div
    updateDiv.style.display = "block";
    addDiv.style.display = "none";
    event.preventDefault();
}

function dash(){
    window.location.href="dashboard.php";
}

function delete_id(bikeid)
{
 if(confirm('Sure To Remove This Record ?'))
 {
  window.location.href='bikelist.php?delete_id='+bikeid;
 }
}
function upstat(bikeid)
{
 if(confirm('Select ok to continue'))
 {
  window.location.href='changestat.php?upstat='+bikeid;
 }
}

function confirmSubmit1() {
        return confirm("Are you sure you want to submit the form?");
    }
    function confirmSubmit2() {
        return confirm("Are you sure you want to submit the form?");
    }




</script>

<!DOCTYPE html>
<html>

<head>
    <title>Display Data</title>
</head>

<body>
    <h1>Bike List</h1>
    <?php
    echo "Number of rows: " . $result->num_rows;
    ?>

<div class="grid-container">
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='grid-item'>";
            echo "<table>";
            echo "<tr><td>Bike ID:</td><td>" . $row["bikeid"] . "</td></tr>";
            echo "<tr><td>Type:</td><td>" . $row["biketype"] . "</td></tr>";
            echo "<tr><td>Color:</td><td>" . $row["bikecolor"] . "</td></tr>";
            echo "<tr><td>Department:</td><td>" . $row["bikedep"] . "</td></tr>";
            echo "<tr><td>Status:</td><td>" . $row["stat"] . "</td></tr>";
            echo "</table>";
            ?>
            <a href="javascript:delete_id(<?php echo $row["bikeid"]; ?>)"><img src="delete.png" alt="Delete" class='icon' />
            <span class='remove-text'>Remove</span>
        </a>
        <a href="javascript:upstat(<?php echo $row["bikeid"]; ?>)"><img src="up.png" alt="up" class='icon' />
            <span class='remove-text'>Update status</span>
        </a>
            <?php

            echo "</div>";
        } 
    } else {
        echo "<p>No results found.</p>";
    }
    $result->close();
    ?>
</div>
    <div>
    <button onclick="dash()">Dashboard</button>
        <button onclick="showadd()">Add Bike</button>
        <button onclick="updatebike()">Edit Bike Information</button>

            <div id="add">
                <h1>Adding bike</h1>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" onsubmit="return confirmSubmit1();">
                    <label for="bikeid">Bike ID:</label>
                    <input type="number" id="bikeid" name="bikeid" required>
                    <label for="biketype">Bike Type:</label>
                    <input type="text" id="biketype" name="biketype" required>
                    <label for="bikecolor">Color:</label>
                    <input type="text" id="bikecolor" name="bikecolor" required>
                    <label for="bikedep">Department:</label>
                    <input type="text" id="bikedep" name="bikedep" required>
                    <input type="hidden" name="stat" value="available"><br>
                    <input type="submit" value="Submit">
                </form>
            </div>

            <div id="update">
                <h1>Edit Bike Information</h1>
                <form action="updatebike.php" method="POST" onsubmit="return confirmSubmit2();">
                    <label for="bikeid2">Bike ID:</label>
                    <input type="number" id="bikeid2" name="bikeid2" required>
                    <br>    
                    <label for="newbikeid">New Bike ID:</label>
                    <input type="number" id="newbikeid" name="newbikeid" required>
                    <br>
                    <label for="biketype">New Bike Type:</label>
                    <input type="text" id="biketype" name="biketype" required>
                    <br>
                    <label for="bikecolor">New Bike Color:</label>
                    <input type="text" id="bikecolor" name="bikecolor" required>
                    <br>
                    <label for="bikedep">New Bike Department:</label>
                    <input type="text" id="bikedep" name="bikedep" required>
                    <br>
                    <button type="submit">Update Bike</button>
                </form>
            </div>
        </div>
    </body>
</html>
