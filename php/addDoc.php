<?php
include('config.php');

$docnm=$_POST['Docname'];
$doctel=$_POST['DocTel'];


$sql="INSERT INTO doc VALUES('','". $docnm."','". $doctel."','0')";

if ($conn->query($sql)  === TRUE) {
    echo "Done!";
} else {
    echo "Error: " . $query3 . "<br>" . $conn->error;
}
$conn->close();
?>