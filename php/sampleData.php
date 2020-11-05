<?php
include('config.php');

$smp = $_POST['sample'];
$q = $conn->query("SELECT testlist.testName as testName,test.unit as unit,test.referenceRange as 'range',testlist.result as result FROM testlist INNER JOIN test ON testlist.testName=test.testName WHERE sampleNo='$smp'");

if (mysqli_connect_errno()) {
    echo "Error: " . $q . "<br>" . $conn->error;
}

while($row=mysqli_fetch_array($q)){
    $output[]=$row;
}

$conn->close();
echo json_encode($output);

?>