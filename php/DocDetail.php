<?php
include('config.php');

$mnth = $_POST['month'];
$year=$_POST['year'];
$q = $conn->query("SELECT doc.DocName,COUNT(sample.sampleNo),SUM(sample.total) FROM sample INNER JOIN doc on sample.referedBy=doc.DocName WHERE MONTH(sample.date) = '$mnth' AND Year(sample.date)='$year'");

if (mysqli_connect_errno()) {
    echo "Error: " . $q . "<br>" . $conn->error;
}

while($row=mysqli_fetch_array($q)){
    $output[]=$row;
}

$conn->close();
echo json_encode($output);

?>