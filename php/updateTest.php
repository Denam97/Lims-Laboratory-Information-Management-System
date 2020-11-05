<?php
include('config.php');

$test=$_POST['testname'];
$pname=$_POST['pname'];
$min = $_POST['min'];
$max = $_POST['maximum'];
$unit = $_POST['unit'];
$price = $_POST['price'];
$range = $min . " " . $max;

$sql= "UPDATE test SET printName='$pname',referenceRange='$range',unit='$unit',cost='$price' WHERE testName='$test'";

if ($conn->query($sql)  === TRUE) {
    echo "Update Success!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>