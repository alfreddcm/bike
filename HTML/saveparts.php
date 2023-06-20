<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['brokenParts']) && isset($_GET['bikeid'])) {
        $Parts = json_decode($_POST['brokenParts'], true);
        $bikeid = $_GET['bikeid']; 
        $status='undermaintenance';
        
        require_once 'connection.php';
        $stmt = $conn->prepare("INSERT INTO onrepairlist (bikeid, brokenparts) VALUES (?, ?)");
        $stmt->bind_param("ss", $bikeid, $Parts);
        $stmt->execute();
        $sql=$conn->prepare("UPDATE set stat= ? from bikeinfo where bikeid= ?");
        $sql->bind_param("ss", $satus,$bikeid);

        $stmt->close();
        $conn->close();
        echo "<script>alert('Bike added to reapair list successfully!'); window.location.href='bikelist.php';</script>";
    } else {
        echo "<script>alert('Missing 'brokenParts' parameter!'); window.location.href='bikelist.php';</script>";
    }
} else {
    echo "Invalid request method!";
}
?>
