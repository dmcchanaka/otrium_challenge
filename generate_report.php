<?php

require_once './includes/connection.php';

$connection = new createConnection();
$connection->connectToDatabase();

$query_string = "";

$selected_list = "*";
if (isset($_REQUEST['select_field']) && sizeof($_REQUEST['select_field']) > 0) {
    $selected_list = implode(', ', $_REQUEST['select_field']);
}
if (isset($_REQUEST['aggregate_method']) && $_REQUEST['aggregate_method'] != "" && $_REQUEST['aggregate_field'] != "") {
    $selected_list .= ',' . $_REQUEST['aggregate_method'] . '(' . $_REQUEST['aggregate_field'] . ')';
}

if ($_REQUEST['table_name_1'] != "" && $_REQUEST['table_name_2'] != "") {
    $query_string = "SELECT " . $selected_list . " FROM " . $_REQUEST['table_name_1'] . ' '
            . $_REQUEST['join'] . ' ' . $_REQUEST['table_name_2'] .
            " ON " . $_REQUEST['join_field_1'] . ' = ' . $_REQUEST['join_field_2'] . "";
} else if ($_REQUEST['table_name_1'] != "" && $_REQUEST['table_name_2'] == "") {
    $query_string = "SELECT " . $selected_list . " FROM " . $_REQUEST['table_name_1'] . ' ';
} else if ($_REQUEST['table_name_2'] != "" && $_REQUEST['table_name_1'] == "") {
    $query_string = "SELECT " . $selected_list . " FROM " . $_REQUEST['table_name_2'] . ' ';
}

if ($_REQUEST['where_field'] != "" && $_REQUEST['where_cause'] != "" && $_REQUEST['where_cause'] == "BETWEEN" && $_REQUEST['where_one'] != "" && $_REQUEST['where_two'] != "") {
    $query_string .= " WHERE " . $_REQUEST['where_field'] . " BETWEEN '" . $_REQUEST['where_one'] . "' AND '" . $_REQUEST['where_two'] . "'";
} else if ($_REQUEST['where_field'] != "" && $_REQUEST['where_cause'] != "" && $_REQUEST['where_cause'] == "LIKE %..%" && $_REQUEST['where_key'] != "") {
    $query_string .= " WHERE " . $_REQUEST['where_field'] . " LIKE '%" . $_REQUEST['where_key'] . "%'";
} else if ($_REQUEST['where_field'] != "" && $_REQUEST['where_cause'] != "" && $_REQUEST['where_cause'] == "NOT LIKE" && $_REQUEST['where_key'] != "") {
    $query_string .= " WHERE " . $_REQUEST['where_field'] . " NOT LIKE '" . $_REQUEST['where_key'] . "'";
} else if ($_REQUEST['where_field'] != "" && $_REQUEST['where_cause'] != "" && $_REQUEST['where_cause'] == "=" && $_REQUEST['where_key'] != "") {
    $query_string .= " WHERE " . $_REQUEST['where_field'] . " = '" . $_REQUEST['where_key'] . "'";
} else if ($_REQUEST['where_field'] != "" && $_REQUEST['where_cause'] != "" && $_REQUEST['where_cause'] == "!=" && $_REQUEST['where_key'] != "") {
    $query_string .= " WHERE " . $_REQUEST['where_field'] . " != '" . $_REQUEST['where_key'] . "'";
}

if (isset($_REQUEST['group_by']) && $_REQUEST['group_by'] != "" && sizeof($_REQUEST['group_by']) > 0) {
    $selected_list = implode(', ', $_REQUEST['group_by']);
    $query_string .= " GROUP BY " . $selected_list;
}
$result = mysqli_query($connection->myconn, $query_string);
if (mysqli_num_rows($result) > 0) {
    echo '<input type="button" class="btn btn-secondary" value="GENERATE CSV" onclick="generate_csv()" /><br/>';
    $data = Array();
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($data, $row);
    }
    $headKeys = array();
    foreach ($data as $key => $head) {
        foreach ($head as $headKey => $headValue) {
            array_push($headKeys, $headKey);
        }
    }
    $uniqueHeads = array_unique($headKeys);

    echo '<table class="table" id="printexcel">';
    echo '<tr>';
    foreach ($uniqueHeads as $hd) {
        echo '<td>' . $hd . '</td>';
    }
    echo '</tr>';
    foreach ($data as $key => $value) {
        echo '<tr>';
        foreach ($value as $newKey => $value) {
            echo '<td>' . $value . '</td>';
        }
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo 'NO RECORD FOUND';
}
