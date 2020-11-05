<!DOCTYPE html>
<html>

<head>
    <title>Test Management</title>

    <link href="css/testmanagement.css" rel="stylesheet" type="text/css">
    <link href="css/jquery-ui.css" rel="stylesheet">
    <script src="jquery-3.4.1.min.js"></script>
    <script src="jquery-ui.js"></script>
    <script src="jquery.json.min.js"></script>

</head>

<body>
    <div class="allBody">

        <div class="container-manage">

            <div class="search">
                <p>Test Name <input type="text" id="searchbar" name="searchbar" onkeyup="loadTest();">
                    <button id="searchbtn-manage">Search</button>
                </p>


                <div class="viewcover-manage" id="viewcover-manage">
                    <table class="viewtest-manage" id="viewtest-manage" onmousedown="selecter();">

                        <thead>
                            <tr>
                                <th>Test Name</th>
                                <th>Print Name</th>
                                <th>Reference Range</th>
                                <th>Unit</th>
                                <th>Price</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            include("config.php");
                            $sql = "SELECT `testName`, `printName`, `referenceRange`, `unit`, `cost` FROM `test` ORDER BY testName ASC";

                            if ($result = $conn->query($sql)) {

                                while ($row = $result->fetch_row()) {
                                    echo "<tr>
                                <td>$row[0]</td>
                                <td>$row[1]</td>
                                <td>$row[2]</td>
                                <td>$row[3]</td>
                                <td>".number_format((float)$row[4], 2,'.','')."</td>
                                
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
                            var table = document.getElementById('viewtest-manage');

                            for (var i = 1; i < table.rows.length; i++) {
                                table.rows[i].onclick = function() {

                                    document.getElementById("testname").value = this.cells[0].innerText;
                                    document.getElementById("pname").value = this.cells[1].innerText;
                                    document.getElementById("range").value = this.cells[2].innerText;
                                    document.getElementById("unit").value = this.cells[3].innerText;
                                    document.getElementById("price").value = this.cells[4].innerText;

                                };
                            }
                        }
                    </script>
                </div>

            </div>


            <div class="test1-manage">
                <form class="test-manage" name="testform" id="testform" method="POST">

                    <table class="formtable">

                        <tr>
                            <td>
                                Test Name :</td>
                            <td>
                                <input type="text" id="testname" name="testname">
                            </td>



                        </tr>
                        <tr>
                            <td>Print Name :</td>
                            <td>
                                <input type="text" id="pname" name="pname">
                            </td>




                        </tr>
                        <tr>
                            <td>Reference Range :</td>
                            <td>
                                <label for="min" id="min-lbl">Min</label>
                                <input type="text" id="min" name="min">

                                <label for="maximum" id="max-lbl">Max</label>
                                <input type="text" id="maximum" name="maximum">

                                <!-- <input type="text" id="range" name="range"> -->
                            </td>




                        <tr>
                            <td>Unit :</td>
                            <td>
                                <input type="text" id="unit" name="unit" list="units-list">
                                <datalist id="units-list">

                                </datalist>
                            </td>


                        </tr>

                        <tr>
                            <td>Price :</td>
                            <td>
                                <input type="text" id="price" name="price">
                            </td>


                        </tr>


                    </table>


                    <input type="reset" value="Clear" id="clear-manage">
                    <input type="button" value="Delete" id="delete">
                    <input type="submit" value="Update" id="update">


                </form>

            </div>
        </div>
    </div>

    <script>

        $.ajax({
            url: 'unitsSearch.php',
            success: function(data) {
                var data1 = JSON.parse(data);
                var html = "";
                for (let i = 0; i < data1.length; i++) {
                    html += '<option value="' + data1[i] + '">' + data1[i] + '</option>';
                }
                document.getElementById("units-list").innerHTML = html;
            }
        })


        function loadTest() {
            var input, filter, table, tr, td, i, txt;

            input = document.getElementById("searchbar");
            filter = input.value.toUpperCase();
            table = document.getElementById("viewtest-manage");
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
        $(document).ready(function() {

            $('#testform').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    method: "POST",
                    url: "php/updateTest.php",
                    data: $(this).serialize(),
                    success: function(data) {
                        console.log(data);
                        document.getElementById("testform").reset();
                        $('.viewcover-manage').load("manageTest.php #viewtest-manage");
                    }

                })

            });

            $('#delete').click(function(e) {
                e.preventDefault();
                var test = $('#testname').val();

                if (test != "") {
                    $.ajax({
                        method: "POST",
                        url: "php/DeleteTest.php",
                        data: "test=" + test,
                        success: function(data) {
                            console.log(data);
                            document.getElementById("testform").reset();
                            $('.viewcover-manage').load("manageTest.php #viewtest-manage");
                        }

                    })
                } else {
                    alert("Please select a test!!");
                }
            });

        });
    </script>
</body>

</html>