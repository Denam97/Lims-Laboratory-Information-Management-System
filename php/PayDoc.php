<?php
include("config.php");

$doc = $_POST['doc'];
$pay = $_POST['pay'];
$total = $_POST['total'];
$month = $_POST['month'];

$sql = "INSERT INTO docmonthpay VALUES('$doc', '$month', '$total', '$pay','paid')";

if ($conn->query($sql) == TRUE) {
    echo "Paid";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$sql1 = "UPDATE doc SET totalPaid=(totalPaid+$pay) WHERE DocName='$doc'";

if($conn->query($sql1) == TRUE){
    echo "!!!";
}else{
    echo "Error: " . $sql1 . "<br>" . $conn->error;
}
$conn->close();
?>