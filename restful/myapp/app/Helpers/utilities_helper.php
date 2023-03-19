<?php 

function get_month( $month ){

    

    $month -= 1;

    $months = array(
        'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July',
    'August',
    'September',
    'October',
    'November',
    'December'
    );

    return $months[$month];
}

function capitalize_all( $raw_data){

    return capitalize_array($raw_data, array(), true);
}

function capitalize_array( $raw_data, $fields = array(), $all = false ){

    $data_processed = $raw_data;

    foreach( $raw_data as $field_name => $field_value ){
        
        if( in_array($field_name, array_values($fields) ) OR $all ){
            $data_processed[$field_name] = strtoupper($field_value);
        }
    }

    return $data_processed;
}


?>