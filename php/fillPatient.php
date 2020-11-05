<?php
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'laboratory';

$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if (mysqli_connect_errno()) {
    die('Database connection failed ' . mysqli_connect_error());
}

$name = "-";
$age = "-";
$gender = "-";
$tel = "-";

$tval = $_GET['ptn'];
$q = $conn->query("SELECT `fullname`, `age`, `tel`, `gender` FROM `patient` WHERE fullname='$tval'");

while ($row = $q->fetch_assoc()) {
    $name = $row['fullname'];
    $age = $row['age'];
    $tel = $row['tel'];
    $gender = $row['gender'];

}

$output = array(
    'name' => $name,
    'age' => $age,
    'tel' => $tel,
    'gender' => $gender
);

echo json_encode($output);
?>