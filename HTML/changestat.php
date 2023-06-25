<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_GET['upstat'])) {
        $bikeid = $_GET['upstat'];
        $newStat = $_POST['statup'];

        if ($newStat === "repair") {
            $sql = "SELECT studidno FROM history WHERE bikeid = ? ORDER BY transno DESC LIMIT 1";
            $query = $conn->prepare($sql);
            $query->bind_param("s", $bikeid);

            if ($query->execute()) {
                $result = $query->get_result();
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $studidno = $row['studidno'];
                    header("Location: movetorepair.php?rn=" . $bikeid . "&studidno=" . $studidno);
                    exit; // Exit the script to prevent further execution
                }
            } else {
                echo "<script>alert('Error retrieving bike history!');</script>";
            }
        } else {
            $sql = "UPDATE bikeinfo SET stat = ? WHERE bikeid = ?";
            $query = $conn->prepare($sql);
            $query->bind_param("ss", $newStat, $bikeid);

            if ($query->execute()) {
                echo "<script>alert('Bike status changed successfully!'); window.location.href='bikelist.php';</script>";
                exit; // Exit the script to prevent further execution
            } else {
                echo "<script>alert('Error in updating bike status!');</script>";
            }
        }
    } else {
        echo "Invalid bike ID.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Bike Status</title>
</head>
<body>
    <h2>Change Bike Status</h2>
    <?php echo "Bike ID: " . $_GET['upstat']; ?><br>
    <label for="statup">Select status:</label>
    <form action="changestat.php?upstat=<?php echo $_GET['upstat']; ?>" method="POST">
        <select name="statup" id="statup">
            <option value="available">Available</option>
            <option value="borrowed">Borrowed</option>
            <option value="repair">Under Maintenance</option>
        </select>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
