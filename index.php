<?php
require_once './includes/connection.php';

$connection = new createConnection();
$connection->connectToDatabase();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>OTRIUM CHALLENGE</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link href="select2/select2.min.css" rel="stylesheet" />


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="jquery/FileSaver.js"></script>
        <script src="jquery/jquery-3.0.0.min.js"></script>
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
                    <h2>REPORTING TOOL</h2>

                    <div>
                        <div class="card">
                            <div class="card-body">
                                <?php include_once './template/main_section.php'; ?>
                            </div>
                        </div><br/>
                    </div>
                </div>
            </div>

    </body>


</html>
<?php
$connection->close();
?>

