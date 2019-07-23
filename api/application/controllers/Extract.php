<?php

class Extract extends CI_Controller {

    public function user() {
        $user = $this->db->select('*')->where("token", $this->input->get_request_header('Authorization'))->get('user')->row();

        $orders = ["amount", "created_at"];

        $order_by = $this->input->post("order_by");

        if(!in_array($order_by, $orders)) $order_by = $orders[1];


        $extractInfo = $this->db
            ->where("user_id", $user->id)
            ->order_by($order_by, 'asc' == $this->input->post("order_type") ? "asc" : "desc")
            ->limit(10,10*$this->input->post("page"))
            ->get("extract_user")    
            ->result_array();

        $totalRows = $this->db
            ->where("user_id", $user->id)
            ->get("extract_user")    
            ->num_rows();

        return $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode(["data"=>$extractInfo, "rows"=>$totalRows]));
    }


    public function campaign() {
        $user = $this->db->select('*')->where("token", $this->input->get_request_header('Authorization'))->get('user')->row();

        $orders = ["value_donation", "date_donation"];

        $order_by = $this->input->post("order_by");

        if(!in_array($order_by, $orders)) $order_by = $orders[1];


        $extractInfo = $this->db
            ->select("
            campaign.title as tituloCampanha,
            campaign_donation.date_donation,
            campaign_donation.value_donation, 
            campaign_donation_cota.id as IdCota,
            campaign_donation_perk.id as IdRecompensa,
            campaign_donation.name as DonatorName")
            ->where("campaign_donation.user_id", $user->id)            
            ->order_by($order_by, 'asc' == $this->input->post("order_type") ? "asc" : "desc")
            ->join('campaign', 'campaign.id = campaign_donation.campaign_id')
            ->join('campaign_donation_cota', 'campaign_donation_cota.campaign_donation_id = campaign_donation.id', 'left')
            ->join('campaign_donation_perk', 'campaign_donation_perk.campaign_donation_id = campaign_donation.id', 'left')
            ->limit(10,10*$this->input->post("page"))
            ->get("campaign_donation")    
            ->result_array();

        $totalRows = $this->db
            ->where("user_id", $user->id)
            ->get("campaign_donation")    
            ->num_rows();

        return $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode(["data"=>$extractInfo, "rows"=>$totalRows]));
    }
    
    
    public function perkDonationInfo() {
        $perk_id = $this->input->post("perk_id");        
        $perkInfo = $this->db->where('id', $perk_id)->get('campaign_donation_perk')->result_array();        
        return $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode(["data"=>$perkInfo]));
    }
    
    public function cotaDonationInfo() {
        $cota_id = $this->input->post("cota_id");        
        $cotaInfo = $this->db->where('id', $cota_id)->get('campaign_donation_cota')->result_array();        
        return $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode(["data"=>$cotaInfo]));
    }
    

}
