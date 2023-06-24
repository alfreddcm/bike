<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require('connection.php');
?>

<style>
    .con {
        margin: auto;
    }
</style>

<!DOCTYPE html>
<html>
<head>
    <title>Bike Assembly Checklist</title>
    <style>
        .container {
            display:;
            width: 50rem;
            box-shadow: 12px 12px 12px;
        }

        .s {
            display: flex;
            justify-content: center;
        }
    </style>
</head>
<body>
<div>
    <h1>Add Bike to Repair List</h1>
    <label for="bikeid">Bike id: <?php 
    if (isset($_GET['rn']) && isset($_GET['studidno'])) {
      $bikeid = $_GET['rn'];
      $studidno = $_GET['studidno'];

      $sql="SELECT * from repairlist where bikeid= ?";
      $query=$conn->prepare($sql);
      $query->bind_param("s",$bikeid);
      $query->execute();

      if($query->affected_rows>0){
        echo "<script>alert('Bike is already on the list!'); window.location.href='history.php';</script>";
      }


    echo $bikeid ?></label><br>
    <label for="partInput">Check all that apply</label><br>
</div>
<div class="container">
<form action="inschecklist.php?bikeid=<?php echo $bikeid; ?>&studidno=<?php echo $studidno; }?>" method="POST" onsubmit="return confirmSubmit();">
        <div class="column">
        <fieldset>
        <h2>FRAMESET</h2>
        <input type="checkbox" id="frame" name="checklist[]" value="Frame">
        <label for="frame">Frame</label><br>
        <input type="checkbox" id="forks" name="checklist[]" value="Forks">
        <label for="forks">Forks</label><br>
        <input type="checkbox" id="headset" name="checklist[]" value="Headset">
        <label for="headset">Headset</label><br>
        <input type="checkbox" id="stem" name="checklist[]" value="Stem">
        <label for="stem">Stem</label><br>
        <input type="checkbox" id="handlebar" name="checklist[]" value="Handlebar">
        <label for="handlebar">Handlebar</label><br>
        <input type="checkbox" id="saddle" name="checklist[]" value="Saddle">
        <label for="saddle">Saddle</label><br>
        <input type="checkbox" id="seatPost" name="checklist[]" value="Seat post">
        <label for="seatPost">Seat post</label><br>
      </fieldset>
        </div>
        <div class="column">
        <fieldset>
        <h2>GROUPSET</h2>
        <input type="checkbox" id="frontMech" name="checklist[]" value="Front Derailleurs">
        <label for="frontMech">Front Derailleurs</label><br>
        <input type="checkbox" id="rearMech" name="checklist[]" value="Rear Derailleurs">
        <label for="rearMech">Rear Derailleurs</label><br>
        <input type="checkbox" id="frontBrakes" name="checklist[]" value="Brakeset">
        <label for="frontBrakes">Brakeset</label><br>
        <input type="checkbox" id="shifters" name="checklist[]" value="Brake Cable">
        <label for="shifters">Brake Cable</label><br>
        <input type="checkbox" id="shifters2" name="checklist[]" value="Shifters">
        <label for="shifters2">Shifters</label><br>
        <input type="checkbox" id="shiftersCable" name="checklist[]" value="Shifters Cable">
        <label for="shiftersCable">Shifters Cable</label><br>
        <input type="checkbox" id="cassetteHub" name="checklist[]" value="Cassette Hub">
        <label for="cassetteHub">Cassette Hub</label><br>
        <input type="checkbox" id="cogs" name="checklist[]" value="Cogs">
        <label for="cogs">Cogs</label><br>
        <input type="checkbox" id="crankset" name="checklist[]" value="Crankset">
        <label for="crankset">Crankset</label><br>
        <input type="checkbox" id="chain" name="checklist[]" value="Chain">
        <label for="chain">Chain</label><br>
        <input type="checkbox" id="pedals" name="checklist[]" value="Pedals">
        <label for="pedals">Pedals</label><br>
        <input type="checkbox" id="bottleCages" name="checklist[]" value="Bottle Cages">
        <label for="bottleCages">Bottle Cages</label><br>

      </fieldset>
        </div>
        <div class="column">
        <fieldset>
        <h2>WHEEL SET</h2>
        <input type="checkbox" id="wheels" name="checklist[]" value="Rims">
        <label for="wheels">Rims</label><br>
        <input type="checkbox" id="spokes" name="checklist[]" value="Spokes and Nipples">
        <label for="spokes">Spokes and Nipples</label><br>
        <input type="checkbox" id="tyres" name="checklist[]" value="Tires">
        <label for="tyres">Tires</label><br>
        <input type="checkbox" id="hub" name="checklist[]" value="Hub">
        <label for="hub">Hub</label><br>
        <input type="checkbox" id="spacers" name="checklist[]" value="Spacers">
        <label for="spacers">Spacers</label><br>
      </fieldset>
        </div>
        <div class="s">
            <input type="submit" value="Submit">
            <button onclick="cancel()">Cancel</button>
        </div>
    </form>
</div>

<script>
    function confirmSubmit() {
        return confirm("Are you sure you want to submit the form?");
    }
</script>

</body>
</html>
