<?php
include('config.php');
$TName = $_POST['test'];

$sql = "DELETE FROM test WHERE testName = '$TName'";

if($conn->query($sql) === TRUE){
    echo "Test is Deleted!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>