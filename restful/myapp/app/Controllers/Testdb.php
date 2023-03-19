<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use Config\Database;


class Testdb extends BaseController
{

    protected $db;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        // Call parent constructor
        parent::initController($request, $response, $logger);

        // Connect to the database
        $this->db = Database::connect();
    }

    public function insert(){

        $data = array(
            'firstname' => 'Benito',
            'lastname' => 'Martinez',
        );

        $data = capitalize_all($data);

        $this->db->table('test')->insert($data);

        // get response
        $response = array(
            'error' => false,
            'message' => 'success',
            'data' => $this->db->insertID()
        );

        echo json_encode($response);
    }

    public function insert_many(){

        $data = array(
            array(
                'firstname' => 'Mimi',
                'lastname' => 'Martinez',
            ),
            array(
                'firstname' => 'Conejita',
                'lastname' => 'Martinez',
            ),
        );

        $this->db->table('test')->insertBatch($data);

        echo json_encode($this->db->affectedRows());
    }

    public function update(){

        $data = array(
            'firstname' => 'Mmi',
            'lastname' => 'Martinez',
        );

        $data = capitalize_all($data);

        $this->db->table('test')->where('id', 1)->update($data);

        echo 'Entry was updated!!';
    }

    public function delete(){

        // $data = array(
        //     'firstname' => 'Mmi',
        //     'lastname' => 'Martinez',
        // );


        $this->db->table('test')->where('id',1)->delete();

        echo 'Entry was deleted!!';
        //total entries deleted
        // echo $this->db->affectedRows();
    }

    public function table(){
        $query = $this->db->table('customers')->select('id, name, email')->where('id', 1)->get();

        // foreach ($query->getResult() as $row)
        // {
        //         echo $row->nombre . '<br/>';
        // }

        echo json_encode($query->getResult());
    }

    public function customers_beta(){

        // $db = \Config\Database::connect();

        //$query = $this->$db->query('SELECT * FROM customers LIMIT 10');
        $query = $this->db->query('SELECT * FROM customers LIMIT 10');

    //     foreach ($query->getResult() as $row)
    //     {
    //             echo $row->id;
    //             echo $row->nombre;
    //             echo $row->correo;
    //     }

    //     echo 'To
    
        $response = array('error' => false, 'message' => 'success', 'total entries' => $query->getNumRows(), 'customers' => $query->getResult());

        echo json_encode($response);
    }

    public function customer ($id ){

        // $db = \Config\Database::connect();

        $query = $this->db->query('SELECT * FROM customers WHERE id = '.$id);

        $row = $query->getRow();

        if( isset($row) ){
            $row = array('error' => false, 'message' => 'success', 'total entries' => $query->getNumRows(), 'customer' => $row);
        } else {
            $row = array('error' => true, 'message' => 'The entry with id '.$id.' was not found', 'total entries' => 0, 'customer' => null);
        }

        echo json_encode($row);
    }
}