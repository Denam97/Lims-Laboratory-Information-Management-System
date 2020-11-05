<?php
include("config.php");
$month=$_POST["month"];
$year=$_POST["year"];

$query=$conn->query("SELECT doc.DocName,doc.tel,COUNT(sample.sampleNo),SUM(sample.total),docmonthpay.paidamount FROM sample INNER JOIN doc on sample.referedBy=doc.DocID INNER JOIN docmonthpay ON doc.Docname=docmonthpay.DocName WHERE MONTHNAME(sample.date) = '$month' AND Year(sample.date)='$year' GROUP BY doc.DocName");
if (mysqli_connect_errno()) {
    echo "Error: " . $query . "<br>" . $conn->error;
}

while ($row = $query->fetch_array()) {
    $output[] = $row;
}

echo json_encode($output);
?>