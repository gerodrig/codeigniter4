<?php

namespace App\Controllers;

use App\Models\Customer_model;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Log\LoggerInterface;


//validation
use App\Controllers\BaseController;
use CodeIgniter\Validation\Exceptions\ValidationException;


// namespace App\Models;

class Customers extends BaseController
{
    protected $customerModel;
    protected $db;

    public function __construct()
    {
        // Connect to the database via the model
        $this->customerModel = new Customer_model();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $data = array('id' => 1, 'name' => 'Benito Martinez', 'contact' => 'Yayna Martinez','address' => '123 Main St');

        //capitalize name and contact

        // $data['name'] = strtoupper($data['name']);
        // $data['contact'] = strtoupper($data['contact']);
        $capitalize_fields = array('name', 'contact');

        echo json_encode(capitalize_array($data, $capitalize_fields ));

    }

    public function customer_get(){

        $customer_id = $this->request->uri->getSegment(3);

        //validate the segmend /customer id
        
        $customer = $this->customerModel->get_customer( $customer_id );
        
        if( $customer !== null ){
            $response = array('error' => false, 'message' => 'record loaded successfully', 'customer' => $customer);
            return $this->response->setStatusCode(200)->setJSON($response);
        } else {
            return $this->response->setStatusCode(400)->setJSON(array('error' => true, 'message' => 'Invalid customer id', 'customer' => null));
        }
    }

    public function paginate_get(){
        
        helper('pagination');

        $page = $this->request->uri->getSegment(3);
        $per_page = $this->request->uri->getSegment(4);

        $fields = array('id', 'name', 'phone1');
        $response = paginate_all('customers', $page, $per_page, $fields);


      
        return $this->response->setStatusCode(200)->setJSON($response);

    }

    public function customer_put(){

        $data = $this->request->getRawInput();

        //load code validation
        $validation = \Config\Services::validation();

        //set data to validate
        // $validation->setData($data);

        //?validate the data manually
        // $validation->setRules([
        //     'nombre' => 'required|min_length[3]|max_length[50]',
        //     'correo' => 'required|valid_email',
            // 'zip' => 'required|numeric',
            // 'telefono1' => 'required|numeric',
            // 'telefono2' => 'numeric',
            // 'pais' => 'required|min_length[3]|max_length[50]',
            // 'direccion' => 'required|min_length[3]|max_length[50]',
        // ]);

        //RULES WERE SET SEPARATELY IN CONFIG IN form_validation.php
        //another option is !$validation->withRequest($this->request)->run(null, 'customer_put'))
        if( $validation->run($data, 'customer_put') === FALSE ){
            //when validation fails
            return $this->response->setStatusCode(400)->setJSON(array('error' => true, 'message' => $validation->getErrors(), 'customer' => null));
        } 

        //check that email is unique before inserting in database
        $customer = $this->customerModel->set_data($data);

        $response = $customer->insert_customer();

        if( $response['error'] === true ){
            return $this->response->setStatusCode(400)->setJSON($response);
        }
        
        
        return $this->response->setStatusCode(201)->setJSON($response);
    }

    public function customer_post(){

        $data = $this->request->getRawInput();
        $customer_id = $this->request->uri->getSegment(3);
        
        $data['id'] = $customer_id;
        
        //load code validation
        $validation = \Config\Services::validation();
        
        if( $validation->run($data, 'customer_post') === FALSE ){
            //when validation fails
            return $this->response->setStatusCode(400)->setJSON(array('error' => true, 'message' => $validation->getErrors(), 'customer' => null));
        }
        
        
        $customer = $this->customerModel->set_data($data);

        // return $this->response->setStatusCode(400)->setJSON($customer);

        $response = $customer->update_customer($customer_id);

        if( $response['error'] === true ){
            return $this->response->setStatusCode(400)->setJSON($response);
        }

        return $this->response->setStatusCode(200)->setJSON($response);
    }

    public function customer_delete(){

        $customer_id = $this->request->uri->getSegment(3);

        $response = $this->customerModel->delete_customer($customer_id);

        if( $response['error'] === true ){
            return $this->response->setStatusCode(400)->setJSON($response);
        }

        return $this->response->setStatusCode(200)->setJSON($response);
    }
}

