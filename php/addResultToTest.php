<?php
include('config.php');
$test = $_POST['test'];
$res=$_POST['res'];
$sample=$_POST['sample'];
$sql= "UPDATE testlist SET result='$res' WHERE testName='$test' AND sampleNo='$sample'";

if ($conn->query($sql)  === TRUE) {
    echo "Success";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>