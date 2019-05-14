<?php
class Image extends CI_Controller
{


	public function send()
	{
		$config['upload_path']          = './uploads/etc/';
		$config['allowed_types']        = 'jpg|png';
		$config['encrypt_name']  = true;
		$this->load->library('upload', $config);
		$this->upload->do_upload('upload');

		$this->output->set_content_type('application/json')->set_output(json_encode( [
			"url" => "uploads/etc/" . $this->upload->data('file_name')
		]));
	}


}
