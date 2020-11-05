<?php
include('config.php');

$samp=$_POST['samp'];
$remark=$_POST['remark'];



$sql= "UPDATE `sample` SET remarks='$remark',status='finish' WHERE sampleNo='$samp'";

if ($conn->query($sql)  === TRUE) {
    echo "Success!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>