<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

global $bikeid;
if (isset($_GET['rn'])) {
require_once 'connection.php';
$bikeid = $_GET['rn'];
$conn->close();

}
if ($_SERVER["REQUEST_METHOD"] == "POST") {


  $sql="INSERT INTO repairlist VALUES (?,?,)";
  $sql1 = "UPDATE bikeinfo SET stat = ? WHERE bikeid = ?";
          $query1 = $conn->prepare($sql2);
          $status = "undermaintenance";
          $query1->bind_param("ss", $status, $bikeid);
          $query1->execute();
  
  
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

    .con{
        margin:auto;
    }
    
</style>
<script>
var brokenParts = []; // Variable to store broken parts

function addPart() {
  var partInput = document.getElementById("partInput");
  var partList = document.getElementById("partList");
  var partText = partInput.value;

  if (partText !== '') {
    var partItem = document.createElement("li");
    var checkbox = document.createElement("input");
    checkbox.type = "checkbox";
    checkbox.onclick = function() {
      togglePartStatus(checkbox);
    };

    partItem.appendChild(checkbox);
    partItem.appendChild(document.createTextNode(partText));
    partList.appendChild(partItem);
    partInput.value = '';
  }
  return;
}

function togglePartStatus(checkbox) {
  var partText = checkbox.nextSibling.textContent;

  if (checkbox.checked) {
    brokenParts.push(partText);
  } else {
    var index = brokenParts.indexOf(partText);
    if (index !== -1) {
      brokenParts.splice(index, 1);
    }
  }

  console.log(brokenParts);
}

function saveBrokenParts(event) {
  event.preventDefault();

  if (brokenParts.length === 0) {
    alert("Checklist is empty. Please check broken parts before saving.");
    return;
  }

  var xhr = new XMLHttpRequest();
  var url = "saveparts.php?bikeid=" + encodeURIComponent(<?php echo $bikeid; ?>);
  var params = "brokenParts=" + JSON.stringify(brokenParts);
  xhr.open("POST", url, true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 && xhr.status == 200) {
      console.log(xhr.responseText); // Optional: Output the response from the server
    }
  };

  xhr.send(params);

  var form = event.target.form;
  form.submit();
}



</script>

<!DOCTYPE html>
<html>
<head>
    <title>Add Bike to Repair List</title>
</head>
<body>
    <div class="con">
<form>
    <div>
    <h1>Add Bike to Repair List</h1>
    <label for="bikeid">Bike id: </label>
    <?php echo $bikeid; ?><br>
    <label for="partInput">Enter Broken Part:</label><br>
    <input type="text" id="partInput">
    <button onclick="addPart()">Add Part</button>
</div>
    
    <div>
       <ul id="partList"></ul> 
    </div>
    <input type="submit" onclick="saveBrokenParts(event)" value="Save Broken Parts">
</form>
    
    <button onclick="/bikelist.php">Cancel</button>
    <h1 id="k"></h1>


</div>
</body>
</html>
