<?php

class Kecamatan_model extends CI_Model
{
    public function getKecamatan($id_kec =  null)
    {
        if($id_kec === null){
            return $this->db->get('kecamatan')->result_array();
        }else{
            
            return $this->db->get_where('kecamatan',['id_kec'=> $id_kec])->result_array();
        }
    }
    public function deleteKecamatan($id_kec)
    {
        $this->db->delete('kecamatan',['id_kec' =>$id_kec]);
        return $this->db->affected_rows();
    }
    public function createKecamatan($data)
    {
        $this->db->insert('kecamatan',$data);
        return $this->db->affected_rows();
    }
    public function updateKecamatan($data, $id_kec)
    {
        $this->db->update('kecamatan',$data,['id_kec'=>$id_kec]);
        return $this->db->affected_rows();
    }
}