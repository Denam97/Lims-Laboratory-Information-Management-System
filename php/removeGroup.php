<?php
include('config.php');

$del=$_GET['del'];

$sql= "DELETE FROM `testgroup` WHERE groupName='$del'";

if ($conn->query($sql)  === TRUE) {
    echo "Test group Deleted!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>