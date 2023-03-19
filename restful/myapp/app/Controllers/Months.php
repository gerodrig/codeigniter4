<?php

namespace App\Controllers;

class Months extends BaseController {


    public function month( $month ){

        //helper is being loaded in Config/Autoload.php
        //another way to load it would be  
        //helper('utilities')
        
        // $month -= 1;

        // $months = array(
        //     'January',
        // 'February',
        // 'March',
        // 'April',
        // 'May',
        // 'June',
        // 'July',
        // 'August',
        // 'September',
        // 'October',
        // 'November',
        // 'December'
        // );

        echo json_encode(get_month($month));
    }
}