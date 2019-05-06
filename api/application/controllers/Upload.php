<?php
class Startupload extends CI_Controller {

	public function index(){
				$config['upload_path']          = './uploads/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 100;
                $config['max_width']            = 1024;
                $config['max_height']           = 768;

                $this->load->library('upload', $config);

                if ( ! $this->upload->index('image'))
                {
                        $data = array('error' => $this->upload->display_errors());

                }
                else
                {
                        $data = array('upload_data' => $this->upload->data());

                }
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	
}
