<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bparts = $_POST['brokenParts'];
    $bikeid = $_POST['bikeid'];

    $sql = "SELECT * FROM history WHERE bikeid = '$bikeid' ORDER BY transno DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $studid = $row['studid'];
        $date = date('Y-m-d');

        $insertQuery = "INSERT INTO repairlist (bikeid, studino, brokenparts, dateadded) VALUES ('$bikeid', '$studid', '$bparts', '$date')";

        if (mysqli_query($conn, $insertQuery)) {
            echo "<script>alert('Bike saved to repair list!'); window.location.href='repairlist.php';</script>";

            $updateQuery = "UPDATE bikeinfo SET stat='undermaintenance' WHERE bikeid = '$bikeid'";
            if (mysqli_query($conn, $updateQuery)) {
                echo "<script>alert('Bike status is updated to under maintenance.'); window.location.href='repairlist.php';</script>";
            } else {
                echo "<script>alert('Error in updating status'); window.location.href='repairlist.php';</script>";
            }
        } else {
            echo "<script>alert('Error in saving bike to repair list.'); window.location.href='repairlist.php';</script>";
        }
    } else {
        echo "<script>alert('No history found for the bike.'); window.location.href='repairlist.php';</script>";
    }

    $conn->close();
}
?>
