<?php
include_once './includes/connection.php';
require_once './includes/CommonFunction.php';
include_once './controller/DayTurnOverPerBrand.php';
include_once './controller/DayTurnOverPerDay.php';

$connection = new createConnection();
$connection->connectToDatabase();

if (isset($_REQUEST['report_type']) && $_REQUEST['report_type'] == 'day_turnover_per_brand') {

    $dayTurnOverPerBrand = new DayTurnOverPerBrand();
    $result = $dayTurnOverPerBrand->search($_REQUEST, $connection->myconn);
    if (count($result) > 0) {
        echo $dayTurnOverPerBrand->csv_maker();
        ?>

        <table class="table" id="printexcel">
            <thead>
                <tr>
                    <td>DATE</td>
                    <td>BRAND</td>
                    <td>TURNOVER (TAX+)</td>
                    <td>TURNOVER (TAX-)</td>
                </tr>
            </thead>
            <tbody>
                <?php
                $total_turnover_vat_include = 0;
                $total_turnover_vat_exclude = 0;
                foreach ($result as $key => $value) {
                    $total_turnover_vat_include += $value['turnover_vat_include'];
                    $total_turnover_vat_exclude += $value['turnover_vat_exclude'];
                    ?>
                    <tr>
                        <td><?php echo $value['date']; ?></td>
                        <td style="text-align: left"><?php echo $value['name']; ?></td>
                        <td style="text-align: right"><?php echo $value['turnover_vat_include']; ?></td>
                        <td style="text-align: right"><?php echo $value['turnover_vat_exclude']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
            <thead>
                <tr>
                    <td colspan="2">TOTAL</td>
                    <td style="text-align: right"><?php echo $total_turnover_vat_include; ?></td>
                    <td style="text-align: right"><?php echo $total_turnover_vat_exclude; ?></td>
                </tr>
            </thead>
        </table>
    <?php } else { ?>
        <span style="color: red">No Record Found</span>
        <?php
    }
}

if (isset($_REQUEST['report_type']) && $_REQUEST['report_type'] == 'day_turnover_per_day') {
    $dayTurnOverPerDay = new DayTurnOverPerDay();
    $result = $dayTurnOverPerDay->search($_REQUEST, $connection->myconn);
    if (count($result) > 0) {
        echo $dayTurnOverPerDay->csv_maker();
        ?>
        <table class="table" id="printexcel" width="100%">
            <thead>
                <tr>
                    <td>DATE</td>
                    <td>TURNOVER (TAX+)</td>
                    <td>TURNOVER (TAX-)</td>
                </tr>
            </thead>
            <tbody>
                <?php
                $total_turnover_vat_include = 0;
                $total_turnover_vat_exclude = 0;
                foreach ($result as $key => $value) {
                    $total_turnover_vat_include += $value['turnover_vat_include'];
                    $total_turnover_vat_exclude += $value['turnover_vat_exclude'];
                    ?>
                    <tr>
                        <td><?php echo $value['date']; ?></td>
                        <td style="text-align: right"><?php echo $value['turnover_vat_include']; ?></td>
                        <td style="text-align: right"><?php echo $value['turnover_vat_exclude']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
            <thead>
                <tr>
                    <td>TOTAL</td>
                    <td style="text-align: right"><?php echo $total_turnover_vat_include; ?></td>
                    <td style="text-align: right"><?php echo $total_turnover_vat_exclude; ?></td>
                </tr>
            </thead>
        </table>
    <?php } else { ?>
        <span style="color: red">No Record Found</span>
        <?php
    }
}

if (isset($_REQUEST['report_type']) && $_REQUEST['report_type'] == 'day_turnover_per_brand_csv') {
    $dayTurnOverPerBrand = new DayTurnOverPerBrand();
    $result = $dayTurnOverPerBrand->search($_REQUEST, $connection->myconn);

    $headKeys = array();
    foreach ($result as $key => $head) {
        foreach ($head as $headKey => $headValue) {
            array_push($headKeys, $headKey);
        }
    }
    $uniqueHeads = array_unique($headKeys);
    $arr['headings'] = $uniqueHeads;
    $arr['data'] = $result;
    $data = $dayTurnOverPerBrand->csv_generator($arr);
    return $data;
}

if (isset($_REQUEST['report_type']) && $_REQUEST['report_type'] == 'day_turnover_per_day_csv') {
    $dayTurnOverPerDay = new DayTurnOverPerDay();
    $result = $dayTurnOverPerDay->search($_REQUEST, $connection->myconn);

    $headKeys = array();
    foreach ($result as $key => $head) {
        foreach ($head as $headKey => $headValue) {
            array_push($headKeys, $headKey);
        }
    }
    $uniqueHeads = array_unique($headKeys);
    $arr['headings'] = $uniqueHeads;
    $arr['data'] = $result;
    $data = $dayTurnOverPerDay->csv_generator($arr);
    return $data;
}

$connection->close();

