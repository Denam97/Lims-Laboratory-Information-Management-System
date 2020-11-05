<!doctype html>
<html>

<head>
    <title>New Test</title>
    <link href="css/test.css" rel="stylesheet" type="text/css">
    <link href="css/jquery-ui.css" rel="stylesheet">
    <script src="jquery-3.4.1.min.js"></script>
    <script src="jquery-ui.js"></script>
    <script src="jquery.json.min.js"></script>
</head>

<body>
    <div class="allBody">

        <div class="container-test">

            <div class="viewtest1">
                <div class="viewcover">
                    <table class="viewtest" id="viewtest">

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
                </div>
            </div>


            <div class="test1">
                <form class="test" name="testnew" id="testnew" method="POST">

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

                    <input type="reset" value="Clear" id="clear">

                    <input type="submit" value="Save" id="save">
                </form>



            </div>

        </div>

    </div>

    <script>
        // $(function() {
        //     $("#unit").autocomplete({
        //         source: 'unitsSearchByName.php'
        //     });
        // });



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


        $(document).ready(function() {

            $('#testnew').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    method: "POST",
                    url: "php/addTest.php",
                    data: $(this).serialize(),
                    success: function(data) {
                        console.log(data);
                        document.getElementById('testnew').reset();
                        $('.viewcover').load("test.php #viewtest");

                    }

                })
            });

        });
    </script>

</body>

</html>