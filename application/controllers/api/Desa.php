<?php 

use Restserver\Libraries\REST_Controller_Definitions;

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/format.php';


class Desa extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Desa_model','desa');
        //limit api usage
        $this->methods['index_get']['limit'] = [];
        $this->methods['index_delete']['limit'] = [];
        $this->methods['index_update']['limit'] = [];
    }
    public function index_get()
    {
        $id_desa = $this->get('id_desa');
        if($id_desa === null){
            $desa = $this->desa->getDesa();
        }else{
            $desa = $this->desa->getDesa($id_desa);
        }

        if($desa){
            $this->response([
                'status'=>true,
                'data'=>$desa
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
        $id_desa=$this->delete('id_desa');

        if ($id_desa ===null){
            $this->response([
                'status'=>false,
                'message'=>'provide id pls'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }else {
            if($this->desa->deleteDesa($id_desa)> 0){
                //ok
                $this->response([
                    'status'=>true,
                    'id'=>$id_desa,
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
            'id_desa' =>$this->post('id_desa'), 
            'id_kec' =>$this->post('id_kec'),
            'desa' =>$this->post('desa')
        ];
        if ($this->desa->createDesa($data)>0){
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
        $id_desa = $this->put('id_desa');
        $data = [
            'id_desa' =>$this->post('id_desa'), 
            'id_kec' =>$this->post('id_kec'),
            'desa' =>$this->post('desa')
        ];
        if ($this->desa->updateDesa($data, $id_desa)> 0){
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