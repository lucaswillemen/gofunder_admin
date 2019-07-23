<?php
class Other extends CI_Controller
{
    public function category_list() {
        $this->output->set_content_type('application/json')->set_output(json_encode($this->db->get("category")->result_array()));
    }
}
