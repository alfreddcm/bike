<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bikeid = mysqli_real_escape_string($conn, $_POST['bikeidr']);
    $studid = mysqli_real_escape_string($conn, $_POST['idnor']);
    $time = mysqli_real_escape_string($conn, $_POST['timer']);
    $date = mysqli_real_escape_string($conn, $_POST['dater']);

    $sql ="SELECT * FROM history WHERE studidno = ? AND (timereturn ='-' or datereturn='-')"; 
    $query=$conn->prepare($sql);
    $query->bind_param("s",$studid);
    $query->execute();
    $query->store_result();

    if ($query->num_rows > 0) {
        echo "<script> alert('Student ID: " . $studid . "');</script>";
        echo "<script>alert(' Bike ID: " . $bikeid . "');</script>";
    
        $sql2 = "SELECT * FROM history WHERE bikeid = ? AND (timereturn ='-' or datereturn='-')";
        $query2 = $conn->prepare($sql2);
        $query2->bind_param("s", $bikeid);
        $query2->execute();
        $query2->store_result();
    
        if ($query2->num_rows > 0) {
            $sql3 = "UPDATE bikeinfo SET stat = 'available' WHERE bikeid = ?";
            $query3 = $conn->prepare($sql3);
            $query3->bind_param("s", $bikeid);
            $query3->execute();
    
            $sql4 = "UPDATE history SET timereturn = ?, datereturn = ? WHERE bikeid = ?";
            $query4 = $conn->prepare($sql4);
            $query4->bind_param("sss", $time, $date, $bikeid);
            $query4->execute();
            echo "<script> alert('Transactions Recorded!'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('No matching bike records found.'); window.location.href='index.php';</script>";
        }
    } else {
        echo "<script>alert('No pending bike returns for the given student'); window.location.href='index.php';</script>";

    }
    $query->free_result();
    $query->close();
    
}
?>
