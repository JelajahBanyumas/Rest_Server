<?php 

use Restserver\Libraries\REST_Controller_Definitions;

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/format.php';


class Kecamatan extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Kecamatan_model','kecamatan');
        //limit api usage
        $this->methods['index_get']['limit'] = [];
        $this->methods['index_delete']['limit'] = [];
        $this->methods['index_update']['limit'] = [];
    }
    public function index_get()
    {
        $id_kec = $this->get('id_kec');
        if($id_kec === null){
            $kecamatan = $this->kecamatan->getKecamatan();
        }else{
            $kecamatan = $this->kecamatan->getKecamatan($id_kec);
        }

        if($kecamatan){
            $this->response([
                'status'=>true,
                'data'=>$kecamatan
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
        $id_kec=$this->delete('id_kec');

        if ($id_kec ===null){
            $this->response([
                'status'=>false,
                'message'=>'provide id pls'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }else {
            if($this->kecamatan->deleteKecamatan($id_kec)> 0){
                //ok
                $this->response([
                    'status'=>true,
                    'id'=>$id_kec,
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
            'id_kec' =>$this->post('id_kec'), 
            'kecamatan' =>$this->post('kecamatan'),
        ];
        if ($this->kecamatan->createKecamatan($data)>0){
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
        $id_kec = $this->put('id_kec');
        $data = [
            'id_kec' =>$this->post('id_kec'), 
            'kecamatan' =>$this->post('kecamatan'),
        ];
        if ($this->kecamatan->updateKecamatan($data, $id_kec)> 0){
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