<?php
class Profile extends CI_Controller {
	
	public function register(){
		$user = $this->user->check($this->input->get_request_header('Authorization'));
		$name = $this->input->post('name');
		$email = $this->input->post('email');

		if ( !$email || !$name) {
			$response = ['error'=>'INVALID_FORM'];
			return $this->output->set_content_type('application/json')->set_status_header(404)->set_output(json_encode($response));
			exit();
		}

		$update = new stdClass;
		$update->name = $name;
		$update->email = $email;

		$this->db->where("id", $user->id)->update('user', $update);

		$this->output->set_content_type('application/json')->set_output(json_encode(true));
	}
	
	public function password(){
		$user = $this->user->check($this->input->get_request_header('Authorization'));
		$old_password = $this->input->post('old_password');
		$new_password = $this->input->post('new_password');

		if (!$old_password || !$new_password) {
			$response = ['error'=>'INVALID_FORM'];
			return $this->output->set_content_type('application/json')->set_status_header(404)->set_output(json_encode($response));
			exit();
		}

	    if (!password_verify($old_password, $user->password)) {
			$response = ['error'=>'WRONG_PASSWORD'];
			return $this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode($response));
	      	exit();
	    }

		$update = new stdClass;
		$update->password = password_hash($new_password, PASSWORD_BCRYPT, ['cost' => 7]);

		$this->db->where("id", $user->id)->update('user', $update);

		$this->output->set_content_type('application/json')->set_output(json_encode(true));
	}
	
	public function address(){
		$user = $this->user->check($this->input->get_request_header('Authorization'));
		
		$request = $this->input->server('REQUEST_METHOD');

		if ($request == "GET") {
			$res = $this->db->where('user_id', $user->id)->get('user_address')->row();
			$this->output->set_content_type('application/json')->set_output(json_encode(true));
			exit();
		}


		$id = $this->input->post('id');
		$state = $this->input->post('state');
		$city = $this->input->post('city');
		$address = $this->input->post('address');
		$number = $this->input->post('number');
		$zipcode = $this->input->post('zipcode');
		$neighborhood = $this->input->post('neighborhood');
		$complement = $this->input->post('complement');

		$insert = [
			"state" => $state,
			"city" => $city,
			"address" => $address,
			"number" => $number,
			"zipcode" => $zipcode,
			"neighborhood" => $neighborhood,
			"complement" => $complement,
			"user_id" => $user->id,
		];

		if ($id) {
			$this->db->where("id", $id)->where("user_id", $user->id)->delete('user_address');
		}else{
			$this->db->insert('user_address', $insert);	
		}


		$this->output->set_content_type('application/json')->set_output(json_encode(true));
	}
}
