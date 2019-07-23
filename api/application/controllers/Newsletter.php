<?php
class Newsletter extends CI_Controller
{

    public function add() {
        $this->db->insert("newsletter_emails", [
            "email" => $this->input->post("email"),
            "name" => $this->input->post("name"),
        ]);
        $this->output->set_content_type('application/json')->set_output(json_encode(["MSG"=>"ADDED"]));
    }

}
