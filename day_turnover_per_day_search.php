<?php
require_once './includes/connection.php';

$connection = new createConnection();
$connection->connectToDatabase();

$brand = "";
$date_range = "";
if($_REQUEST['brand']!=""){
    $brand = " AND b.name = '".$_REQUEST['brand']."'";
}
if($_REQUEST['from_date']!="" && $_REQUEST['to_date']!=""){
    $date_range = " AND DATE_FORMAT(g.date,'%Y-%m-%d') BETWEEN '".$_REQUEST['from_date']."' AND '".$_REQUEST['to_date']."'";
}

$query = "SELECT g.date, SUM(g.turnover- round(((g.turnover /100)*21),2)) as turnover FROM brands b INNER JOIN gmv g ON g.brand_id = b.id WHERE 1 $brand $date_range GROUP BY g.date";
$result = mysqli_query($connection->myconn, $query);
if (mysqli_num_rows($result) > 0) { ?>
<input type="button" class="btn btn-secondary" value="GENERATE CSV" onclick="generate_csv()" />
<table class="table" id="printexcel">
    <tr>
        <td>DATE</td>
        <td>TURNOVER</td>
    </tr>
    <?php 
    $total = 0;
     while ($row = mysqli_fetch_assoc($result)){ 
         $total += $row['turnover'];
         ?>
    <tr>
        <td><?php echo $row['date']; ?></td>
        <td style="text-align: right"><?php echo $row['turnover']; ?></td>
    </tr>
    <?php } ?>
    <tr>
        <td style="text-align: left">Total</td>
        <td style="text-align: right"><?php echo $total; ?></td>
    </tr>
</table> 
<?php } else {
    echo 'NO RECORD FOUND';
}

$connection->close();

