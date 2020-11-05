<?php
include('config.php');
$gnm= $_POST['gnm'];

$ttable = stripcslashes($_POST['tn']);

$ttable = json_decode($ttable, TRUE);

for ($i = 0; $i < sizeof($ttable); $i++) {

    $query3 = "INSERT INTO testGroup VALUES('" . $gnm . "','" . $ttable[$i][0] . "')";
    if ($conn->query($query3)  === TRUE) {
        if ($i == (sizeof($ttable) - 1)) {
            echo "Test Group added!";
        }
    } else {
        echo "Error: " . $query3 . "<br>" . $conn->error;
    }
}
$conn->close();
?>