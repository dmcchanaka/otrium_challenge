<?php
include_once 'Reports.php';

class DayTurnOverPerDay extends Reports{
    
    public $title;

    function __construct() {
        $this->title = 'DAYS TURNOVER PER DAY';
    }

    public function get_title() {
        return $this->title;
    }
    
    //get report searching result
    public function search($request, $connection) {
        $brand = "";
        $date_range = "";
        if ($request['brand'] != "") {
            $brand = " AND b.id = '" . $request['brand'] . "'";
        }
        if ($request['from_date'] != "" && $request['to_date'] != "") {
            $date_range = " AND DATE_FORMAT(g.date,'%Y-%m-%d') BETWEEN '" . $request['from_date'] . "' AND '" . $request['to_date'] . "'";
        }
        $query = "SELECT g.date, SUM(g.turnover) as turnover FROM brands b INNER JOIN gmv g ON g.brand_id = b.id WHERE 1 $brand $date_range GROUP BY g.date";
        $result = mysqli_query($connection, $query);
        $array = array();
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $arr['date'] = $row['date'];
                $arr['turnover_vat_include'] = $row['turnover'];
                $arr['turnover_vat_exclude'] = $this->tax_excluded_turnover($row['turnover']);
                array_push($array, $arr);
            }
        }
        return $array;
    }
    
    //calculate tax values
    protected function tax_excluded_turnover($turnover) {
        $turnover = $turnover - round((($turnover / 100) * 21), 2);
        return $turnover;
    }
}
