<?php
include('config.php');

$test=$_POST['testname'];
$pname=$_POST['pname'];
$min = $_POST['min'];
$max = $_POST['maximum'];
$unit = $_POST['unit'];
$price = $_POST['price'];
$range = $min ." ". $max;

$sql="INSERT INTO test VALUES('0','".$test."','".$pname."','".$range."','".$unit."','".$price."')";

if ($conn->query($sql)  === TRUE) {
    echo "Done!";
} else {
    echo "Error: " . $query3 . "<br>" . $conn->error;
}
$conn->close();
?>