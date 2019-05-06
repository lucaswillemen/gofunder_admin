<?php
class Startupload extends CI_Controller {

	public function index(){
		$config['upload_path']          = './uploads/';
        $config['allowed_types']        = 'jpg|png';

        $this->load->library('upload', $config);
        $this->upload->do_upload('image');
        var_dump($this->upload->data());
	}	
}
