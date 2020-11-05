<?php
include("config.php");
session_start();

if (!(isset($_SESSION['user_id']))) {
    header("Location: ./login.php");
}
$result = $conn->query("SELECT COUNT(DISTINCT(sampleNo)) as sampleNo FROM sample");

while ($row = $result->fetch_assoc()) {
    $val = $row['sampleNo'];
}
$newval = $val + 1;

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="css/home.css" rel="stylesheet" type="text/css">
    <link href="css/refer.css" rel="stylesheet" type="text/css">
    <link href="css/test.css" rel="stylesheet" type="text/css">
    <link href="css/testgroup.css" rel="stylesheet" type="text/css">
    <link href="css/testmanagement.css" rel="stylesheet" type="text/css">
    <link href="css/testresults.css" rel="stylesheet" type="text/css">
    <link href="css/workflow.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="css/main.css">

    <link href="css/jquery-ui.css" rel="stylesheet">
    <script src="html2pdf.js-master/dist/html2pdf.bundle.min.js"></script>
    <script src="jquery-3.4.1.min.js"></script>
    <script src="jquery-ui.js"></script>
    <script src="jquery.json.min.js"></script>
</head>

<body>
    <header id="header" class="page-topbar">
        <ul id="left-nav">
            <a href="">LOGO</a>

        </ul>

        <ul id="right-nav">
            <li style="color: white;border:1px solid grey;">HI "DENAM font, style"</li>
            <li><a id="logout" href="php/logout.php">Logout</a></li>
        </ul>

    </header>

    <div class="main-body">

        <!-- The sidebar -->
        <div class="sidebar">

            <li id="patreg"><a>Patient Registration</a></li>
            <li id="testResult"><a>Test Results</a></li>
            <li id="workflow"><a>Workflow</a></li>
            <li id="TestManage"><a>Test Management</a></li>
            <div id="pinner" class="pinner">

                <ul class="dropdown">

                    <li id="newTest"><a>New Test</a> </li>
                    <li id="editTest"><a>Edit Test</a> </li>
                    <li id="testGrp"><a>Test Group</a></li>
                </ul>

            </div>


            <li id="pay"><a>Doctor Pay</a></li>
        </div>

        <!-- Page content -->

        <div class="content1">
            <div class="cover-main">

            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $('#patreg').click(function(e) {
                e.preventDefault();
                $('.cover-main div').remove();
                $('.cover-main').load('Home.php');
            });

            $('#workflow').click(function(e) {
                e.preventDefault();
                $('.cover-main div').remove();
                $('.cover-main').load('WorkFlow.php');
            });

            $('#newTest').click(function(e) {
                e.preventDefault();
                $('.cover-main').load('test.php');
            });

            $('#testGrp').click(function(e) {
                e.preventDefault();
                $('.cover-main').load('testgroup.php');
            });

            $('#testResult').click(function(e) {
                e.preventDefault();
                $('.cover-main div').remove();
                $('.cover-main').load('testresults.php');
            });

            $('#editTest').click(function(e) {
                e.preventDefault();
                $('.cover-main div').remove();
                $('.cover-main').load('manageTest.php');
            });
            $('#pay').click(function(e) {
                e.preventDefault();
                $('.cover-main div').remove();
                $('.cover-main').load('ReferedBy.php');
            });

            $('#TestManage').click(function(e) {
                e.preventDefault();
                var model = document.getElementById("pinner");
                if (model.style.display === "block") {
                    model.style.display = "none";
                } else {
                    model.style.display = "block";
                }
            });
        });
    </script>
</body>

</html>