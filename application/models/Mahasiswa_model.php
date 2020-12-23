<?php

class Absen_model extends CI_Model
{
    public function getMahasiswa($id = null)
    {

    //     $query = $this->db->query("select * from `tbl_user`");
    //    return $query->result_array();

        if($id=== null){
            return $this->db->get('mahasiswa')->result_array();
            
        } else {
            return $this->db->get_where('mahasiswa', ['id' => $id])->result_array();
        }
    }

    public function getData($id)
    {
        $query = $this->db->get_where('mahasiswa', ['id'=>$id]);
        if($query->num_rows() > 0)
        {
            return $query->row();
        } else {
            return false;
        }
    }

    public function deleteMahasiswa($id)
    {
       
        $this->db->delete('mahasiswa', ['id'=> $id]);
        return $this->db->affected_rows();
    }

    public function createMahasiswa($data)
    {
        $this->db->insert('mahasiswa', $data);
        return $this->db->affected_rows();
    }

    public function updateMahasiswa($data, $id)
    {
        $this->db->update('mahasiswa', $data, ['id'=> $id]);
        // $this->db->set($nrp, $nama, $email, $jurusan);
        //  $this->db->where('id', $id);
        //  $this->db->update('mahasiswa');
        return $this->db->affected_rows();

    }

     

    
}