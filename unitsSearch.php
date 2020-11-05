<?php
include("config.php");

// $searchTerm = $_GET['term'];

$query = $conn->query("SELECT units FROM DataToFill");
while ($row = $query->fetch_assoc()) {
    $data[] = $row['units'];
}
echo json_encode($data);
?>