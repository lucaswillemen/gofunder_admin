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
            exit();
        }

        if ($this->db->where('email', $email)->get('user')->row()) {
            $response = ['error'=>'ALREADY_EXIST_EMAIL'];
            $this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode($response));
            exit();
        }

        $user = new stdClass;
        $user->name = $name;
        $user->email = $email;
        $user->password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 7]);
        $user->token = hash('ripemd160', $email.$password);

        $this->db->insert('user', $user);
        $user->id = $this->db->insert_id();

        unset($user->id, $user->pass);
        $this->output->set_content_type('application/json')->set_output(json_encode($user));
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
            exit();
        }


        $user = $this->db->select('*')->where('email', $email)->get('user')->row();

        if (!$user) {
            $response = ['error'=>'WRONG_EMAIL'];
            return $this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode($response));
            exit();
        }
        if (!password_verify($password, $user->password)) {
            $response = ['error'=>'WRONG_PASSWORD'];
            return $this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode($response));
            exit();
        }
        unset($user->password, $user->id);
        $this->output->set_content_type('application/json')->set_output(json_encode($user));
    }

    public function send_recover_email()
    {
        $data = $this->input->post(["email"]);
        $user = $this->db->where("email", $data["email"])->get("user")->row();
        (!$user) &&  $this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode(["MSG"=>"INVALID_EMAIL"]));
        $this->db->where("email", $data["email"])->update("user", ["recover_token"=>strtoupper(bin2hex(random_bytes(6)));]);
        $this->output->set_content_type('application/json')->set_output(json_encode(["MSG"=>"CHECK_EMAIL"]));
    }

    public function change_password_recover()
    {
        $data = $this->input->post(["newpass", "code", "email"]);
        $user = $this->db->where("email", $data["email"])->where("recover_token", $data["code"])->get("user")->row();
        (!$user) &&$this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode(["MSG"=>"INVALID_CODE"]));
        $this->db->where("email", $data["email"])->update("user", ["recover_token"=>"", "password"=>password_hash($data["newpass"], PASSWORD_BCRYPT, ['cost' => 7])]);
        $this->output->set_content_type('application/json')->set_output(json_encode(["MSG"=>"ALTERED"]));
    }

}
