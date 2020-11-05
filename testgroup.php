<!doctype html>
<html>

<head>
    <title>Test Group</title>
    <link href="css/testgroup.css" rel="stylesheet" type="text/css">
    <link href="css/jquery-ui.css" rel="stylesheet">
    <script src="jquery-3.4.1.min.js"></script>
    <script src="jquery-ui.js"></script>
    <script src="jquery.json.min.js"></script>
</head>

<body>

    <div class="allBody">

        <div class="container-tg">

            <table class="bodytable">
                <div class="coverhead">
                    <p style="margin-left: 2%"><b>New Test Group</b></p>
                </div>

                <tr>
                    <td class="up">

                        <div class="top">

                            <table class="main">
                                <td class="front">

                                    <p>Group Name <input type="text" name="groupname" id="groupname"></p>
                                    <p>Test Name <input type="text" name="tests" id="tests"></p>
                                </td>

                                <td class="middle">

                                    <div class="inn">
                                        <input type="button" value="add" id="add">

                                    </div>
                                    <div class="testlist">
                                        <table id="t">
                                            <th width="75%">Test list</th>
                                            <th width="25%">Operation</th>
                                            <tbody class="tlist">

                                            </tbody>
                                        </table>
                                    </div>


                                </td>


                                <td class="last">
                                    <p> <input type="button" value="Clear" id="clear">
                                    </p>
                                    <p>
                                        <input type="button" value="Save" id="save">

                                    </p>
                                </td>

                            </table>

                        </div>

                    </td>
                </tr>

                <tr>
                    <td class="center">

                        <p> Manage Test Group</p>

                    </td>


                </tr>
                <tr>
                    <td class="down">
                        <div class="down-cover">

                            <table>

                                <td class="down-first">
                                    <input type="text" name="testgrp" id="testgrp" onkeyup="loadTestgroup();" placeholder="Test Group">

                                    <div class="down-table">

                                        <table id="viewgroup">
                                            <thead>
                                                <th width="75%">Group Name</th>
                                                <th width="25%">Delete</th>
                                            </thead>
                                            <tbody>
                                                <?php
                                                include("config.php");
                                                $sql = "SELECT DISTINCT(groupName) FROM `testgroup` ORDER BY groupname ASC";

                                                if ($result = $conn->query($sql)) {

                                                    while ($row = $result->fetch_row()) {
                                                        echo "<tr>
                                                                <td>
                                                                 $row[0]
                                                                </td>
                                                                <td><input type='button' value='X' class='removebtn-group'> </td>
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

                                </td>

                                <td class="space">
                                    <input type="text" name="select" id="select">
                                </td>

                                <td class="down-second">
                                    <div class="final">
                                        <input type="text" name="search-test-for-group" id="search-test-for-group" placeholder="Search Test">
                                        <input type="button" value="Add" id="search-test-btn">

                                        <div class="testlist2">
                                            <table id="t2">
                                                <th width="80%">Test list</th>
                                                <th width="25%">Operation</th>
                                                <tbody id="t2body">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>


                                </td>
                                <td class="down-third">
                                    <p> <input type="button" value="Clear" id="clear-group">
                                    </p>
                                </td>
                            </table>

                        </div>

                    </td>
                </tr>

            </table>

        </div>
    </div>
    <script>
        function loadTestgroup() {
            var input, filter, table, tr, td, i, txt;

            input = document.getElementById("testgrp");
            filter = input.value.toUpperCase();
            table = document.getElementById("viewgroup");
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];

                if (td) {
                    txt = td.textContent || td.innerText;
                    if (txt.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }

        }
    </script>

    <script>
        $(function() {
            $("#search-test-for-group").autocomplete({
                source: 'testsearch.php'
            });
        });

        $(function() {
            $("#tests").autocomplete({
                source: 'testsearch.php'
            });
        });


        $(document).ready(function() {


            $('#clear').click(function(e) {
                document.getElementById('tests').value = "";
                document.getElementById('groupname').value = "";
                $('.tlist tr').remove();

            });

            $('#clear-group').click(function(e) {
                document.getElementById('testgrp').value = "";
                document.getElementById('search-test-for-group').value = "";
                document.getElementById('select').value = "";
                $('#t2body tr').remove();
            });

            $('#add').click(function(e) {
                e.preventDefault();
                var tst = $('#tests').val();

                var html = '<tr><td>' + tst + '</td>';
                html += '<td><input type="button" value="X" class="removebtn-test"> </td></tr>';
                $('.tlist').append(html);
                document.getElementById('tests').value = "";
            });

            $('#save').click(function(e) {

                var tbld;
                tbld = fv();
                tbld = $.toJSON(tbld);

                function fv() {
                    var ar = new Array();

                    $('#t tr').each(function(row, tr) {

                        ar[row] = {
                            0: $(tr).find('td:eq(0)').text(),

                        }
                    });
                    ar.shift();
                    return ar;
                }

                var gnm = $('#groupname').val();
                $.ajax({
                    method: "POST",
                    url: "php/newTestGroup.php",
                    data: "tn=" + tbld + "&gnm=" + gnm,
                    success: function(data) {
                        if (data == "Test Group added!") {
                            // document.getElementById('tests').value = "";
                            // document.getElementById('groupname').value = "";
                            // $('.tlist tr').remove();
                            $('.cover-main div').remove();
                            $('.cover-main').load('testgroup.php');
                        }

                        console.log(data);
                    },
                    fail: function() {
                        alert('Error --> ajax');
                    }
                })



            });





            $('#viewgroup tbody').on('click', '.removebtn-group', function(e) {

                var del = $(this).closest('tr')[0].innerText;

                $.ajax({
                    method: "GET",
                    url: "php/removeGroup.php",
                    data: "del=" + del,
                    success: function(data) {
                        console.log(data);
                        $('.cover-main div').remove();
                        $('.cover-main').load('testgroup.php');
                    }
                })
            });

            $('#t tbody').on('click', '.removebtn-test', function(e) {
                e.preventDefault();
                $(this).closest('tr').remove();

            });

            //add to test grp
            $('#search-test-btn').click(function(e) {


                var grp = $('#select').val();

                if (grp) {
                    if (document.getElementById('search-test-for-group').value != "") {
                        var tst = $('#search-test-for-group').val();
                        var grp = $('#select').val();

                        $.ajax({
                            method: "POST",
                            url: "php/addToGroup.php",
                            data: "grp=" + grp + "&tst=" + tst,
                            success: function(data) {
                                console.log(data);
                                var html = '<tr><td>' + tst + '</td><td><input type="button" value="X" class="removebtn" ></td></tr>';

                                $('#t2').append(html);
                                document.getElementById('search-test-for-group').value = "";
                            }

                        })

                    } else {
                        alert('Please select a Test first!');
                    }

                } else {
                    alert('Please select a TestGroup first!');
                }

            });

        });
    </script>

    <script>
        $(document).ready(function() {

            //remove test from group
            $('#t2 tbody').on('click', '.removebtn', function(e) {

                e.preventDefault();
                var del = $(this).closest('tr').find('td').text();
                var grp = $('#select').val();
                $(this).closest('tr').remove();

                $.ajax({
                    method: "POST",
                    url: "php/removeTestFromGroup.php",
                    data: "del=" + del + "&grp=" + grp,
                    success: function(data) {
                        console.log(data);
                    }
                })
            });

            //grp selection

            $('#viewgroup tbody tr td').on('click', function(e) {
                var table = document.getElementById('viewgroup');
                $('#t2body tr').remove();
                for (var i = 1; i < table.rows.length; i++) {

                    table.rows[i].onclick = function(e) {
                        e.preventDefault();
                        var v = this.cells[0].innerText;
                        document.getElementById("select").value = v;
                        $.ajax({
                            url: "php/findtestForGroup.php",
                            method: "GET",
                            data: "grp=" + v,
                            dataType: "json",
                            success: function(data) {

                                for (let i = 0; i < data.length; i++) {
                                    var html = '<tr><td>' + data[i] + '</td><td><input type = "button" value = "X" class = "removebtn"></td></tr>';
                                    $('#t2body').append(html);
                                }

                            }
                        })
                    };
                }

            });

        });
    </script>
</body>

</html>