<?php 

use Restserver\Libraries\REST_Controller_Definitions;

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/format.php';


class Admin extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_model','admin');
        //limit api usage
        $this->methods['index_get']['limit'] = [];
        $this->methods['index_delete']['limit'] = [];
        $this->methods['index_update']['limit'] = [];
    }
    public function index_get()
    {
        $id = $this->get('id');
        if($id === null){
            $admin = $this->admin->getAdmin();
        }else{
            $admin = $this->admin->getAdmin($id);
        }

        if($admin){
            $this->response([
                'status'=>true,
                'data'=>$admin
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status'=>false,
                'message'=>'id not found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_delete()
    {
        $id=$this->delete('id');

        if ($id ===null){
            $this->response([
                'status'=>false,
                'message'=>'provide id pls'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }else {
            if($this->admin->deleteAdmin($id)> 0){
                //ok
                $this->response([
                    'status'=>true,
                    'id'=>$id,
                    'message'=>'deleted.'
                ], REST_Controller::HTTP_ACCEPTED);
            }else{
                //id not found
                $this->response([
                    'status'=>false,
                    'message'=>'id not found'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function index_post()
    {
        $data = [
            'username' =>$this->post('username'),
            'email' =>$this->post('email'),
            'telepon' =>$this->post('telepon'),
            'password' =>$this->post('password'),  
        ];
        if ($this->admin->createAdmin($data)>0){
            $this->response([
                'status'=>true,
                'message'=>'new data added'
            ], REST_Controller::HTTP_CREATED);
        }else{
            $this->response([
                'status'=>false,
                'message'=>'failed to add data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    public function index_put()
    {
        $id = $this->put('id');
        $data = [
            'username' =>$this->put('username'),
            'email' =>$this->put('email'),
            'telepon' =>$this->put('telepon'),
            'password' =>$this->put('password')
        ];
        if ($this->admin->updateAdmin($data, $id)> 0){
            $this->response([
                'status'=>true,
                'message'=>'data updated'
            ], REST_Controller::HTTP_ACCEPTED);
        }else{
            $this->response([
                'status'=>false,
                'message'=>'failed update'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
} 