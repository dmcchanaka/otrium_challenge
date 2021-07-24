<?php
require_once './includes/connection.php';

$connection = new createConnection();
$connection->connectToDatabase();

if(isset($_REQUEST['type']) && $_REQUEST['type']=='get_table_columns'){
    $query = "SELECT `COLUMN_NAME` 
        FROM `INFORMATION_SCHEMA`.`COLUMNS` 
        WHERE `TABLE_SCHEMA`='otrium_challenge' 
        AND `TABLE_NAME`='".$_REQUEST['id']."'";
    $result = mysqli_query($connection->myconn, $query);
    $response = array();
    while ($row = mysqli_fetch_assoc($result)){
        $arr['column_name'] = $_REQUEST['id'].'.'.$row['COLUMN_NAME'];
        array_push($response, $arr);
    }
    echo json_encode($response);
}

if(isset($_REQUEST['type']) && $_REQUEST['type']=='load_multiple_table_columns'){
    $query = "SELECT concat(table_name,'.',column_name) as column_name 
        FROM `INFORMATION_SCHEMA`.`COLUMNS` 
        WHERE `TABLE_SCHEMA`='otrium_challenge' 
        AND `TABLE_NAME` in ('".$_REQUEST['first_table']."', '".$_REQUEST['second_table']."')";
    $result = mysqli_query($connection->myconn, $query);
    $response = array();
    while ($row = mysqli_fetch_assoc($result)){
        $arr['column_name'] = $row['column_name'];
        array_push($response, $arr);
    }
    echo json_encode($response);
}

$connection->close();

