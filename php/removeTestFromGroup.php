<?php
include('config.php');
$grp=$_POST['grp'];
$del=$_POST['del'];

$sql= "DELETE FROM `testgroup` WHERE groupName='$grp' AND test='$del'";

if ($conn->query($sql)  === TRUE) {
    echo "Test Removed!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>