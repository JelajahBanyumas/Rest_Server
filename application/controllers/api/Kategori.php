<?php 

use Restserver\Libraries\REST_Controller_Definitions;

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/format.php';


class Kategori extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Kategori_model','kategori');
        //limit api usage
        $this->methods['index_get']['limit'] = [];
        $this->methods['index_delete']['limit'] = [];
        $this->methods['index_update']['limit'] = [];
    }
    public function index_get()
    {
        $id_kategori = $this->get('id_kategori');
        if($id_kategori === null){
            $kategori = $this->kategori->getKategori();
        }else{
            $kategori = $this->kategori->getKategori($id_kategori);
        }

        if($kategori){
            $this->response([
                'status'=>true,
                'data'=>$kategori
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
        $id_kategori=$this->delete('id_kategori');

        if ($id_kategori ===null){
            $this->response([
                'status'=>false,
                'message'=>'provide id pls'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }else {
            if($this->kategori->deleteKategori($id_kategori)> 0){
                //ok
                $this->response([
                    'status'=>true,
                    'id'=>$id_kategori,
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
            'id_kategori' =>$this->post('id_kategori'), 
            'kategori' =>$this->post('kategori')
        ];
        if ($this->kategori->createKategori($data)>0){
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
        $id_kategori = $this->put('id_kategori');
        $data = [
            'id_kategori' =>$this->post('id_kategori'), 
            'kategori' =>$this->post('kategori')
        ];
        if ($this->kategori->updateKategori($data, $id_kategori)> 0){
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