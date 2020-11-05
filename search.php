<?php
include("config.php");

$searchTerm = $_GET['term'];

$query = $conn->query("SELECT fullname FROM patient WHERE fullname LIKE '%".$searchTerm."%' ORDER BY fullname ASC");
while ($row = $query->fetch_assoc()) {
    $data[] = $row['fullname'];
}
echo json_encode($data);
?>