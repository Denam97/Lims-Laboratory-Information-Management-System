<?php
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'laboratory';

$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if (mysqli_connect_errno()) {
    die('Database connection failed ' . mysqli_connect_error());
}

$id = "-";
$nm = "-";
$cst = "-";
$tval = $_GET['tn'];
$q = $conn->query("SELECT testID, testName, cost FROM test WHERE testName='$tval'");

while ($row = $q->fetch_assoc()) {
    $id = $row['testID'];
    $nm = $row['testName'];
    $cst = $row['cost'];
}

$output = array(
    'id' => $id,
    'name' => $nm,
    'cost' => $cst
);

echo json_encode($output);
?>
