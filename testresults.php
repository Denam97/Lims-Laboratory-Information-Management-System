<!doctype html>
<html>

<head>
    <title>Test Results</title>
    <link href="css/testresults.css" rel="stylesheet" type="text/css">
    <link href="css/jquery-ui.css" rel="stylesheet">
    <script src="jquery-3.4.1.min.js"></script>
    <script src="jquery-ui.js"></script>
    <script src="jquery.json.min.js"></script>
</head>

<body>

    <div>
        <div class="container-result">
            <div class="searchbar-result">
                <input type="text" id="sampSearch" placeholder="Enter the Sample No">
                <button id="searchbtn-result">S</button>

                <input type="text" id="regdate" name="regdate" placeholder="Date">
            </div>

            <div class="patient-details">
                <form id="frm">
                    <table>
                        <tr>
                            <td>
                                <label for="sno">Sample No. :</label>

                            </td>
                            <td>
                                <input type="text" id="sno" name="sno">
                            </td>
                        </tr>
                        <tr>

                            <td>

                                <label for="fname">Patient Name :</label>
                            </td>
                            <td>
                                <input type="text" id="fname" name="fname">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="fname">Age :</label>
                            </td>
                            <td>
                                <input type="number" id="age" name="age">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="fname">Gender :</label>
                            </td>
                            <td>
                                <input type="text" id="gender" name="gender">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="fname">Contact No :</label>
                            </td>

                            <td>
                                <input type="tel" id="tel" name="tel" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="fname">Refered By :</label>
                            </td>

                            <td>
                                <input type="text" id="refer" name="refer">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="fname">Branch :</label>
                            </td>

                            <td>
                                <input type="number" id="branch" name="branch">
                            </td>
                        </tr>
                    </table>

                </form>


            </div>

            <div class="cv-tbl-main">
                <div class="cover-table">
                    <table class="results">
                        <thead>
                            <th id="testname">Test</th>
                            <th id="para">Parameter</th>
                            <th>Range</th>
                            <th id="result">Result</th>
                        </thead>
                        <tbody id="rlist">

                        </tbody>
                    </table>
                </div>
                <div class="down">
                    <input type="button" value="Clear" id="result-clear">
                    <input type="button" value="Submit" id="result-save">
                </div>
            </div>



        </div>
    </div>


    <script type="text/javascript">
        $(function() {
            $("#sampSearch").autocomplete({
                source: 'sampleSearch.php'
            });
        });

        $(document).ready(function(e) {

            $('#result-clear').click(function(e) {
                document.getElementById('frm').reset();
                $('#rlist tr').remove();
                document.getElementById('regdate').value = "";
            });

            $('#searchbtn-result').click(function(e) {
                e.preventDefault();
                $('#rlist tr').remove();
                var sample = $('#sampSearch').val();

                $.ajax({
                    method: "POST",
                    url: "php/sampleData.php",
                    data: "sample=" + sample,
                    dataType: "json",
                    success: function(data) {
                        document.getElementById('sno').value = sample;
                        for (let i = 0; i < data.length; i++) {
                            var html = '<tr>';
                            html += '<td>' + data[i][0] + '</td>';
                            html += '<td>' + data[i][1] + '</td>';
                            html += '<td>' + data[i][2] + '</td>';
                            html += '<td><input type="text" class="resultval" value=' + data[i][3] + '>';
                            html += '<input type="button" value="edit" class="edit">';
                            html += '<input type="button" value="X" class="remove-tr"></td>';
                            html += '</tr>';
                            $('#rlist').append(html);

                        }

                        var last = '<tr><td>Remarks</td><td></td><td></td><td><input type="text" class="remark"><input type="button" value="edit" class="remarkadd"><input type="button" value="X" class="remove-tr"></td></tr>';
                        $('#rlist').append(last);

                    }
                })

            });

            $('#searchbtn-result').click(function(e) {
                e.preventDefault();
                document.getElementById('frm').reset();
                var sample = $('#sampSearch').val();

                $.ajax({
                    method: "POST",
                    url: "php/samplePatientData.php",
                    data: "sample=" + sample,
                    dataType: "json",
                    success: function(data) {

                        document.getElementById('fname').value = data[0][0];
                        document.getElementById('age').value = data[0][1];
                        document.getElementById('tel').value = data[0][2];
                        document.getElementById('gender').value = data[0][3];
                        document.getElementById('refer').value = data[0][4];
                        document.getElementById('branch').value = data[0][5];
                        document.getElementById('regdate').value = data[0][6];

                        document.getElementById('sampSearch').value = "";
                    }
                })

            });

            $('#result-save').click(function(e) {

                if (confirm("No longer you will be able to edit sample test results.Do you really want to finish inserting sample Data?")) {
                    var remark = $('.remark').val();
                    var samp = $('#sno').val();

                    $.ajax({
                        url: "php/submitResults.php",
                        method: "POST",
                        data: "samp=" + samp + "&remark=" + remark,
                        success: function(data) {
                            alert(data);

                            if (data == "Success!") {
                                document.getElementById('frm').reset();
                                $('#rlist tr').remove();
                                document.getElementById('regdate').value = "";
                            }
                        }
                    })
                } else {
                    e.preventDefault();
                }



            });

            $('.results #rlist').on('click', '.remarkadd', function(e) {
                var res = prompt("Please Enter the Remarks:");
                $(this).closest('td').find('.resultval').val(res);
            });

            $('.results #rlist').on('click', '.edit', function(e) {
                e.preventDefault();

                var _this = this;
                var test = $(_this).closest('tr').find('td:first').text();
                var sample = $('#sno').val();
                var res = prompt("Please Enter the Result:");

                if (res != null || res != "") {

                    $.ajax({
                        url: "php/addResultToTest.php",
                        method: "POST",
                        data: "test=" + test + "&res=" + res + "&sample=" + sample,
                        success: function(data) {

                            if (data == "Success") {
                                $(_this).closest('td').find('.resultval').val(res);
                            } else {
                                alert(data);
                            }
                        }
                    })
                }
            });

            $('.results #rlist').on('click', '.remove', function(e) {
                e.preventDefault();
                $(this).closest('tr').remove();
            });
        });
    </script>
</body>

</html>