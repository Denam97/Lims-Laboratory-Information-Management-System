<?php
include('config.php');

$sample = $_POST['sno'];
$firstname = $_POST['fname'];
$lastname = $_POST['lname'];
$age = $_POST['age'];
$referall = $_POST['refer'];
$referarr = explode(" ", $referall);
$refer = $referarr[0];
$branch = $_POST['branch'];
$gender = $_POST['gender'];
$tel = $_POST['tel'];
$total = $_POST['total'];

$done = 0;

//check old customer
$status = "-";
$check = $conn->query("SELECT patientID,tel from patient where tel=$tel");
while ($find = $check->fetch_assoc()) {
    $status = $find['tel'];
    $id1 = $find['patientID'];
}

$Date = date('Y-m-d');

if ($status != $tel) {


    //New patient ID
    $count = $conn->query("SELECT COUNT(patientID) AS pid FROM patient");
    while ($row = $count->fetch_assoc()) {
        $id = $row['pid'];
    }
    $id = $id + 1;

    //data Insertion
    $query1 = "INSERT INTO patient VALUES($id,'" . $firstname . " " . $lastname . "',$age,$tel,'$gender')";
    $query2 = "INSERT INTO sample VALUES('" . $sample . "','" . $id . "','" . $Date . "','$total','" . $refer . "','pending','','$branch')";



    if ($conn->query($query1) === TRUE) {
        echo "Registration ";
    } else {
        echo "Error: " . $query1 . "<br>" . $conn->error;
    }
    if ($conn->query($query2) === TRUE) {
        echo "Successfull";
    } else {
        echo "Error: " . $query2 . "<br>" . $conn->error;
    }
} else {

    $queryelse = "INSERT INTO sample VALUES('" . $sample . "','" . $id1 . "','" . $Date . "','$total','" . $refer . "','pending','','" . $branch . "')";


    if ($conn->query($queryelse) === TRUE) {
        echo "Registration Successfull";
    } else {
        echo "Error";
    }
}


$ttable = stripcslashes($_POST['tn']);

$ttable = json_decode($ttable, TRUE);

for ($i = 0; $i < sizeof($ttable); $i++) {

    $query3 = "INSERT INTO testlist VALUES('" . $sample . "','" . $ttable[$i][0] . "','0')";
    if ($conn->query($query3)  === TRUE) {
        $done = $done + 1;
    } else {
        echo "Error: " . $query3 . "<br>" . $conn->error;
    }
}

echo "  ".$done . " Tests added";
?>