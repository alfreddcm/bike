<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bikeid = $_POST['dropd'];
    $studid = $_POST['idno'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $course = $_POST['course'];
    $department = $_POST['dep'];
    $datetime=$_POST['datetime'];




    $sql = "SELECT * FROM history WHERE bikeid= ? and studidno= ? and studfname = ? and studlname= ?";
    $query = $conn->prepare($sql);
    $query->bind_param("ssss", $bikeid, $studid, $fname, $lname);   
    $query->execute();
    
    $row = $query->get_result()->fetch_array(MYSQLI_ASSOC);

    if($row['dtreturn']=== NULL){
        echo "<script>alert('You cannot borrow a bike. Please return the borrowed bike first.'); window.location.href='index.php';</script>";
    }else{
        
        $query->close();
        $sql1 = "INSERT INTO history (bikeid, studidno, studfname, studlname, course, depname, dtborrow) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $query1 = $conn->prepare($sql1);
        $query1->bind_param("sssssss", $bikeid, $studid, $fname, $lname, $course, $department, $datetime);
        $query1->execute();


        $sql2 = "UPDATE bikeinfo SET stat = ? WHERE bikeid = ?";
        $query2 = $conn->prepare($sql2);
        $status = "borrowed";
        $query2->bind_param("ss", $status, $bikeid);
        $query2->execute();

        if ($query1->affected_rows > 0 && $query2->affected_rows > 0) {
            echo "<script>alert('Transaction Recorded!'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Failed to record the transaction!'); window.location.href='index.php';</script>";
        }
    }

    $query1->close();
    $query2->close();
}
?>