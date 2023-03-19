<?php


function  paginate_all($table, $page = 1, $per_page = 20, $fields = array()){

    $db = \Config\Database::connect();

    if( $page == null ){
        $page = 1;
    }
    
    if( $per_page == null ){
        $per_page = 20;
    }

    $count = $db->table($table)->countAllResults();
    $total_pages = ceil($count / $per_page);


    if($page > $total_pages){
        $page = $total_pages;
    }

    $page -= 1;
    $page_next = $page * $per_page;

    if( $page >= $total_pages - 1 ){
        $page_next = 1;
    } else {
        $page_next = $page + 2;
    }

    //previous page 
    $page_prev = $page - 1;

    if( $page_prev < 0 ){
        $page_prev = 1;
    } else {
        $page_prev = $page;
    }

    
    $query = $db->table($table)->limit($per_page, $page * $per_page)->select($fields)->get();


    $response = array('error' => false, 
                        'message' => 'record loaded successfully', 
                        'count' => $count, 
                        'total_pages' => $total_pages,
                        'current_page' => ($page + 1),
                        'next_page' => $page_next,
                        'prev_page' => $page_prev,  
                        $table => $query->getResultArray()                          
                    );

    return $response;

}




?>