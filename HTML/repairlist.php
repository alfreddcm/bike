<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'connection.php';
$sql = "SELECT bikeid,studidno,brokenparts,dateadded FROM repairlist";
$result = $conn->query($sql);

// Removing from repairlist
if (isset($_GET['delete_id'])) {
    $bikeid = $_GET['delete_id'];

    $deleteStmt = $conn->prepare("DELETE FROM repairlist WHERE bikeid = ?");
    $deleteStmt->bind_param("s", $bikeid);


    $sql="UPDATE bikeinfo set stat='available' where bikeid=?";
    $updatestat=$conn->prepare($sql);
    $updatestat->bind_param("s", $bikeid);
    $updatestat->execute();

    if ($deleteStmt->execute() && $deleteStmt->affected_rows > 0) {
        echo "<script>alert('Bike removed from history!'); window.location.href='historylist.php';</script>";
    } else {
        echo "<script>alert('Error removing bike from history!');</script>";
    }

    $deleteStmt->close();
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>History List</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .remove-button, .repair-button {
            display: inline-block;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .remove-button {
            background-color: #f44336;
            color: #fff;
        }

        .remove-button:hover {
            background-color: #d32f2f;
        }

        .repair-button {
            background-color: #2196f3;
            color: #fff;
        }

        .repair-button:hover {
            background-color: #1976d2;
        }
    </style>
    <script>
        function dash(){
    window.location.href="dashboard.php";
}
function delete_id(bikeid)
{
 if(confirm('Sure To Remove This Record ?'))
 {
  window.location.href='repairlist.php?delete_id='+bikeid;
 }
}
    </script>
</head>

<body>
    <h1>Repair List</h1>
    <table>
        <tr>
            <th>Bikeid</th>
            <th>Student ID</th>
            <th>Broken parts</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["bikeid"] . "</td>";
                echo "<td>" . $row["studidno"] . "</td>";
                echo "<td>" . $row["brokenparts"] . "</td>";
                echo "<td>" . $row["dateadded"] . "</td>";
                echo "<td>";
                ?>
                <a href="javascript:delete_id(<?php echo $row["bikeid"]; ?>)"><img src="delete.png" alt="Delete" class='remove-icon' />
                <span class='remove-text'>Remove</span></a>
                <?php
            }
        } else {
            echo "<tr><td colspan='5' >No records found.</td></tr>";
        }
        ?>
        <button onclick="dash()">Dashboard</button>
    </table>
</body>

</html>
