<!doctype html>
<html lang="en">

<head>
    <script src="jquery-3.4.1.min.js"></script>
    <script src="jquery-ui.js"></script>
    <script src="jquery.json.min.js"></script>

    <title>Document</title>
</head>

<body>
    <form action="" method="POST" name="fr" id="fr">
        <table class="testtable" name="testtable" id="testtable">
            <thead>
                <tr>
                    <th>Test ID</th>
                    <th>Test Name</th>

                    <th>Cost</th>
                </tr>
            </thead>

            <tbody class="xy">
                <tr>
                    <td>sds</td>
                    <td>sad</td>
                    <td>asad</td>

                </tr>
                <tr>
                    <td>ww</td>
                    <td>wwwww</td>
                    <td>wwwwwwwww</td>

                </tr>
            </tbody>

        </table>

        <button type="submit" id="cc" name="cc">bb</button>
    </form>
    <script>
        $(document).ready(function() {

            $('#fr').submit(function(e) {


                var tbld;
                tbld = fv();
                tbld = $.toJSON(tbld);

                function fv() {
                    var ar = new Array();

                    $('#testtable tr').each(function(row, tr) {

                        ar[row] = {
                            0: $(tr).find('td:eq(0)').text(),
                            1: $(tr).find('td:eq(1)').text(),
                            2: $(tr).find('td:eq(2)').text()
                        }
                    });
                    ar.shift();
                    return ar;
                }

                $.ajax({
                    type: "post",
                    url: "php/b.php",
                    data: "tn=" + tbld,
                    success: function(data) {
                        alert(data);
                    }
                })
            });

        });
    </script>
</body>

</html>