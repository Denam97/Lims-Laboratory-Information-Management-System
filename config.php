<?php
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'laboratory';

$conn = new mysqli($dbHost,$dbUsername,$dbPassword,$dbName);

if (mysqli_connect_errno()) {
    die('Database connection failed '. mysqli_connect_error());
}
?>