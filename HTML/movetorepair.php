<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require('connection.php');

global $bikeid;
if (isset($_GET['rn']) && isset($_GET['studidno']) && isset($_GET['studfname'])) {
    $bikeid = $_GET['rn'];
    $studidno = $_GET['studidno'];
    $studfname = $_GET['studfname'];
}

?>
<style>
    .con {
        margin: auto;
    }
</style>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Adding Bike to Repair List</title>
</head>
<body>
    <div class="con">
        
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
          <form action="">
            <input type="submit" onclick="saveBrokenParts(event)" value="Confirm">
        </form>
        <button onclick="cancel()">Cancel</button>
        <h1 id="k"></h1>
    </div>

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

  if (confirm("Confirm?") == true) {

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
alert('Bike added to the list!');
window.loaction.href="repairlist.php";
} else {
  alert('Action canceled');
}

  if (brokenParts.length === 0) {
    alert("Checklist is empty. Please check broken parts before saving.");
    return;
  }
</script>

</body>
</html>
<?php



?>



