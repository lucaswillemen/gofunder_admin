<?php
class Cota extends CI_Controller
{
    public function get()
    {
        $user = $this->user->check($this->input->get_request_header('Authorization'));
        $campaign_id = $this->input->get("campaign_id");
        $cotas = $this->db->where('campaign_id', $campaign_id)->get('campaign_cota')->result();
        $this->output->set_content_type('application/json')->set_output(json_encode($cotas));
    }

    public function add()
    {
        $user = $this->user->check($this->input->get_request_header('Authorization'));
        $campaign_id = $this->input->post("campaign_id");
        if (!$this->db->where("id", $campaign_id)->where("user_id", $user->id)->get("campaign")->row()) {
            $response = ['error' => 'NOT_YOUR_CAMPAIGN'];
            $this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode($response));
            exit();
        }        
        $data = $this->input->post(["campaign_id", "percent", "stock", "expiry", "min_donation"]);
        $data["stock_remain"] = $data["stock"];
        $this->db->insert('campaign_cota', $data);
        $this->output->set_content_type('application/json')->set_output(json_encode(["MSG" => "ADDED"]));
    }



    public function delete()
    {
        $user = $this->user->check($this->input->get_request_header('Authorization'));
        $cota = $this->db->where("id", $this->input->post("id"))->get("campaign_cota")->row();

        if (!$cota) {
            $response = ['error' => 'INVALID_COTA'];
            $this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode($response));
            exit();
        }

        if (!$this->db->where("id", $cota->campaign_id)->where("user_id", $user->id)->get("campaign")->num_rows()) {
            $response = ['error' => 'NOT_YOUR_CAMPAIGN'];
            $this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode($response));
            exit();
        }

        $this->db->where("id", $cota->id)->delete('campaign_cota');
        $this->output->set_content_type('application/json')->set_output(json_encode(["MSG" => "REMOVED"]));
    }

}