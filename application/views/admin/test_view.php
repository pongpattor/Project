<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?= base_url('assets/css/styles.css'); ?>" rel="stylesheet" />
    <script src="<?= base_url('assets/script/node_modules/jquery/dist/jquery.js'); ?>"></script>
    <script src="<?= base_url('assets/bootstrap4/js/bootstrap.bundle.min.js'); ?>"></script>

    <title>Document</title>
</head>

<body>
    <label for="bdate">Bdate</label>
    <input type="date" name="bdate" id="bdate">
    <br>
    <br>
    <label for="odate">Odate</label>
    <input type="date" name="odate" id="odate">

    <script>
        $(document).ready(function() {

            function formatDate(date) {
                var ymd = new Date(date);
                alert(ymd);
                var month = '' + (ymd.getMonth() + 1);
                var day = '' + (ymd.getDate() + 1);
                var year = ymd.getFullYear();

                if (month.length < 2) {
                    month = '0' + month;

                }
                if (day.length < 2) {
                    day = '0' + day;
                }
                return year+'-'+month+'-'+day;
            }

            $('#bdate').change(function() {
                var date = $(this).val();
                date = formatDate(date);
                $('#odate').attr({
                    'max': date,
                    'min': date,
                    'value':date,
                });
            });
        });
    </script>
</body>

</html>