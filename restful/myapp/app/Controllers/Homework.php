<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;


class Homework extends BaseController
{
    //return just the count of students
    public function alumnos_conteo(){
        $db = \Config\Database::connect();
        $query = $db->query('SELECT COUNT(*) FROM alumnos');
        $response = array('error' => false, 'message' => 'success', 'total students' => $query->getRow()->{'COUNT(*)'});
        echo json_encode($response);
    }

    //return the list of students including their average grade
    public function alumnos_listado(){
        $db = \Config\Database::connect();
        $query = $db->query('SELECT *, ROUND((parcial1 + parcial2 + parcial3) / 3, 2) AS promedio FROM `alumnos`');
        $response = array('error' => false, 'message' => 'success', 'total students' => $query->getNumRows(), 'students' => $query->getResult());
        echo json_encode($response);
    }
    

}