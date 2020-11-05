<?php
include('config.php');

$tval = $_GET['grp'];
$q = $conn->query("SELECT test FROM testgroup WHERE groupName='$tval'");

if (mysqli_connect_errno()) {
    echo "Error: " . $q . "<br>" . $conn->error;
}
$i=0;
while ($row = $q->fetch_assoc()) {
    $output[$i] = $row['test'];
    $i++;
}

$conn->close();
echo json_encode($output);
?>