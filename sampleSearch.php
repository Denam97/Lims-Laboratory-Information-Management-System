<?php
include("config.php");

$searchTerm = $_GET['term'];

$query = $conn->query("SELECT sampleNo FROM sample WHERE sampleNo LIKE '%".$searchTerm. "%' AND status='pending' ORDER BY sampleNo ASC");
while ($row = $query->fetch_assoc()) {
    $data[] = $row['sampleNo'];
}

if (mysqli_connect_errno()) {
    echo "Error: " . $query . "<br>" . $conn->error;
}
echo json_encode($data);
?>