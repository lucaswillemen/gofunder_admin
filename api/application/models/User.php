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
    public function position($id, $comand, $side){
        $sider = $this->db->where('id', $id)->where($comand, '0')->get('users')->row();
        if (!$sider) {
            $allowed = $this->db->where('id', $id)->get('users')->row();
            return $allowed;
        }else{
            return $this->position($sider->$side, $comand, $side);
        }
    }
    public function extratar($id, $usd, $desc){
        $data = [
            "user_id" => $id,
            "usd" => $usd,
            "desc" => $desc,
        ];
        $this->db->insert("extract", $data);
    }

}

