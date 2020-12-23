<?php

	class API extends CI_Controller
	{

	public function index()
	{
		date_default_timezone_set('Asia/Jakarta');
		error_reporting(E_ALL);
		ini_set('display_errors', 1);
		$this->load->helper('date');
	}

	public function add_token(){ 
		$data       = array();
		$id_device  = $this->input->post('id_device'); 
		$key        = $this->input->post('key'); 
		$token      = bin2hex(random_bytes(64));

		if($key=="fluttertalk02"){
			$sql = "SELECT * FROM tb_token WHERE id_device='$id_device' order by id_token DESC";
			$q = $this->db->query($sql);

			if($q->num_rows() > 0){
				$data['result'] = 'false';
				$data['msg']    = 'Device Already';
			}else{


				$sql        = "INSERT INTO tb_token
							(id_device,token)
							VALUES('$id_device','$token');
						";
					
				$q          = $this->db->query($sql);

				if($q){				
					$data['result']  = 'true';
					$data['msg']     = 'Success Add Token';
				}else{
					$data['result']  = 'false';
					$data['msg']     = 'Failed Add Token';
				}
				
			}
			
		}else{
			$data['result'] = 'false';
			$data['msg']    = 'Invalid Key';
		}



		echo json_encode($data);
	}

	
	public function get_all_token(){ 
		$data  = array();
		$key   = $this->input->post('key');
		
		if($key=="fluttertalk02"){
			$sql  = "SELECT * FROM tb_token order by id_token DESC";
			$q    = $this->db->query($sql);
			if($q->num_rows() > 0){				
				$data['result'] = 'true';
				$data['msg']    = 'Token';
				$data['data']   = $q->result();
			}else{
				$data['result'] = 'false';
				$data['msg']    = 'Tidak ada data';
			}
		}else{
			$data['result'] = 'false';
			$data['msg']    = 'Invalid Key';
		}

		echo json_encode($data);
	}

	public function add_kategori(){ 
		$data = array();

		$token  = $this->input->post('token'); 
		$sql = "SELECT * FROM tb_token WHERE token='$token' order by id_token DESC";
		$q = $this->db->query($sql);
		if($q->num_rows() > 0){

			$id_device      = $this->input->post('id_device'); 
			$nama_kategori  = $this->input->post('nama_kategori'); 
			$icon_kategori  = $this->input->post('icon_kategori'); 

			$sql = "INSERT INTO tb_kategori_catatan
				(nama_kategori,icon_kategori)
				VALUES('$nama_kategori','$icon_kategori')
				";
			$q = $this->db->query($sql);

			if($q){				
				$data['result'] = 'true';
				$data['msg'] = 'Success Add Kategori';
			}else{
				$data['result'] = 'false';
				$data['msg'] = 'Failed Add Kategori';
			}
				
		}else{
			$data['result'] = 'false';
			$data['msg'] = 'Invalid Token';
		}

		echo json_encode($data);
	}


	public function get_all_kategori(){ 
		$data = array();
		
		$token   = $this->input->post('token'); 
		$sql     = "SELECT * FROM tb_token WHERE token='$token' order by id_token DESC";
		$q       = $this->db->query($sql);

		if($q->num_rows() > 0){
			$sql = "SELECT * FROM tb_kategori_catatan";
			$q = $this->db->query($sql);
			if($q->num_rows() > 0){				
				$data['result'] = 'true';
				$data['msg'] = 'Kategori';
				$data['data'] = $q->result();
			}else{
				$data['result'] = 'false';
				$data['msg'] = 'Tidak ada data';
			}			
		}else{
			$data['result'] = 'false';
			$data['msg'] = 'Invalid Token';
		}

		echo json_encode($data);
	}

	public function update_kategori(){ 
		$data = array();

		$token  = $this->input->post('token'); 
		$sql = "SELECT * FROM tb_token WHERE token='$token' order by id_token DESC";
		$q = $this->db->query($sql);
		if($q->num_rows() > 0){

			$id_kategori     = $this->input->post('id_kategori'); 
			$nama_kategori   = $this->input->post('nama_kategori'); 
			$icon_kategori   = $this->input->post('icon_kategori'); 	

			$sql = "UPDATE tb_kategori_catatan
				   SET nama_kategori = '$nama_kategori',
				   	  icon_kategori = '$icon_kategori'
				   WHERE id_kategori='$id_kategori'
			       ";
			$q = $this->db->query($sql);

			if($q){				
				$data['result'] = 'true';
				$data['msg'] = 'Success Update Kategori';
			}else{
				$data['result'] = 'false';
				$data['msg'] = 'Failed Update Kategori';
			}
				
		}else{
			$data['result'] = 'false';
			$data['msg'] = 'Invalid Token';
		}

		echo json_encode($data);
	}

	public function delete_kategori(){ 
		$data = array();

		$token  = $this->input->post('token'); 
		$sql = "SELECT * FROM tb_token WHERE token='$token' order by id_token DESC";
		$q = $this->db->query($sql);
		if($q->num_rows() > 0){

			$id_mutasi     = $this->input->post('id_kategori'); 

			$sql = "DELETE FROM tb_kategori_catatan
				   WHERE id_kategori='$id_kategori'
			       ";
			$q = $this->db->query($sql);

			if($q){				
				$data['result'] = 'true';
				$data['msg'] = 'Success Delete Kategori';
			}else{
				$data['result'] = 'false';
				$data['msg'] = 'Failed Delete Kategori';
			}
				
		}else{
			$data['result'] = 'false';
			$data['msg'] = 'Invalid Token';
		}

		echo json_encode($data);
	}



	public function add_mutasi(){ 
		$data = array();

		$token  = $this->input->post('token'); 
		$sql = "SELECT * FROM tb_token WHERE token='$token' order by id_token DESC";
		$q = $this->db->query($sql);
		if($q->num_rows() > 0){

			$id_device     = $this->input->post('id_device'); 
			$id_kategori   = $this->input->post('id_kategori'); 
			$mutasi        = $this->input->post('mutasi'); 
			$judul         = $this->input->post('judul'); 
			$deskripsi     = $this->input->post('deskripsi'); 
			$nominal       = $this->input->post('nominal'); 
			$tgl           = $this->input->post('tgl'); 	

			$sql = "INSERT INTO tb_catatan_mutasi
				(id_device,id_kategori,mutasi,judul,deskripsi,nominal,tgl)
				VALUES('$id_device','$id_kategori','$mutasi','$judul','$deskripsi','$nominal','$tgl')
				";
			$q = $this->db->query($sql);

			if($q){				
				$data['result'] = 'true';
				$data['msg'] = 'Success Add Catatan';
			}else{
				$data['result'] = 'false';
				$data['msg'] = 'Failed Add Catatan';
			}
				
		}else{
			$data['result'] = 'false';
			$data['msg'] = 'Invalid Token';
		}

		echo json_encode($data);
	}

	public function get_all_mutasi(){ 
		$data = array();

          $id_device = $this->input->post('id_device'); 
		$token  = $this->input->post('token'); 
		$sql = "SELECT * FROM tb_token WHERE token='$token' order by id_token DESC";
		$q = $this->db->query($sql);

		if($q->num_rows() > 0){
			$sql = "SELECT * FROM tb_catatan_mutasi where id_device='$id_device' ORDER BY id_mutasi DESC";
			$q = $this->db->query($sql);
			if($q->num_rows() > 0){				
				$data['result'] = 'true';
				$data['msg']    = 'All Mutasi';
				$data['data']   = $q->result();
			}else{
				$data['result'] = 'false';
				$data['msg']     = 'Tidak ada data';
			}
		}else{
			$data['result'] = 'false';
			$data['msg']    = 'Invalid Token';	
		}

		echo json_encode($data);
	}
	



	public function update_mutasi(){ 
		$data = array();

		$token  = $this->input->post('token'); 
		$sql = "SELECT * FROM tb_token WHERE token='$token' order by id_token DESC";
		$q = $this->db->query($sql);
		if($q->num_rows() > 0){

			$id_mutasi     = $this->input->post('id_mutasi'); 
			$id_device     = $this->input->post('id_device'); 
			$id_kategori   = $this->input->post('id_kategori'); 
			$mutasi        = $this->input->post('mutasi'); 
			$judul         = $this->input->post('judul'); 
			$deskripsi     = $this->input->post('deskripsi'); 
			$nominal       = $this->input->post('nominal'); 
			$tgl           = $this->input->post('tgl'); 	

			$sql = "UPDATE tb_catatan_mutasi
				   SET id_kategori = '$id_kategori',
				   	  mutasi = '$mutasi',
					  judul = '$judul',
					  deskripsi = '$deskripsi',
					  nominal = '$nominal',
					  tgl = '$tgl'
				   WHERE id_mutasi='$id_mutasi'
			       ";
			$q = $this->db->query($sql);

			if($q){				
				$data['result'] = 'true';
				$data['msg'] = 'Success Update Catatan';
			}else{
				$data['result'] = 'false';
				$data['msg'] = 'Failed UPdate Catatan';
			}
				
		}else{
			$data['result'] = 'false';
			$data['msg'] = 'Invalid Token';
		}

		echo json_encode($data);
	}



	public function delete_mutasi(){ 
		$data = array();

		$token  = $this->input->post('token'); 
		$sql = "SELECT * FROM tb_token WHERE token='$token' order by id_token DESC";
		$q = $this->db->query($sql);
		if($q->num_rows() > 0){

			$id_mutasi     = $this->input->post('id_mutasi'); 

			$sql = "DELETE FROM tb_catatan_mutasi
				   WHERE id_mutasi='$id_mutasi'
			       ";
			$q = $this->db->query($sql);

			if($q){				
				$data['result'] = 'true';
				$data['msg'] = 'Success Delete Catatan';
			}else{
				$data['result'] = 'false';
				$data['msg'] = 'Failed Delete Catatan';
			}
				
		}else{
			$data['result'] = 'false';
			$data['msg'] = 'Invalid Token';
		}

		echo json_encode($data);
	}

	public function reset_all_mutasi(){ 
		$data = array();

		$token  = $this->input->post('token'); 
		$id_device = $this->input->post('id_device'); 
		$sql = "SELECT * FROM tb_token WHERE token='$token' order by id_token DESC";
		$q = $this->db->query($sql);
		if($q->num_rows() > 0){

			$sql = "DELETE FROM tb_catatan_mutasi WHERE id_device='$id_device'";
			$q = $this->db->query($sql);

			if($q){				
				$data['result'] = 'true';
				$data['msg'] = 'Success Reset Catatan';
			}else{
				$data['result'] = 'false';
				$data['msg'] = 'Failed Reset Catatan';
			}
				
		}else{
			$data['result'] = 'false';
			$data['msg'] = 'Invalid Token';
		}

		echo json_encode($data);
	}

	public function get_mutasi_in(){ 
		$data = array();

          $id_device = $this->input->post('id_device'); 
		$token  = $this->input->post('token'); 
		$sql = "SELECT * FROM tb_token WHERE token='$token' order by id_token DESC";
		$q = $this->db->query($sql);

		if($q->num_rows() > 0){
			$sql = "SELECT sum(nominal)as total_in FROM tb_catatan_mutasi where id_device='$id_device' AND mutasi='IN' ORDER BY id_mutasi DESC limit 1";
			$q = $this->db->query($sql);
			if($q->num_rows() > 0){				
				$data['result'] = 'true';
				$data['msg']    = 'Total Mutasi IN';
				$data['data']   = $q->result();
			}else{
				$data['result'] = 'false';
				$data['msg']     = 'Tidak ada data';
			}		
		}else{
			$data['result'] = 'false';
			$data['msg']    = 'Invalid Token';	
		}

		echo json_encode($data);
	}

	public function get_mutasi_out(){ 
		$data = array();

          $id_device = $this->input->post('id_device'); 
		$token  = $this->input->post('token'); 
		$sql = "SELECT * FROM tb_token WHERE token='$token' order by id_token DESC";
		$q = $this->db->query($sql);

		if($q->num_rows() > 0){
			$sql = "SELECT sum(nominal)as total_out FROM tb_catatan_mutasi where id_device='$id_device' AND mutasi='OUT' ORDER BY id_mutasi DESC";
			$q = $this->db->query($sql);
			if($q->num_rows() > 0){				
				$data['result'] = 'true';
				$data['msg']    = 'Total Mutasi OUT';
				$data['data']   = $q->result();;
			}else{
				$data['result'] = 'false';
				$data['msg']     = 'Tidak ada data';
			}
		}else{
			$data['result'] = 'false';
			$data['msg']    = 'Invalid Token';	
		}

		echo json_encode($data);
	}

	



}