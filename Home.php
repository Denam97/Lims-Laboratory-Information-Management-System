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


<!doctype html>
<html lang="en">

<head>

    <title>Home</title>

    <link href="css/home.css" rel="stylesheet" type="text/css">
    <link href="css/jquery-ui.css" rel="stylesheet">
    <script src="html2pdf.js-master/dist/html2pdf.bundle.min.js"></script>
    <script src="jquery-3.4.1.min.js"></script>
    <script src="jquery-ui.js"></script>
    <script src="jquery.json.min.js"></script>
</head>

<body>

    <div class="container-home" id="container-home">

        <div class="searchbar">
            <input type="text" id="patsearch">
            <button name="searchnm" id="searchbtn">&OverBar;</button>

        </div>


        <form class="mainform" action="" name="patientadd" id="patientadd" method="POST">
            <div class="patient" method="POST">
                <table class="formtable">

                    <tr>
                        <td>
                            Sample No. :</td>
                        <td>
                            <input type="text" id="sno" name="sno" value="<?php echo (isset($newval)) ? $newval : ''; ?>" required>
                        </td>


                        <td>Age :</td>
                        <td>
                            <input type="number" id="age" name="age" required>
                        </td>


                    </tr>
                    <tr>
                        <td>First Name :</td>
                        <td>
                            <input type="text" id="fname" name="fname" required>
                        </td>

                        <td>Gender :</td>
                        <td>
                            <input type="radio" id="male" name="gender" value="male">Male
                            <input type="radio" id="female" name="gender" value="female">Female
                        </td>


                    </tr>
                    <tr>
                        <td>Last Name :</td>
                        <td>
                            <input type="text" id="lname" name="lname" required>
                        </td>

                        <td>Contact No :</td>
                        <td>
                            <input type="tel" id="tel" name="tel" required>
                        </td>



                    <tr>
                        <td>Refered By :</td>
                        <td>
                            <input type="text" id="refer" name="refer" required>
                            <button id="docBtn"></button>
                        </td>

                        <td>Branch :</td>
                        <td>
                            <input type="text" id="branch" name="branch" required>
                        </td>
                    </tr>
                    <tr>

                        <td>Test Name :
                        </td>
                        <td>
                            <input type="text" id="testnames" name="testnames">

                        </td>
                        <td><button name="add" id="add">ADD</button></td>
                    </tr>

                </table>

            </div>



            <div class="main">

                <div class="tablecover split">
                    <table class="testtable" name="testtable" id="testtable">
                        <thead>
                            <th>Test ID</th>
                            <th>Test Name</th>
                            <th>Cost</th>
                            <th id="remove-column" class="remove-column"></th>
                        </thead>

                        <tbody class="xy">

                        </tbody>


                    </table>
                </div>

                <div class="sum">

                    <p class="tt">Total <br>
                    </p><input type="text" name="total" id="total">

                    <p><b><span style="margin-left: 20px;">Discount :</span></b><input type="number" name="discount" id="discount">%</p>
                    <p><input type="submit" value="Submit" id="submitbtn"></p>



                </div>
            </div>
        </form>
        <div class="docAdd" id="docAdd">
            <div class="content-home">
                <div class="close-div-home"><span class="close-home">&times;
                    </span>
                </div>

                <span id="tst">Add Doctor</span>

                <form method="POST" id="Doc-details">

                    <label for="Docname">Doctor Name : <input type="text" id="Docname" name="Docname" required></label>
                    <br>
                    <label for="DocTel">Contact No. : <input type="text" id="DocTel" name="DocTel" required></label>
                    <br>
                    <input type="reset" value="Clear" id="Doc-clear">
                    <input type="submit" value="Submit" id="Doc-submit">
                </form>
            </div>

        </div>


        <div id="print-main-home" class="print-main-home">
            <div class="close-div-home"><span class="close2">&times;
                </span>
            </div>


            <div class="Print-preview-h" id="Print-preview-h">
                <div id="print-pt">
                    ---------------------------------------------------------------------------------------------------------------------------
                    <p style="font-size: 17px;font-weight: bold;text-align: center;">LAB INVESTIGATION-RECEIPT</p>
                    ---------------------------------------------------------------------------------------------------------------------------
                    <br>
                    <p style="text-align: center;">ABC Laboratory - KURUNEGALA</p>
                    <p style="text-align: center;">TEL -646546848, 546846645</p>
                    <p style="text-align: center;">E-MAIL - abc@123.com</p>
                    <p style="text-align: center;font-size: 15px;"><?php echo date("Y/m/d H:i:sa"); ?></p>
                    <br>
                    <table class="print-data-main-home">

                    </table>

                    <div class="tbl-print-home">
                        <table id="myTable-print-home">

                            <thead>
                                <th>Test Name</th>
                                <th>Cost</th>
                            </thead>

                            <tbody id="table-content-print">
                            </tbody>
                        </table>

                    </div>

                    <br>
                    <br>

                    <table class="print-cost">

                    </table>
                    <br>
                    <br>.................
                    <p style="font-size: 13px;color: gray;">cashier </p>
                    ---------------------------------------------------------------------------------------------------------------------------
                    <br><br>
                </div>
                <button id="print">Print</button>
            </div>

        </div>


    </div>



    <script type="text/javascript">
        $(function() {
            $("#patsearch").autocomplete({
                source: 'search.php'
            });
        });

        $(function() {
            $("#testnames").autocomplete({
                source: 'testsearch.php'
            });
        });

        $(function() {
            $("#refer").autocomplete({
                source: 'refer.php'
            });
        });
    </script>

    <script>
        //add to table
        $(document).ready(function() {


            $('#searchbtn').click(function(e) {

                var x = $('#patsearch').val();
                $.ajax({

                    url: "php/fillPatient.php?ptn=" + x + "",
                    method: "get",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(data) {

                        if (data.name != "-") {
                            var split = data.name.split(" ");
                            document.getElementById('fname').value = split[0];
                            document.getElementById('lname').value = split[1];
                            document.getElementById('age').value = data.age;
                            document.getElementById('tel').value = data.tel;
                            if (data.gender == "male") {
                                document.getElementById('male').checked = true;
                            } else {
                                document.getElementById('female').checked = true;
                            }

                        }

                    }
                })
            });


            //Popup for Doctor details
            $('#docBtn').click(function(e) {
                e.preventDefault();
                var span = document.getElementsByClassName("close-home")[0];
                span.onclick = function() {
                    modal.style.display = "none";
                }
                var modal = document.getElementById("docAdd");
                modal.style.display = "block";
            });


            //new doctor add
            $('#Doc-details').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    method: "POST",
                    url: "php/addDoc.php",
                    data: $(this).serialize(),
                    success: function(data) {
                        document.getElementById('Docname').value = "";
                        document.getElementById('DocTel').value = "";
                        var modal = document.getElementById("docAdd");
                        modal.style.display = "none";

                    }
                })
            });


            //add test to table
            $('#add').click(function(e) {
                e.preventDefault();
                var x = $('#testnames').val();
                var count = 0;

                //Duplicate entry skip
                $('#testtable tr').each(function(row, tr) {
                    if (x == $(tr).find('td:eq(1)').text()) {
                        count = count + 1;
                    }

                });


                if (count == 0) {

                    $.ajax({

                        url: "php/addrow.php?tn=" + x + "",
                        method: "get",
                        data: $(this).serialize(),
                        dataType: "json",
                        success: function(data) {

                            for (let i = 0; i < data.length; i++) {
                                var html = '<tr>';
                                html += '<td>' + data[i][0] + '</td>';
                                html += '<td>' + data[i][1] + '</td>';
                                html += '<td class="cst">' + parseFloat(data[i][2]).toFixed(2) + '</td>';
                                html += '<td><input type="button" value="X" class="remove"></td></tr>';


                                $('.xy').append(html);

                                var totalcst = Number(document.getElementById('total').value) + Number(data[i][2]);
                                totalcst = parseFloat(totalcst).toFixed(2);
                                document.getElementById('total').value = totalcst;
                            }
                            document.getElementById('testnames').value = "";


                        }
                    })
                } else {
                    alert("You have selected this test before!");
                }
            });




            //remove button
            $('.testtable .xy').on('click', '.remove', function(e) {
                e.preventDefault();

                var costremove = parseFloat($(this).closest('tr').find('.cst').text());
                var total = parseFloat(document.getElementById("total").value);
                document.getElementById("total").value = (total - costremove);
                $(this).closest('tr').remove();

            });

        });
    </script>

    <script>
        //add Patient

        $(document).ready(function() {


            //print btn
            $('#print').click(function(e) {

                var today = new Date().toISOString().slice(0, 10);
                var fullname = document.getElementById('fname').value + " " + document.getElementById('lname').value + " " + today;
                const toPrint = document.getElementById('print-pt');

                html2pdf().set({
                    margin: 2,
                    jsPDF: {
                        format: 'a5'
                    }
                }).from(toPrint).save(fullname + '.pdf');
                    
                // document.getElementById('patientadd').reset();
                // document.getElementById('total').value = "";
                // document.getElementById('discount').value = "";


            });


            $('#patientadd').submit(function(e) {
                e.preventDefault();
                //print
                var gender = "Mrs."
                if (document.getElementsByName('gender').checked) {
                    gender = "Mr."
                }
                var sampleNo = document.getElementById('sno').value;
                var fullname = gender + " " + document.getElementById('fname').value + " " + document.getElementById('lname').value;
                var refer = document.getElementById('refer').value;
                var age = document.getElementById('age').value;
                var tel = document.getElementById('tel').value;

                var branch = document.getElementById('branch').value;
                var totalString = document.getElementById('total').value;
                var total = parseFloat(totalString).toFixed(2);


                $('.print-data-main-home tr').remove();
                $('#table-content-print tr').remove();
                $('.print-cost tr').remove();


                //tests data


                var modal = document.getElementById("print-main-home");

                var span = document.getElementsByClassName("close2")[0];
                span.onclick = function() {
                    modal.style.display = "none";
                }

                //table
                function fv2() {
                    var ar = new Array();

                    $('#testtable tr').each(function(row, tr) {

                        ar[row] = {
                            0: $(tr).find('td:eq(1)').text(),
                            1: $(tr).find('td:eq(2)').text(),

                        }
                    });
                    ar.shift();
                    return ar;
                }

                var data = fv2();

                //discount
                var res = parseFloat(document.getElementById('discount').value);

                if (isNaN(res)) {
                    res = 0;
                }
                var gtotal = (total - (total * res) / 100);
                gtotal = parseFloat(gtotal).toFixed(2);


                var html1 = '<tr><td><b>Sample No :</b></td><td>' + sampleNo + '</td></tr><tr><td><b>Full Name :</b></td><td>' + fullname + '</td></tr><tr><td><b>Age :</b></td><td>' + age + ' years</td></tr><tr><td><b>Contact No. :</b></td><td>' + tel + '</td></tr><tr><td><b>Refered By :</b></td><td>' + refer + '</td></tr><tr><td><b>Branch :</b></td><td>' + branch + '</td></tr>';
                $('.print-data-main-home').append(html1);

                for (let i = 0; i < data.length; i++) {

                    var html = '<tr>';
                    html += '<td>' + data[i][0] + '</td>';
                    html += '<td>' + data[i][1] + '</td>';
                    html += '</tr>';

                    $('#table-content-print').append(html);
                }

                var html2 = '<tr><td><b>Total :</b></td><td>' + total + '</td></tr>';
                html2 += '<tr><td><b>Discount :</b></td><td>' + res + '%</td></tr>';
                html2 += '<tr><td><b>Grand Total :</b></td><td style:"border-bottom: 1px double rgb(133, 133, 133);border-top: 1px solid rgb(133, 133, 133);">' + gtotal + '</td></tr>';

                $('.print-cost').append(html2);


                //end print


                var tbld;
                tbld = fv();
                tbld = $.toJSON(tbld);

                function fv() {
                    var ar = new Array();

                    $('#testtable tr').each(function(row, tr) {

                        ar[row] = {
                            0: $(tr).find('td:eq(1)').text(),

                        }
                    });
                    ar.shift();
                    return ar;
                }

                $.ajax({
                    type: "post",
                    url: "php/addPatient.php",
                    data: "tn=" + tbld + "&" + $(this).serialize(),
                    success: function(data) {
                        if (data.split(" ")[0] != "Registration") {
                            alert(data);
                        } else {
                            // $('.xy tr').remove();
                            // document.getElementById('sno').value = parseInt(sampleNo) + 1;

                            // document.getElementById('age').value = '';
                            // document.getElementById('fname').value = '';

                            // document.getElementsByName('gender')[0].checked = false;
                            // document.getElementsByName('gender')[1].checked = false;

                            // document.getElementById('lname').value = '';
                            // document.getElementById('tel').value = '';
                            // document.getElementById('refer').value = '';
                            // document.getElementById('branch').value = '';
                            // document.getElementById('testnames').value = '';


                            modal.style.display = "block";
                        }
                    },
                    fail: function() {
                        alert('Error --> ajax');
                    }
                })

            });

        });
    </script>

</body>

</html>