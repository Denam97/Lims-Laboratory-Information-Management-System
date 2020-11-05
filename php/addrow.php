<?php
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'laboratory';

$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if (mysqli_connect_errno()) {
    die('Database connection failed ' . mysqli_connect_error());
}

$tval = $_GET['tn'];

$qcheck = $conn->query("SELECT DISTINCT(groupName) FROM testgroup WHERE groupName='$tval'");

if (mysqli_connect_errno()) {
    echo "Error: " . $qcheck . "<br>" . $conn->error;
}

while ($rowcheck = mysqli_fetch_array($qcheck)) {
    $value[] = $rowcheck;
}

// if($value[0][0] == $tval){
    $q = $conn->query("SELECT test.testID,test.testName,test.cost FROM test INNER JOIN testgroup on test.testName=testgroup.test WHERE testgroup.groupName='$tval'");

    if (mysqli_connect_errno()) {
        echo "Error: " . $q . "<br>" . $conn->error;
    }

    while ($row = mysqli_fetch_array($q)) {
        $output[] = $row;
    } 
// }else{
    $q = $conn->query("SELECT testID, testName, cost FROM test WHERE testName='$tval'");

    if (mysqli_connect_errno()) {
        echo "Error: " . $q . "<br>" . $conn->error;
    }

    while ($row = mysqli_fetch_array($q)) {
        $output[] = $row;
    }
// }



echo json_encode($output);
?>