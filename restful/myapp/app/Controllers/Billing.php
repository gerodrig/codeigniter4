<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Log\LoggerInterface;


//validation
use App\Controllers\BaseController;
use CodeIgniter\Validation\Exceptions\ValidationException;


// namespace App\Models;

class Billing extends BaseController
{
    protected $db;

    public function __construct()
    {
        // Connect to the database via the model
        $this->db = \Config\Database::connect();
    }

    public function invoice()
    {
        $id = $this->request->uri->getSegment(2);

        //get a query builder instance for the invoice with the id
        $builder = $this->db->table('billing')->where('invoice_id', $id);

        $response  = array(
            'error' => false,
            'message' => 'record loaded successfully',
            'invoice' => $builder->get()->getRowArray()
        );

        if( !$response['invoice'] ){
            return $this->response->setStatusCode(400)->setJSON(array('error' => true, 'message' => 'Invalid invoice id', 'invoice' => null));
        }

        //reset query
        $builder->resetQuery();

        // get invoice details
        $builder = $this->db->table('billing_details')->where('invoice_id', $id);
        $response['invoice']['details'] = $builder->get()->getResultArray();


        return $this->response->setStatusCode(200)->setJSON($response);
        // return $this->response->setStatusCode(200)->setJSON($builder->get()->getRowArray());

    }

}

