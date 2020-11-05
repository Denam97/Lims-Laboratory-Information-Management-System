<?php
include('config.php');
$data=stripcslashes($_POST['tn']);

$data=json_decode($data,TRUE);
$sample=1;


for ($i = 0; $i < sizeof($data); $i++) {

    $query3 = "INSERT INTO testlist VALUES('" . $sample . "','" . $data[$i][0] . "','0')";
    if ($conn->query($query3)  === TRUE) {
        echo "Done";
    } else {
        echo "Error: " . $query3 . "<br>" . $conn->error;
    }
}


?>