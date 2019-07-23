<?php
class Crons extends CI_Controller {

    public function finalize_campaigns() {
        //finalizar todas campanhas se a data ja tiver passado
        //finalizar todas campanhas != flexivel se o amount_received for maior ou igual ao amount
        $campaigns = $this->db->get("campaign")->result_array();
        foreach ($campaigns as $campaign) {
            if(strtotime($campaign["finishAt"])-time() < 0) 
                $this->db->set("status", "finalized")->where("id", $campaign["id"])->update("campaign");
            if($campaign["flexible"] != "flexible" && ($campaign["amount"] <= $campaign["amount_received"]))
                $this->db->set("status", "finalized")->where("id", $campaign["id"])->update("campaign");
        }
    }
}