<?php

class Desa_model extends CI_Model
{
    public function getDesa($id_desa =  null)
    {
        if($id_desa === null){
            return $this->db->get('desa')->result_array();
        }else{
            
            return $this->db->get_where('desa',['id_desa'=> $id_desa])->result_array();
        }
    }
    public function deleteDesa($id_desa)
    {
        $this->db->delete('desa',['id_desa' =>$id_desa]);
        return $this->db->affected_rows();
    }
    public function createDesa($data)
    {
        $this->db->insert('desa',$data);
        return $this->db->affected_rows();
    }
    public function updateDesa($data, $id_desa)
    {
        $this->db->update('desa',$data,['id_desa'=>$id_desa]);
        return $this->db->affected_rows();
    }
}