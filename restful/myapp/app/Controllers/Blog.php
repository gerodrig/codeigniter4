<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;


class Blog extends BaseController
{
    public function index()
    {
        echo 'Hello World!';
    }

    public function comments($id = null)
    {

        if( !is_numeric($id) )
        {
            $response= array('error' => true, 'message' => 'id must be numberic');
            echo json_encode($response);
            return;
        }

        $comments = array(
            array('id' => 1, 'message' => 'Hello World!'),
            array('id' => 2, 'message' => 'Goodbye World!'),
            array('id' => 3, 'message' => 'Hello Comments!'),
            array('id' => 4, 'message' => 'Goodbye Comments!'),
        );

        if( $id >= count($comments) && $id < 0 )
        {
            $response= array('error' => true, 'message' => 'Comment not found with id '.$id.' ID not found');
            echo json_encode($response);
            return;
        }

    }

    // public function view($page = 'comments')
    // {
    //     if(!is_file(APPPATH.'/Views/pages/'.$page.'.php'))
    //     {
    //         throw new PageNotFoundException($page);
    //     }

    //     $data['title'] = ucfirst($page); // Capitalize the first letter

    //     return view('templates/header', $data).
    //            view('pages/'.$page, $data).
    //            view('templates/footer', $data);
    // }
}