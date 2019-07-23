<?php
class Auth extends CI_Controller
{

    public function register()
    {

        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        if (!$password || !$email || !$name) {
            $response = ['error'=>'INVALID_FORM'];
            return $this->output->set_content_type('application/json')->set_status_header(404)->set_output(json_encode($response));
        }

        if ($this->db->where('email', $email)->get('user')->row()) {
            $response = ['error'=>'ALREADY_EXIST_EMAIL'];
            $this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode($response));
        }
        $user = new stdClass;
        $user->name = $name;
        $user->email = $email;
        $user->password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 7]);
        $user->token = hash('ripemd160', $email.$password);

        $this->db->insert('user', $user);
        $user->id = $this->db->insert_id();

        $this->output->set_content_type('application/json')->set_output(json_encode($user));
    }

    public function edit_email()
    {
        $data = $this->input->post(["newEmail","password"]);
        $user = $this->user->check($this->input->get_request_header('Authorization'));
        if (!filter_var($data["newEmail"], FILTER_VALIDATE_EMAIL)) {
            $response = ['error'=>'INVALID_EMAIL'];
            return $this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode($response));
        }
        if (!password_verify($data["password"], $user->password)) {
            $response = ['error'=>'WRONG_PASSWORD'];
            return $this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode($response));
        }

        $this->db->where("id", $user->id)->update("user", [
            "email"=>$data["newEmail"],
            "email_confirm_code" => rand(100000, 99999999),
            "email_confirmed" => 0
        ]);
        // enviar token pra ele
        $this->output->set_content_type('application/json')->set_output(json_encode(["MSG"=>(array)$this->user->check($this->input->get_request_header('Authorization'))]));
    }






    public function check()
    {		
        $user = $this->user->check($this->input->get_request_header('Authorization'));
        $this->output->set_content_type('application/json')->set_output(json_encode($user));
    }

    public function login()
    {

        $email = $this->input->post('email');
        $password = $this->input->post('password');

        if (!$password || !$email) {
            $response = ['error'=>'INVALID_FORM'];
            return $this->output->set_content_type('application/json')->set_status_header(404)->set_output(json_encode($response));
        }
        $user = $this->db->select('*')->where('email', $email)->get('user')->row();

        if (!$user) {
            $response = ['error'=>'WRONG_EMAIL'];
            return $this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode($response));
        }
        if (!password_verify($password, $user->password)) {
            $response = ['error'=>'WRONG_PASSWORD'];
            return $this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode($response));
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($user));
    }

    public function send_recover_email()
    {
        $data = $this->input->post(["email"]);
        $user = $this->db->where("email", $data["email"])->get("user")->row();
        if(!$user) {
            $this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode(["MSG"=>"INVALID_EMAIL"]));
        }
        $codeEmail = strtoupper(bin2hex(random_bytes(6)));
        // enviar $codeEmail para $data["email"]
        $this->db->where("email", $data["email"])->update("user", ["recover_token"=>$codeEmail]);
        $this->output->set_content_type('application/json')->set_output(json_encode(["MSG"=>"CHECK_EMAIL"]));
    }

    public function edit_password()
    {
        $data = $this->input->post(["newPassword1","password"]);
        $user = $this->user->check($this->input->get_request_header('Authorization'));
        if (!password_verify($data["password"], $user->password)) {
            return $this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode(['error'=>'WRONG_PASSWORD']));
        }
        $this->db->where("id", $user->id)->update("user", ["recover_token"=>"", "password"=>password_hash($data["newPassword1"], PASSWORD_BCRYPT, ['cost' => 7])]);
        $this->output->set_content_type('application/json')->set_output(json_encode(["MSG"=>(array)$this->db->where("id", $user->id)->get("user")->row()]));
    }



    public function change_password_recover()
    {
        $data = $this->input->post(["newpass", "code", "email"]);
        $user = $this->db->where("email", $data["email"])->where("recover_token", $data["code"])->get("user")->row();
        if(!strlen($data["code"]) || !$user) {
            $this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode(["MSG"=>"INVALID_CODE"]));
        }
        $this->db->where("email", $data["email"])->update("user", ["recover_token"=>"", "password"=>password_hash($data["newpass"], PASSWORD_BCRYPT, ['cost' => 7])]);
        $this->output->set_content_type('application/json')->set_output(json_encode(["MSG"=>"ALTERED"]));
    }





}
