<?php
class Home extends CI_Controller {

	public function index(){
		$user = $this->user->check($this->input->get_request_header('Authorization'));

		unset($user->id);
		$this->output->set_content_type('application/json')->set_output(json_encode($user));
	}


}
