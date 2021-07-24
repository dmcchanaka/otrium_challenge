<?php
require_once './includes/connection.php';
require_once './includes/CommonFunction.php';

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
                    <h2>REPORT GENERATING TOOL FOR TECHNICAL PERSONS</h2>

                    <div>
                        <div class="card">
                            <div class="card-body">
                                <div class="row" id="mysql_table_row">
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">MYSQL TABLE 1</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" name="table_name_1" id="table_name_1" onchange="get_columns(this.value, 1);">
                                                    <option value="">SELECT</option>
                                                    <?php CommonFunction::table_names($connection->myconn) ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">MYSQL TABLE 2</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" name="table_name_2" id="table_name_2" onchange="get_columns(this.value, 2);">
                                                    <option value="">SELECT</option>
                                                    <?php CommonFunction::table_names($connection->myconn) ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">JOIN METHOD</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" name="join" id="join">
                                                    <option value="INNER JOIN">INNER JOIN</option>
                                                    <option value="LEFT JOIN">LEFT JOIN</option>
                                                    <option value="RIGHT JOIN">RIGHT JOIN</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="mysql_table_map_row">
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">JOIN FIELD 1</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" name="join_field_1" id="join_field_1">
                                                    <option value="">SELECT</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">JOIN FIELD 2</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" name="join_field_2" id="join_field_2">
                                                    <option value="">SELECT</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="mysql_table_select_row">
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">SELECT FIELDS</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" name="select_field[]" id="select_field" multiple="multiple">
                                                    <option value="">SELECT</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">AGGREGATE METHOD</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" name="aggregate_method" id="aggregate_method" onchange="choose_aggregate_method();">
                                                    <option value="">SELECT</option>
                                                    <option value="SUM">SUM</option>
                                                    <option value="COUNT">COUNT</option>
                                                    <option value="MIN">MIN</option>
                                                    <option value="MAX">MAX</option>
                                                    <option value="AVG">AVG</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group row" id="aggregate_fields" style="display:none">
                                            <label class="col-sm-4 col-form-label">AGGREGATE FIELD</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" name="aggregate_field" id="aggregate_field">
                                                    <option value="">SELECT</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">WHERE</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" name="where_cause" id="where_cause" onchange="choose_where_cause();">
                                                    <option value="">SELECT</option>
                                                    <option value="LIKE %..%">LIKE %..%</option>
                                                    <option value="NOT LIKE">NOT LIKE</option>
                                                    <option value="=">=</option>
                                                    <option value="!=">!=</option>
                                                    <option value="BETWEEN">BETWEEN</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4"id="normal" style="display:none">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">WHERE</label>
                                            <div class="col-sm-8">
                                                <div><input type="text" class="form-control" name="where_key" id="where_key" /></div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4"id="special" style="display:none">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">WHERE</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="where_one" name="where_one" value=""/> AND <input type="text" id="where_two" name="where_two" class="form-control" value=""/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group row" id="where_fields" style="display:none">
                                            <label class="col-sm-4 col-form-label">WHERE FIELD</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" name="where_field" id="where_field">
                                                    <option value="">SELECT</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">GROUP BY</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" name="group_by[]" id="group_by" multiple="multiple">
                                                    <option value="">SELECT</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="button" class="btn btn-secondary" value="GENERATE REPORT" onclick="generate_report()" />
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
    
    <script type="text/javascript">
        $('#select_field').select2({
            selectOnClose: true,
            placeholder: 'Select Field'
        });
        $('#group_by').select2({
            selectOnClose: true,
            placeholder: ''
        });
        function get_columns(id, num) {
            $.ajax({
                url: 'ajax_functions.php',
                type: 'POST',
                data: {
                    id: id,
                    type: 'get_table_columns'
                },
                success: function (data) {
                    var arr = JSON.parse(data);
                    $('#join_field_' + num).empty();
                    for (var i = 0; i < arr.length; i++) {
                        $('#join_field_' + num).append('<option value=' + arr[i].column_name + '>' + arr[i].column_name + '</option>');
                    }

                    load_select_fields();
                }
            });
        }

        function load_select_fields() {
            $.ajax({
                url: 'ajax_functions.php',
                type: 'POST',
                data: {
                    first_table: $('#table_name_1').val(),
                    second_table: $('#table_name_2').val(),
                    type: 'load_multiple_table_columns'
                },
                success: function (data) {
                    var arr = JSON.parse(data);
                    $('#select_field').empty();
                    $('#aggregate_field').empty();
                    $('#group_by').empty();
                    $('#where_field').empty();
                    $('#group_by').append('<option value="">SELECT</option>');
                    for (var i = 0; i < arr.length; i++) {
                        $('#select_field').append('<option value=' + arr[i].column_name + '>' + arr[i].column_name + '</option>');
                        $('#aggregate_field').append('<option value=' + arr[i].column_name + '>' + arr[i].column_name + '</option>');
                        $('#group_by').append('<option value=' + arr[i].column_name + '>' + arr[i].column_name + '</option>');
                        $('#where_field').append('<option value=' + arr[i].column_name + '>' + arr[i].column_name + '</option>');
                    }
                }
            });
        }

        function choose_aggregate_method() {
            if ($('#aggregate_method').val() == "") {
                $('#aggregate_fields').hide('slow');
            } else {
                $('#aggregate_fields').show('slow');
            }
        }

        function generate_report() {
            if ($('#table_name_1').val() == "" && $('#table_name_2').val() == "") {
                alert('Please select atleast one table');
            } else {
                $('#report_dev').html('<p><img src="images/loading.gif"  /></p>');
                $('#report_dev').load("generate_report.php", {
                    'table_name_1': $('#table_name_1').val(),
                    'table_name_2': $('#table_name_2').val(),
                    'join': $('#join').val(),
                    'join_field_1': $('#join_field_1').val(),
                    'join_field_2': $('#join_field_2').val(),
                    'select_field': $('#select_field').val(),
                    'aggregate_method': $('#aggregate_method').val(),
                    'aggregate_field': $('#aggregate_field').val(),
                    'group_by': $('#group_by').val(),
                    'where_cause': $('#where_cause').val(),
                    'where_key': $('#where_key').val(),
                    'where_one': $('#where_one').val(),
                    'where_two': $('#where_two').val(),
                    'where_field': $('#where_field').val()
                });
            }
        }

        function choose_where_cause() {
            if ($('#where_cause').val() == "") {
                $('#special').hide('slow');
                $('#normal').hide('slow');
                $('#where_fields').hide('slow');
            } else if ($('#where_cause').val() == "BETWEEN") {
                $('#special').show('slow');
                $('#normal').hide('slow');
                $('#where_fields').show('slow');
            } else {
                $('#special').hide('slow');
                $('#normal').show('slow');
                $('#where_fields').show('slow');
            }
        }

        function generate_csv() {
            //creating a temporary HTML link element (they support setting file names)
            var a = document.createElement('a');
            //getting data from our div that contains the HTML table
            var data_type = 'data:application/vnd.ms-excel';
            var table_div = document.getElementById('printexcel');
            var table_html = table_div.outerHTML;
            //just in case, prevent default behaviour
            var blob = new Blob([table_html], {type: data_type});
            saveAs(blob, "AUTO GENERATED REPORT.xls");
        }
    </script>
</html>
<?php
$connection->close();
?>

