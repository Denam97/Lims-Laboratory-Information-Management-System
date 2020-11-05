<!DOCTYPE html>
<html>

<head>
    <title>Doctors Payee</title>
    <link href="css/refer.css" rel="stylesheet" type="text/css">
    <link href="css/jquery-ui.css" rel="stylesheet">
    <script src="html2pdf.js-master/dist/html2pdf.bundle.min.js"></script>
    <script src="jquery-3.4.1.min.js"></script>
    <script src="jquery-ui.js"></script>
    <script src="jquery.json.min.js"></script>

</head>

<body>

    <div class="allBody">

        <div class="container-refer">

            <div class="search-refer">
                <p>Doctor Name <input type="text" id="searchbar" name="searchbar" onkeyup="loadDoc();"></p>


                <div class="viewcover" id="viewcover">
                    <table class="viewDoc" id="viewDoc" onmousedown="selecter();">

                        <thead id="viewDocHead">
                            <tr>
                                <th>Doctor Name</th>
                                <th>Contact No</th>
                                <th>Samples Refered</th>
                                <th>Cost of all Samples</th>
                            </tr>
                        </thead>

                        <tbody id="docBody" class="DBody">

                            <?php
                            include("config.php");
                            $mnth = date('m');
                            $year = date('Y');
                            $sql = "SELECT doc.DocName,doc.tel,COUNT(sample.sampleNo),SUM(sample.total) FROM sample INNER JOIN doc on sample.referedBy=doc.DocID WHERE MONTH(sample.date) = '$mnth' AND Year(sample.date)='$year' GROUP BY doc.DocName";

                            if ($result = $conn->query($sql)) {

                                while ($row = $result->fetch_row()) {
                                    echo "<tr>
                                <td>$row[0]</td>
                                <td>$row[1]</td>
                                <td>$row[2]</td>
                                <td>" . number_format((float)$row[3], 2, '.', '') . "</td>
                              </tr>";
                                }
                                $result->free_result();
                            } else {
                                echo "Error!";
                            }
                            $conn->close();

                            ?>

                        </tbody>

                    </table>
                    <script>
                        function selecter() {
                            var table = document.getElementById('viewDoc');

                            for (var i = 1; i < table.rows.length; i++) {
                                table.rows[i].onclick = function() {

                                    document.getElementById("DocName").value = this.cells[0].innerText;
                                    document.getElementById("tel").value = this.cells[1].innerText;
                                    document.getElementById("samples").value = this.cells[2].innerText;
                                    document.getElementById("tcost").value = this.cells[3].innerText;

                                };
                            }
                        }
                    </script>
                </div>

            </div>


            <div class="test1-refer">
                <div class="dt">
                    <p class="my"> Month :<input type="text" id="month">
                        Year :<input type="text" id="year"> <button id="find">Find</button><button id="clear-all">Clear</button><br>
                        <span id="records-tag">[*For previous Records.]</span></p>

                </div>

                <form class="test-refer" name="testform" id="testform" method="POST">

                    <table class="formtable">

                        <tr>
                            <td>
                                Doctor Name :</td>
                            <td>
                                <input type="text" id="DocName" name="DocName">
                            </td>



                        </tr>
                        <tr>
                            <td>Contact No :</td>
                            <td>
                                <input type="text" id="tel" name="tel">
                            </td>




                        </tr>
                        <tr>
                            <td>Samples count :</td>
                            <td>
                                <input type="text" id="samples" name="samples">
                            </td>




                        <tr>
                            <td>Total Cost :</td>
                            <td>
                                <input type="text" id="tcost" name="tcost">
                                <input type="text" id="percentage" name="percentage" placeholder="&percnt;">
                                <button id="calbtn">Cal</button>
                            </td>


                        </tr>

                        <tr>
                            <td>Pay :</td>
                            <td>
                                <input type="text" id="pay-doc" name="pay">
                            </td>


                        </tr>


                    </table>


                    <input type="reset" value="Clear" id="clear">
                    <input type="button" value="Submit" id="DocPay">


                </form>

            </div>
            <div id="print-main-refer" class="print-main-refer">
                <div class="content-refer">
                    <div class="close-div"><span class="close-refer">&times;
                        </span>
                    </div>
                    <div class="Print-preview" id="Print-preview">
                        ---------------------------------------------------------------------------
                        <p style="font-size: 17px;font-weight: bold;">Payment for Doctor<span style="margin-left: 105px;font-size: 15px;padding: 1px 4px"><?php echo date("Y/m/d H:i:sa"); ?></span></p>
                        ---------------------------------------------------------------------------
                        <br>
                        <table class="print-data">

                        </table>
                        <br>
                        <br>
                        <p style="font-size: 13px;color: gray;">ABC Laboratory </p>
                        ---------------------------------------------------------------------------
                        <br><br>
                    </div>
                    <button id="print">Print</button>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        $(function() {
            var mnths = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            $("#month").autocomplete({
                source: mnths
            });
        });

        $(function() {
            var yrs = ["2019", "2020", "2021", "2022", "2023", "2024", "2025", "2026", "2027", "2028", "2029", "2030"];
            $("#year").autocomplete({
                source: yrs
            });
        });


        $(document).ready(function() {



            //enable buttons
            $('#clear-all').click(function(e) {
                e.preventDefault();
                $('.cover-main div').remove();
                $('.cover-main').load('ReferedBy.php');

                document.getElementById('DocPay').disabled = false;
                document.getElementById('clear').disabled = false;
                document.getElementById('calbtn').disabled = false;
            });
            //previous records
            $('#find').click(function(e) {
                e.preventDefault();
                document.getElementById('DocPay').disabled = true;
                document.getElementById('clear').disabled = true;
                document.getElementById('calbtn').disabled = true;

                var mnth = document.getElementById('month').value;
                var yr = document.getElementById('year').value;

                if (mnth == "" || yr == "") {
                    alert("Fill both month and year!");
                } else {

                    $.ajax({
                        method: "POST",
                        url: "DocPayDetails.php",
                        data: "month=" + mnth + "&year=" + yr,
                        dataType: "json",
                        success: function(data) {
                            $('#viewDocHead tr').remove();
                            var headHtml = '<tr><th>Doctor Name</th><th>Contact No</th><th>Samples Refered</th><th>Total Samples</th><th>Paid</th></tr>';
                            $('#viewDocHead').append(headHtml);
                            $('.DBody tr').remove();
                            for (let i = 0; i < data.length; i++) {
                                var html = '<tr>';
                                html += '<td>' + data[i][0] + '</td>';
                                html += '<td>' + data[i][1] + '</td>';
                                html += '<td>' + data[i][2] + '</td>';
                                html += '<td>' + parseFloat(data[i][3]).toFixed(2) + '</td>';
                                html += '<td>' + parseFloat(data[i][4]).toFixed(2) + '</td></tr>';
                                $('.DBody').append(html);
                            }

                            // document.getElementById('month').value = "";

                        }

                    })
                }
            });

            //print
            $('#DocPay').click(function(e) {
                e.preventDefault();
                $('.print-data tr').remove();
                var doctor = document.getElementById("DocName").value;
                var doctortel = document.getElementById("tel").value;
                var samplecount = document.getElementById("samples").value;
                var doctorpay = document.getElementById("pay-doc").value;
                var total = parseFloat(document.getElementById('tcost').value);
                var modal = document.getElementById("print-main-refer");

                var span = document.getElementsByClassName("close-refer")[0];
                var d = new Date();
                var n = d.getMonth();
                $.ajax({
                    method: "POST",
                    url: "php/PayDoc.php",
                    data: "doc=" + doctor + "&pay=" + doctorpay + "&total=" + total + "&month=" + n,
                    success: function(data) {
                        console.log(data);
                    }

                })

                span.onclick = function() {
                    modal.style.display = "none";
                }

                modal.style.display = "block";

                var html = '<tr><td>Doctor Name :</td> <td>' + doctor + '</td></tr>';
                html += '<tr><td>Contact No :</td> <td>' + doctortel + '</td></tr>';
                html += '<tr><td >Samples Count :</td> <td>' + samplecount + '</td> </tr>';
                html += '<tr><td>Pay :</td><td>' + doctorpay + '</td></tr>';
                $('.print-data').append(html);

            });

            //calculate pay

            $('#calbtn').click(function(e) {
                console.log("ojhojh");
                e.preventDefault();
                var total = parseFloat(document.getElementById('tcost').value);
                var per = document.getElementById('percentage').value;

                if (per) {
                    var percentage = parseFloat(per);
                    var pay = (total * percentage) / 100;
                    document.getElementById('pay-doc').value = parseFloat(pay).toFixed(2);
                } else {
                    alert('Pls enter a value for Percentage');
                }

            });

            $('#print').click(function(e) {
                var today = new Date().toISOString().slice(0, 10);
                var name = document.getElementById("DocName").value + " " + today;
                const toPrint = document.getElementById('Print-preview');

                html2pdf().set({
                    margin: 2,
                    jsPDF: {
                        unit: 'mm',
                        format: [112, 130]
                    }
                }).from(toPrint).save(name + '.pdf');
                setTimeout(function() {
                    $('.cover-main div').remove();
                    $('.cover-main').load('ReferedBy.php');
                }, 3000);

            });


        });

        function loadDoc() {
            var input, filter, table, tr, td, i, txt;

            input = document.getElementById("searchbar");
            filter = input.value;
            table = document.getElementById("viewDoc");
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];

                if (td) {
                    txt = td.textContent || td.innerText;
                    if (txt.indexOf(filter) > -1) {
                        tr[i].style.display = "";

                    } else {
                        tr[i].style.display = "none";

                    }
                }
            }

        }
    </script>
</body>

</html>