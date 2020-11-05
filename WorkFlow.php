<!DOCTYPE html>
<html>

<head>
    <title>WorkFlow</title>

    <link href="css/workflow.css" rel="stylesheet" type="text/css">
    <link href="css/jquery-ui.css" rel="stylesheet">
    <script src="html2pdf.js-master/dist/html2pdf.bundle.min.js"></script>
    <script src="jquery-3.4.1.min.js"></script>
    <script src="jquery-ui.js"></script>
    <script src="jquery.json.min.js"></script>
</head>

<body>
    <div>
        <div class="container">


            <div class="searchbar-workflow">
                <div class="inside-search">
                    <label for="sampSearch">Sample No :</label>
                    <input type="text" id="sampSearch" placeholder="Enter the Sample No" onkeyup="loadTestgroup();"><br>
                    <label for="regdate">Date :</label>
                    <input type="date" id="regdate" name="regdate"><label id="opt"> *Optional</label><br>
                    <button id="searchbtn-workflow">Find</button>
                    <button id="refresh">Refresh</button>
                </div>
            </div>


            <div class="cv-tbl-main">
                <div class="cover-table">
                    <table class="results" id="results">
                        <thead>
                            <th id="sno">Sample No</th>
                            <th id="fname">Full Name</th>
                            <th id="refer">Refered By</th>
                            <th id="regdate">Date</th>
                            <th id="branch">Branch</th>
                            <th id="total">Total</th>
                            <th id="more">More Detail</th>
                            <th id="status">Status</th>
                            <th id="regdate">Print</th>

                        </thead>
                        <tbody id="rlist">
                            <?php
                            include('config.php');

                            $q = "SELECT sample.sampleNo, sample.date, sample.total, doc.DocName, sample.status,  sample.branch, patient.fullname FROM `sample` INNER JOIN patient on sample.patientID=patient.patientID INNER JOIN doc ON sample.referedBy=doc.DocID order by sample.date DESC";

                            if ($result = $conn->query($q)) {

                                while ($row = $result->fetch_row()) {
                                    echo "<tr><td>$row[0]</td>
                                    <td>$row[6]</td>
                                    <td>$row[3]</td>
                                    <td>$row[1]</td>
                                    <td>$row[5]</td>
                                    <td>" . number_format((float)$row[2], 2, '.', '') . "</td>
                                    <td><input type='button' value='' class='moreDetail-group'> </td>
                                    <td>$row[4]</td>
                                    <td><input type='button' value='X' class='print'></td>
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
                </div>

            </div>

            <div id="myModal" class="modal">

                <div class="content-workflow">
                    <div class="close-div"><span class="close-workflow">&times;
                        </span>
                    </div>

                    <span id="tst">Tests for the Sample</span>
                    <div class="tbl">
                        <table id="myTable">
                            <thead>
                                <th>Test Name</th>
                                <th>Unit</th>
                                <th>Reference Range</th>
                                <th>Result</th>
                            </thead>
                            <tbody id="table-content">
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>


            <div id="print-main-workflow" class="print-main-workflow">
                <div class="close-div"><span class="close2">&times;
                    </span>
                </div>

                <div class="preview">
                    <div class="Print-preview-wf" id="Print-preview-wf">
                        ---------------------------------------------------------------------------------------------------------------------------
                        <p style="font-size: 17px;font-weight: bold;text-align: center;">LABORATORY REPORT</p>
                        ---------------------------------------------------------------------------------------------------------------------------
                        <p style="text-align: center;"><u>CONFIDENTIAL</u></p>
                        <br>
                        <p style="text-align: center;">ABC Laboratory - KURUNEGALA</p>
                        <p style="text-align: center;">TEL -646546848, 546846645</p>
                        <p style="text-align: center;">E-MAIL - abc@123.com</p>
                        <p style="text-align: center;font-size: 15px;"><?php echo date("Y/m/d H:i:sa"); ?></p>
                        <br>
                        <table class="print-data-main">

                        </table>

                        <div class="tbl-print">
                            <table id="myTable-print">

                                <thead>
                                    <th>Test Name</th>
                                    <th>Unit</th>
                                    <th>Reference Range</th>
                                    <th>Result</th>
                                </thead>

                                <tbody id="table-content-print">
                                </tbody>
                            </table>

                        </div>

                        <br>

                        <br>
                        <br>
                        <p style="font-size: 13px;color: gray;">ABC Laboratory </p>
                        ---------------------------------------------------------------------------------------------------------------------------


                    </div>
                    <button id="print-workflow">Print</button>
                </div>
            </div>


        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function(e) {

            $('#refresh').click(function(e) {
                $('#rlist tr').remove();
                // document.getElementById('regdate').value = "";
                // document.getElementById('sampSearch').value = "";
                $('.container div').remove();
                $('.container').load('WorkFlow.php');

            });

            $('#searchbtn-workflow').click(function(e) {
                e.preventDefault();
                $('#rlist tr').remove();
                var sampledate = $('#regdate').val();

                $.ajax({
                    method: "POST",
                    url: "php/allTest.php",
                    data: "Sdate=" + sampledate,
                    dataType: "json",
                    success: function(data) {
                        for (let i = 0; i < data.length; i++) {
                            var html = '<tr>';

                            html += '<td>' + data[i][0] + '</td>';
                            html += '<td>' + data[i][6] + '</td>';
                            html += '<td>' + data[i][3] + '</td>';
                            html += '<td>' + data[i][1] + '</td>';
                            html += '<td>' + data[i][5] + '</td>';
                            html += '<td>' + parseFloat(data[i][2]).toFixed(2) + '</td>';
                            html += '<td><input type = "button" value = "" class = "moreDetail-group"></td>';
                            html += '<td>' + data[i][4] + '</td>';
                            html += '<td><input type = "button" value = "X" class = "print"></td>';

                            html += '</tr>';
                            $('#rlist').append(html);

                        }

                    }
                })

            });


            //more details btn
            $('.results #rlist').on('click', '.moreDetail-group', function(e) {
                e.preventDefault();

                $('#table-content tr').remove();

                var modal = document.getElementById("myModal");

                var span = document.getElementsByClassName("close-workflow")[0];
                span.onclick = function() {
                    modal.style.display = "none";
                }

                var samno = $(this).closest('tr').find('td:first').text();

                $.ajax({
                    url: "php/sampleData.php",
                    method: "POST",
                    data: "sample=" + samno,
                    dataType: "json",
                    success: function(data) {

                        for (let i = 0; i < data.length; i++) {

                            var html = '<tr>';
                            html += '<td>' + data[i][0] + '</td>';
                            html += '<td>' + data[i][1] + '</td>';
                            html += '<td>' + data[i][2] + '</td>';
                            html += '<td>' + data[i][3] + '</td>';
                            html += '</tr>';

                            $('#table-content').append(html);
                        }


                        modal.style.display = "block";
                    }
                })

            });
            var full;
            //pdf print btn
            $('#print-workflow').click(function(e) {

                var today = new Date().toISOString().slice(0, 10);
                var fullname = full + " " + today;
                const toPrint = document.getElementById('Print-preview-wf');

                html2pdf().set({
                    margin: 5,
                    image: {
                        type: 'jpeg',
                        quality: 1
                    },
                    html2canvas: {
                        scale: 2,
                        logging: true
                    },
                    jsPDF: {

                        format: 'a4'
                    }
                }).from(toPrint).save(fullname + '.pdf');
                setTimeout(function() {
                    $('.cover-main div').remove();
                    $('.cover-main').load('WorkFlow.php');
                }, 3000);
            });

            //print button
            $('.results #rlist').on('click', '.print', function(e) {
                e.preventDefault();
                var sampleNo = $(this).closest('tr').find('td:eq(0)').text();
                var fullname = $(this).closest('tr').find('td:eq(1)').text();
                full = fullname;
                var refer = $(this).closest('tr').find('td:eq(2)').text();
                var date = $(this).closest('tr').find('td:eq(3)').text();
                var branch = $(this).closest('tr').find('td:eq(4)').text();
                var totalString = $(this).closest('tr').find('td:eq(5)').text();
                var total = parseFloat(totalString);


                $('.print-data-main tr').remove();
                $('#table-content-print tr').remove();


                //tests data


                var modal = document.getElementById("print-main-workflow");

                var span = document.getElementsByClassName("close2")[0];
                span.onclick = function() {
                    modal.style.display = "none";
                }

                var samno = $(this).closest('tr').find('td:first').text();



                $.ajax({
                    url: "php/sampleData.php",
                    method: "POST",
                    data: "sample=" + samno,
                    dataType: "json",
                    success: function(data) {


                        var html1 = '<tr><td><b>Full Name :</b></td><td>' + fullname + '</td><td><b>Refered By :</b></td><td>' + refer + '</td></tr> <tr><td><b>Sample No :</b></td><td>' + sampleNo + '</td><td><b>Reg Date :</b></td><td>' + date + '</td><td><b>Branch :</b></td><td>' + branch + '</td></tr>';
                        $('.print-data-main').append(html1);

                        for (let i = 0; i < data.length; i++) {

                            var html = '<tr>';
                            html += '<td>' + data[i][0] + '</td>';
                            html += '<td>' + data[i][1] + '</td>';
                            html += '<td>' + data[i][2] + '</td>';
                            html += '<td>' + data[i][3] + '</td>';
                            html += '</tr>';

                            $('#table-content-print').append(html);
                        }


                        modal.style.display = "block";
                    }
                })
            });



        });
    </script>


    <script>
        function loadTestgroup() {
            var input, filter, table, tr, td, i, txt;

            input = document.getElementById("sampSearch");
            filter = input.value;
            table = document.getElementById("results");
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