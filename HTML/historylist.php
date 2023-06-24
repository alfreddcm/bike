<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'connection.php';
$sql1="ALTER TABLE history AUTO_INCREMENT = 1";
$resultq1 = $conn->query($sql1);

$sql = "SELECT * FROM history";
$result = $conn->query($sql);

// Removing from history
if (isset($_GET['remove'])) {
    $bikeid = $_GET['remove'];
    $deleteStmt = $conn->prepare("DELETE FROM history WHERE bikeid = ?");
    $deleteStmt->bind_param("s", $bikeid);

    if ($deleteStmt->execute() && $deleteStmt->affected_rows > 0) {
        $sqlauto="ALTER TABLE history AUTO_INCREMENT = 1";
        $resultq1 = $conn->query($sqlauto);

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
    echo "Number on the list : " . $result->num_rows;
    ?>

    <table>
        <tr>
            <th>Bike ID</th>
            <th>Student ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Course</th>
            <th>Department</th>
            <th>Date Borrowed</th>
            <th>Date Returned</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["bikeid"] . "</td>";
                echo "<td>" . $row["studidno"] . "</td>";
                echo "<td>" . $row["studfname"] . "</td>";
                echo "<td>" . $row["studlname"] . "</td>";
                echo "<td>" . $row["course"] . "</td>";
                echo "<td>" . $row["depname"] . "</td>";
                echo "<td>" . $row["dtborrow"] . "</td>";

                if($row['dtreturn'] ==""){
                    echo "<td>Not returned</td>";
                }else{
                    echo "<td>" . $row["dtreturn"] . "</td>";
                }

                echo "<td>";
                if($row['dtreturn'] ==""){
                    echo "No Action available</td>";
                }else{
                echo "<a class='remove-button' href='historylist.php?remove=" . $row["bikeid"] . "'>Remove</a>";
                echo "<a href='movetorepair.php?rn=" . $row['bikeid'] . "&studidno=" . $row['studidno'] . "&studfname=" . $row['studfname'] .  "&studlname=" . $row['studlname'] . "' class='repair-button'>";
                echo "<img src='repair.png' alt='Move to Repair' class='repair-icon' width='20px' height='15px'>";
                echo "<span class='repair-text'>Move to Repair dont show if nasa list</span></a>";
                echo "</td>"; 
                }
                echo "</tr>";

            }
        } else {
            echo "<tr><td colspan='9'>No records found.</td></tr>";
        }
        ?>
        <button onclick="dash()">Dashboard</button>
    </table>
</body>

</html>
