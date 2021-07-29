<?php
include_once './includes/connection.php';
require_once './includes/CommonFunction.php';
include_once './controller/DayTurnOverPerBrand.php';

$connection = new createConnection();
$connection->connectToDatabase();

$dayTurnOverPerBrand = new DayTurnOverPerBrand();
?>
<!DOCTYPE html>
<html lang = "en">
    <head>
        <title>OTRIUM CHALLENGE</title>
        <meta charset = "utf-8">
        <meta name = "viewport" content = "width=device-width, initial-scale=1">
        <link rel = "stylesheet" href = "https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link href = "select2/select2.min.css" rel = "stylesheet" />


        <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="select2/select2.min.js"></script>
        <style>
            .fakeimg {
                height: 200px;
                background: #aaa;
            }
        </style>
    </head>
    <body>

        <div class="container" style="margin-top:30px">
            <div class="row">
                <div class="col-sm-12" style="border:1px solid black">
                    <h2><?php echo $dayTurnOverPerBrand->get_title() ?></h2>

                    <div>
                        <div class="card">
                            <div class="card-body">
                                <div class="row" id="mysql_table_row">
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">BRAND</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" name="brand" id="brand">
                                                    <option value="">SELECT</option>
                                                    <?php CommonFunction::brand($connection->myconn) ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">FROM DATE</label>
                                            <div class="col-sm-8">
                                                <input type="date" class="form-control" id="from_date" name="from_date" value=""/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">TO DATE</label>
                                            <div class="col-sm-8">
                                                <input type="date" class="form-control" id="to_date" name="to_date" value=""/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-bottom:10px">
                                    <div class="col-md-4">
                                        <input type="button" name="search" id="search" class="btn btn-secondary" onclick="generate_report()" value="GENERATE REPORT" />
                                        <a href="index.php"><input type="button" class="btn btn-secondary" value="BACK" /></a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="report_dev" style="text-align: center"></div>
                                    </div>
                                </div>
                            </div>
                        </div><br/>
                    </div>
                </div>
            </div>

    </body>
    <script src="jquery/FileSaver.js"></script>
    <script src="jquery/jquery-3.0.0.min.js"></script>
    <script type="text/javascript">
                                            function generate_report() {
                                                $('#report_dev').html('<p><img src="images/loading.gif"  /></p>');
                                                $('#report_dev').load("report_search.php", {
                                                    'report_type': 'day_turnover_per_brand',
                                                    'brand': $('#brand').val(),
                                                    'from_date': $('#from_date').val(),
                                                    'to_date': $('#to_date').val()
                                                });
                                            }

                                            function generate_csv() {
                                                $.ajax({
                                                    url: 'report_search.php',
                                                    type: 'POST',
                                                    data: {
                                                        'report_type': 'day_turnover_per_brand_csv',
                                                        'brand': $('#brand').val(),
                                                        'from_date': $('#from_date').val(),
                                                        'to_date': $('#to_date').val()
                                                    },
                                                    success: function (data) {
                                                        console.log(data);
                                                        var downloadLink = document.createElement("a");
                                                        var fileData = [data];

                                                        var blobObject = new Blob(fileData, {
                                                            type: "text/csv;charset=utf-8;"
                                                        });

                                                        var url = URL.createObjectURL(blobObject);
                                                        downloadLink.href = url;
                                                        downloadLink.download = "<?php echo $dayTurnOverPerBrand->title . '.csv'; ?>";

                                                        /*
                                                         * Actually download CSV
                                                         */
                                                        document.body.appendChild(downloadLink);
                                                        downloadLink.click();
                                                        document.body.removeChild(downloadLink);
                                                    }
                                                });
                                            }
    </script>
</html>
<?php
$connection->close();

