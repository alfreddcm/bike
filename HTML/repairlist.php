<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'connection.php';
$sql = "SELECT * FROM repairlist";
$result = $conn->query($sql);

// Removing from history
if (isset($_GET['remove'])) {
    $bikeid = $_GET['remove'];

    $deleteStmt = $conn->prepare("DELETE FROM reapairlist WHERE bikeid = ?");
    $deleteStmt->bind_param("s", $bikeid);
    $updatestat="UPDATE bikeinfo set stat='avialable' where bikeid=?";
    $update->bind_param("s", $bikeid);
    $update->execute();

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
    </script>
</head>

<body>
    <h1>History List</h1>
    <?php
    echo "Number of rows: " . $result->num_rows;
    ?>

    <table>
        <tr>
            <th>Bikeid</th>
            <th>Student ID</th>
            <th>Broken parts</th>
            <th>Date</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["bikeid"] . "</td>";
                echo "<td>" . $row["studino]"] . "</td>";
                echo "<td>" . $row["brokenparts"] . "</td>";
                echo "<td>" . $row["dateadded"] . "</td>";
                echo "<td>";
                echo "<a class='remove-button' href='repairlist.php?remove=" . $row["bikeid"] . "'>Remove</a>";

            }
        } else {
            echo "<tr><td colspan='9'>No records found.</td></tr>";
        }
        ?>
        <button onclick="dash()">Dashboard</button>
    </table>
</body>

</html>
