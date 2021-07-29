<?php

/**
 * Description of Report
 *
 * @author DMCC
 */
class Reports {

    public $title;

    public function csv_maker() {
        return '<input type="button" class="btn btn-secondary" value="GENERATE CSV" onclick="generate_csv()" /><br><br>';
    }

    public function csv_generator($arr) {
        ob_start();
        $uname = strtolower(php_uname());
        $filename = $this->title;

// output headers so that the file is downloaded rather than displayed
        header('Content-Type: text/csv; charset=utf-8');
        header("Content-Disposition: attachment;filename=$filename");

// create a file pointer connected to the output stream
        $output = fopen('php://output', 'w');
        fputcsv($output, $arr['headings']);

// loop over the rows, outputting them
        foreach ($arr['data'] as $row) {
            fputcsv($output, $row);
        }
    }

}
