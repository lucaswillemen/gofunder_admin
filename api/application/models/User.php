<?php
class User extends CI_Model {

    public function check($token)
    {   
        $user = $this->db->select('*')->where("token", $token)->get('user')->row();
        if (!$user && $this->input->method()!="options") {      
			$this->output->set_content_type('application/json')->set_status_header(401);
			exit();
        }
        unset($user->password);
        return $user;
    }

}

