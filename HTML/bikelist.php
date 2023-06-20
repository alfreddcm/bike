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
if (isset($_GET['rn'])) {

        $bikeid = $_GET['rn'];
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

    .remove-icon, .repair-icon {
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
function w3_open() {
  document.getElementById("mySidebar").style.display = "block";
}

function w3_close() {
  document.getElementById("mySidebar").style.display = "none";
}
</script>

<!DOCTYPE html>
<html>

<head>
    <title>Display Data</title>
</head>

<body>
<div class="w3-sidebar w3-bar-block w3-collapse w3-card" style="width:200px;" id="mySidebar">
  <button class="w3-bar-item w3-button w3-hide-large"
  onclick="w3_close()">Close &times;</button>
  <a href="#" class="w3-bar-item w3-button">Link 1</a>
  <a href="#" class="w3-bar-item w3-button">Link 2</a>
  <a href="#" class="w3-bar-item w3-button">Link 3</a>
</div>

<div class="w3-main" style="margin-left:200px">

<div class="w3-teal">
  <button class="w3-button w3-teal w3-xlarge" onclick="w3_open()">&#9776;</button>
  <div class="w3-container">

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
            echo "<a href='?rn={$row['bikeid']}' class='remove-button'>";
            echo "<img src='delete.png' alt='Delete' class='remove-icon'>";
            echo "<span class='remove-text'>Remove</span>";
            echo "</a>";
            echo "<a href='movetorepair.php?rn=" . $row['bikeid'] . "' class='repair-button'>";
            echo "<img src='repair.png' alt='Move to Repair' class='repair-icon'>";
            echo "<span class='repair-text'>Move to Repair</span></a>";            
            echo "</div>";
        } 
    } else {
        echo "<p>No results found.</p>";
    }
    $result->close();
    ?>
</div>
    <div>
        <button onclick="showadd()">Add Bike</button>
        <button onclick="updatebike()">Edit Bike Information</button>

            <div id="add">
                <h1>Adding bike</h1>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <label for="bikeid">Bike ID:</label>
                    <input type="text" id="bikeid" name="bikeid" required>
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
                <form action="updatebike.php" method="POST">
                    <label for="bikeid2">Bike ID:</label>
                    <input type="text" id="bikeid2" name="bikeid2" required>
                    <br>    
                    <label for="newbikeid">New Bike ID:</label>
                    <input type="text" id="newbikeid" name="newbikeid" required>
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
