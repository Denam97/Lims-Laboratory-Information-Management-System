<?php
include("config.php");

$searchTerm = $_GET['term'];

$query = $conn->query("SELECT DocID,DocName FROM doc WHERE DocName LIKE '%".$searchTerm. "%' ORDER BY DocName ASC");
while ($row = $query->fetch_assoc()) {
    $data[] = $row['DocID']." ".$row['DocName'];
}
echo json_encode($data);
