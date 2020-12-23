<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Mahasiswa extends REST_Controller
{

    public function __construct(){
        parent::__construct();
        $this->load->model('Mahasiswa_model');
        
    }

    public function index_get(){
        $id= $this->get('id');
        if($id === null){
            $mahasiswa = $this->Mahasiswa_model->getMahasiswa();
            
        } else {
            $mahasiswa = $this->Mahasiswa_model->getMahasiswa($id);
            
        }
    

        if($mahasiswa){
            $this->response([
                'status' => true,
                'data' => $mahasiswa
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'data not found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_delete(){
        $id= $this->delete('id');

        if($id=== null){
            $this->response([
                'status' => false,
                'message' => 'provide an id'
            ], REST_Controller::HTTP_BAD_REQUEST);  
        } else {
            $mahasiswa = $this->Mahasiswa_model->getData($id); // "true"
            if($mahasiswa)
            {
                unlink('uploads/' . $mahasiswa->foto);
                $this->Mahasiswa_model->deleteMahasiswa($mahasiswa->id);
                $this->response([
                    'status' => true,
                    'data' => $id,
                    'message' => 'id deleted'
                ], REST_Controller::HTTP_OK);

            } else {
                $this->response([
                    'status' => false,
                    'message' => 'id not found'
                ], REST_Controller::HTTP_BAD_REQUEST); 

            }


            // if($this->Mahasiswa_model->deleteMahasiswa($id) > 0 ){
            //    // unlink('assets/foto/' . $mahasiswa[0]['foto']);
            //     //ok
            //     $this->response([
            //         'status' => true,
            //         'data' => $id,
            //         'message' => 'id deleted'
            //     ], REST_Controller::HTTP_OK);
            // } else {
            //     $this->response([
            //         'status' => false,
            //         'message' => 'id not found'
            //     ], REST_Controller::HTTP_BAD_REQUEST); 
            // }
   
        }
    }

    public function index_put()
    {
        $id= $this->put('id');
       
        $data= [ 
            'nrp' => $this->put('nrp'),
            'nama' => $this->put('nama'),
            'email' => $this->put('email'),
            'jurusan' => $this->put('jurusan'),
            'foto' => $this->put('foto')

        ];
        $this->db->where('id', $id);
        $update = $this->db->update('mahasiswa', $data);
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }

        // if($this->Mahasiswa_model->updateMahasiswa($data, $id)> 0){
        //     // if (!empty($_FILES["foto"]["name"])) {
        //     //     $this->foto = $this->uploadImage();
        //     // } 
        //     $this->response([
        //         'status' => true,
        //         'message' => 'update a new data'
        //     ], REST_Controller::HTTP_CREATED);
        // } else {
        //     $this->response([
        //         'status' => false,
        //         'message' => 'failed to updated data'
        //     ], REST_Controller::HTTP_BAD_REQUEST); 
        // }
        /* Close the streams */
        
    }

    public function index_post(){

        $foto= $this->uploadImage();
        $data= [
            'nrp' => $this->post('nrp'),
            'nama' => $this->post('nama'),
            'email' => $this->post('email'),
            'jurusan' => $this->post('jurusan'),
            'foto' => $foto
        ];

        if($this->Mahasiswa_model->createMahasiswa($data)> 0){
            $this->response([
                'status' => true,
                'message' => 'create a new data'
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed to create data'
            ], REST_Controller::HTTP_BAD_REQUEST); 
        }
    }

    

    public function uploadImage()
    {
      $config['upload_path'] = './uploads/';
      $config['allowed_types'] = 'gif|jpg|png';
      $config['overwrite'] = true;
      $config['max_size'] = 1024;

      $this->load->library('upload');
      $this->upload->initialize($config);

      if ( ! $this->upload->do_upload('foto'))
      {
        $error = array('error' => $this->upload->display_errors());
         print_r($error);
      //  $this->load->view('upload_form', $error);
      }
      else
      {
        return $this->upload->data("file_name");
      }
    }

    public function updatepost_post(){ 
		//$data = array();

		// $token  = $this->input->post('token'); 
		// $sql = "SELECT * FROM tb_token WHERE token='$token' order by id_token DESC";
		// $q = $this->db->query($sql);
		//if($q->num_rows() > 0){

            $id= $this->input->post('id');
            $foto= $this->uploadImage();
            $data= [ 
                'nrp' => $this->input->post('nrp'),
                'nama' => $this->input->post('nama'),
                'email' => $this->input->post('email'),
                'jurusan' => $this->input->post('jurusan'),
                'foto' => $foto
    
            ];

			// $id     = $this->input->post('id'); 
			// $nrp   = $this->input->post('nrp'); 
			// $nama   = $this->input->post('nama'); 	
			// $email   = $this->input->post('email'); 	
			// $jurusan   = $this->input->post('jurusan'); 	
			// $foto   = $this->uploadImage(); 	

			// $sql = "UPDATE mahasiswa
			// 	   SET nrp = '$nrp',
			// 	   	  nama = '$nama',
			// 	   	  email = '$email',
			// 	   	  jurusan = '$jurusan',
			// 	   	  foto = '$foto'
			// 	   WHERE id='$id'
			//        ";
			// $q = $this->db->query($sql);
            if($this->Mahasiswa_model->updateMahasiswa($data, $id)> 0){
            // if (!empty($_FILES["foto"]["name"])) {
            //     $this->foto = $this->uploadImage();
            // } 
            $this->response([
                'status' => true,
                'message' => 'update a new data'
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed to updated data'
            ], REST_Controller::HTTP_BAD_REQUEST); 
        }
			// if($q){				
			// 	$data['result'] = 'true';
			// 	$data['msg'] = 'Success Update Kategori';
			// }else{
			// 	$data['result'] = 'false';
			// 	$data['msg'] = 'Failed Update Kategori';
			// }
				
		// }else{
		// 	$data['result'] = 'false';
		// 	$data['msg'] = 'Invalid Token';
		// }

		echo json_encode($data);
	}
    private function _deleteImage($id)
    {
       
        $mahasiswa = $this->Mahasiswa_model->getMahasiswa($id);
        if ($mahasiswa['foto'] != "") {
            $filename = explode(".", $mahasiswa['foto'])[0];
            return array_map('unlink', glob(FCPATH."/uploads/$filename.*"));
        }
    }  
    
}