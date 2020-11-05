<?php
include("config.php");

$searchTerm = $_GET['term'];

$query = $conn->query("SELECT testName FROM test WHERE testName LIKE '%".$searchTerm."%' ORDER BY testName ASC");
while ($row = $query->fetch_assoc()) {
    $data[] = $row['testName'];
}

$query = $conn->query("SELECT DISTINCT(groupName) FROM testgroup WHERE groupName LIKE '%" . $searchTerm . "%' ORDER BY groupName ASC");
while ($row = $query->fetch_assoc()) {
    $data[] = $row['groupName'];
}
echo json_encode($data);
?>