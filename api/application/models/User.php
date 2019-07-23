<?php
class User extends CI_Model
{

    public function __construct() {
        
        $headers = [];
        $headers["Access-Control-Allow-Origin"] = isset($_SERVER['HTTP_ORIGIN']) ?  $_SERVER['HTTP_ORIGIN'] : "";
        $headers["Access-Control-Allow-Methods"] = "POST, GET, OPTIONS, PUT, DELETE";
        $headers["Access-Control-Allow-Credentials"] = "true";
        $headers["Access-Control-Max-Age"] = "86400";
        $headers["Access-Control-Allow-Headers"]	= "Content-Type, Authorization, X-Requested-With, token";
        $headers["Access-Control-Allow-Headers"]	= "Content-Type, Content-Length, Accept-Encoding, Authorization, X-Requested-With";

        $method = $_SERVER['REQUEST_METHOD'];
        foreach($headers as $headerName => $headerValue) {
            header(sprintf("%s: %s", $headerName, $headerValue));
        }
        if($method == 'OPTIONS') {
            header('HTTP/1.1 200 OK');
            die("options die");
        }     
    }
    public function check($token)
    {
        $user = $this->db->select('*')->where("token", $token)->get('user')->row();

        if (!$user) {
            $this->output->set_content_type('application/json')->set_status_header(401);
            exit();
        }

        return $user;
    }

}
