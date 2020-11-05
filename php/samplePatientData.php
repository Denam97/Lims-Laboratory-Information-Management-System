<?php
include('config.php');

$smp = $_POST['sample'];

$q2 = $conn->query("SELECT patient.fullname,patient.age,patient.tel,patient.gender,sample.referedBy,sample.branch,sample.date FROM patient INNER JOIN sample on patient.patientID=sample.patientID WHERE sample.sampleNo='$smp'");
if (mysqli_connect_errno()) {
    echo "Error: " . $q2 . "<br>" . $conn->error;
}
while ($r=mysqli_fetch_array($q2)) {
    $output[]=$r;
}

$conn->close();
echo json_encode($output);

?>