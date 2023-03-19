<?php

namespace App\Models;

use CodeIgniter\Model;


class Customer_model extends Model {

    protected $db;
    protected $table = 'customers';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'active', 'email', 'zip', 'phone1', 'phone2', 'country', 'address'];

      // Define the properties
        public $id;
      public $name;
      public $active;
      public $email;
      public $zip;
      public $phone1;
      public $phone2;
      public $country;
      public $address;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }



    public function get_customer( $id){

        $builder = $this->db->table($this->table);
        $builder->where('id', $id);
        $builder->where('status', 'active');

        $query = $builder->get();

        // $row = $query->getRowObject(); // Use getRowObject() instead of getRow() or gerRowArray()

        // if( isset($row)){
        //     $row->id = intval($row->id);
        //     $row->activo = intval($row->activo);
        // }
        $row = $query->getRowArray(); // Use getRowObject() instead of getRow() or gerRowArray()

        if( isset($row)){
            $row['id'] = intval($row['id']);
            $row['active'] = intval($row['active']);
        }

        return $row;
 
    }

    public function set_data( $raw_data ){

        foreach( $raw_data as $key => $value ){
        
            if(property_exists($this, $key)){
                $this->$key = $value;
            }
        }

        //set the active field to 1 if it is null
        if( $this->active == null ){
            $this->active = 1;
        }

        //convert name to uppercase
        $this->name = strtoupper($this->name);

        //delete pager field from $this
        unset($this->pager);

        return $this;
    }

    public function insert_customer(){

        //Verify the email is unique
        
        $customer_email = $this->db->table('customers')->where('email', $this->email)->get()->getRowArray();
        // return $customer_email;

        if( $customer_email !== null ){
            //return this error if email already exists
            return array('error' => true, 'message' => 'Email already exists', 'customer' => null);
        }

        //validate the data
        // $customer = $this->customerModel->set_data($data);

        //if email is unique, insert in database
        $completed = $this->db->table('customers')->insert($this);

        if( $completed ){
            return array('error' => false, 'message' => 'Customer inserted successfully', 'customer_id' => $this->db->insertID() );
        } else {
            return array('error' => true, 'message' => 'Error inserting customer', 'error_message' => $this->db->error()['message'], 'error_num' => $this->db->error()['code'], 'customer' => null);
        }

    }

    public function update_customer(){
        
        //Verify the email is unique
        $customer_email = $this->db->table('customers')->where('email', $this->email)->where('id !=', $this->id)->get()->getRowArray();
        // return $customer_email;

        if( $customer_email !== null ){
            //return this error if email already exists
            return array('error' => true, 'message' => 'Email already exists', 'customer' => null);
        }

        
        //if email is unique, insert in database
        // echo json_encode($this);
        $completed = $this->db->table('customers')->where('id', $this->id)->update($this);


        if( $completed ){
            return array('error' => false, 'message' => 'Customer updated successfully', 'customer_id' => $this->id );
        } else {
            return array('error' => true, 'message' => 'Error updating customer', 'error_message' => $this->db->error()['message'], 'error_num' => $this->db->error()['code'], 'customer' => null);
        }
        
    }

    public function delete_customer( $customer_id ){

        $builder = $this->db->table($this->table);
        $builder->where('id', $customer_id);
        
        $completed = $builder->set('status', 'inactive')->update();


        if( $completed ){
            return array('error' => false, 'message' => 'Record deleted successfully', 'customer_id' => $this->id );
        } else {
            return array('error' => true, 'message' => 'Error updating customer', 'error_message' => $this->db->error()['message'], 'error_num' => $this->db->error()['code'], 'customer' => null);
        }

    }
}