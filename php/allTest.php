<?php
include('config.php');

$smp = $_POST['Sdate'];
$q = $conn->query("SELECT sample.sampleNo, sample.date, sample.total, sample.referedBy, sample.status,  sample.branch, patient.fullname FROM `sample` INNER JOIN patient on sample.patientID=patient.patientID WHERE sample.date='$smp'");

if (mysqli_connect_errno()) {
    echo "Error: " . $q . "<br>" . $conn->error;
}

while($row=mysqli_fetch_array($q)){
    $output[]=$row;
}

$conn->close();
echo json_encode($output);

?>