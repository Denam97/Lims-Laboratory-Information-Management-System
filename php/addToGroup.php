<?php
include('config.php');
$grp=$_POST['grp'];
$tst=$_POST['tst'];

$sql= "INSERT INTO testgroup(groupName, test) VALUES ('$grp','$tst')";

if ($conn->query($sql)  === TRUE) {
    echo "Test Added!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();

?>