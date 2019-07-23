<?php

class Donation extends CI_Controller {

    public function makeBtcDonation() {
        $user = $this->db->select('*')->where("token", $this->input->get_request_header('Authorization'))->get('user')->row();
        $inputPost = $this->input->post(["perk_id","cota_id","campaign_id","perk_shipping_address","perk_shipping_country", "usd", "name", "email"]);
        $campaign = $this->db->where("id", $inputPost["campaign_id"])->get("campaign")->row();  
        $this->validate($campaign, $inputPost, $user);
        ($inputPost["cota_id"])  && $this->validateCota($campaign->id, $inputPost["cota_id"], $inputPost["usd"]);
        ($inputPost["perk_id"]) && $this->validatePerk($campaign->id, $inputPost["perk_id"], $inputPost["usd"], $inputPost["perk_shipping_country"]) ;
        $totalInvoiceValue = $inputPost["usd"] ;
        if($inputPost["perk_id"]) {
            $totalInvoiceValue += $this->db->where("id", $inputPost["perk_id"])->get("campaign_perk")->row()->shipping_price;
        }
        $this->load->model('Btc');            
        $invoiceCode = uniqid();
        $paymentInfo = $this->Btc->createInvoice([
            "currency1" =>  "USD",
            "currency2" => "BTC",
            "amount" => $totalInvoiceValue,
            "buyer_name" => $inputPost["name"],
            "buyer_email" => $inputPost["email"],
            "invoice" => rand(0,999999),
            "custom" => $invoiceCode
        ]);
        if($paymentInfo["error"] !== "ok") {
            return $this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode("INVALID_API"));
        }
        $paymentInfo["server_code"] = $invoiceCode;
        $btcPaymentInfoCache = $inputPost; 
        $btcPaymentInfoCache["payment_type"] = "bitcoin";
        $btcPaymentInfoCache["user_id"] = $user ? $user->id : null; 
        $btcPaymentInfoCache["campaign_id"] = $campaign->id; 
        $btcPaymentInfoCache["btc"] = $paymentInfo["result"]["amount"]; 
        file_put_contents("tempdonationbtc/". $invoiceCode .".log", json_encode($btcPaymentInfoCache));
        return $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode($paymentInfo));
    }

    public function makeCardDonation() {
        $user = $this->db->select('*')->where("token", $this->input->get_request_header('Authorization'))->get('user')->row();
        $inputPost = $this->input->post(["perk_id","cota_id", "campaign_id","perk_shipping_address","perk_shipping_country", "card_token","usd",  "name", "email"]);
        $campaign = $this->db->where("id", $inputPost["campaign_id"])->get("campaign")->row();  
        $this->validate($campaign, $inputPost, $user);
        ($inputPost["cota_id"])  && $this->validateCota($campaign->id, $inputPost["cota_id"], $inputPost["usd"]);
        ($inputPost["perk_id"]) && $this->validatePerk($campaign->id, $inputPost["perk_id"], $inputPost["usd"], $inputPost["perk_shipping_country"]) ;
        $totalInvoiceValue = $inputPost["usd"] ;
        if($inputPost["perk_id"]) {
            $totalInvoiceValue += $this->db->where("id", $inputPost["perk_id"])->get("campaign_perk")->row()->shipping_price;
        }
        try {
            $this->load->model('Stripe');
            $this->Stripe->createChargeAnonymous($totalInvoiceValue * 100, $inputPost["card_token"], $currency = 'USD');
            $this->secureLogs("card");
            $donation_id = $this->addDonation($campaign->id, $user ? $user->id : null, "dollar", $inputPost["usd"], 0, $inputPost["name"], $inputPost["email"]);
            ($inputPost["cota_id"]) &&  $this->addBuyCota($campaign->id, $user->id, $inputPost["cota_id"], $donation_id);
            ($inputPost["perk_id"])  && $this->addBuyPerk($campaign->id, $user->id, $inputPost["perk_id"], $donation_id, $inputPost["perk_shipping_address"]);
            return $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode("SUCESS_DONATE"));
        } catch (Exception $e) {
            return $this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode($e->getMessage()));
        }
    }

    public function checkState()
    {
        return file_exists("tempdonationbtc/". $this->input->post("invoice") .".log") ?
            $this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode("NOT_PAYED_YEAT"))
            : $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode("SUCESS"));
    }

    public function webHookBTC()
    {
        $hmac = hash_hmac("sha512", file_get_contents('php://input'), "3623472172"); 
        if (!hash_equals($hmac, $_SERVER['HTTP_HMAC'])) { 
            $this->secureLogs("webhook");
            return $this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode("INVALID_HASH_TOKEN"));
        }   
        if(!($this->input->post("status") >= 100)) {
            return $this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode("INVALID_INVOICE"));
        }        
        $fileName = "tempdonationbtc/". $this->input->post("custom") .".log";
        if(!file_exists($fileName)) {
            return $this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode("INVALID_INVOICE_CACHE"));
        }    
        $inputData = json_decode(file_get_contents($fileName));
        $donation_id = $this->addDonation($inputPost["campaign_id"],$inputPost["user_id"],$inputPost["payment_type"],$inputPost["usd"],$inputPost["btc"],$inputPost["name"],$inputPost["email"]);
        ($inputPost["cota_id"]) &&  $this->addBuyCota($inputPost["campaign_id"], $inputPost["user_id"], $inputPost["cota_id"], $donation_id);
        ($inputPost["perk_id"])  && $this->addBuyPerk($inputPost["campaign_id"], $inputPost["user_id"], $inputPost["perk_id"], $donation_id, $inputPost["perk_shipping_address"]);
        unlink($fileName);
        return $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode("SUCESS_DONATE"));
    }


    public function countries() {    
        $this->output->set_content_type('application/json')->set_output(json_encode($this->db->get("countries")->result_array())); 
    }

    public function info() {
        $campaign_id = $this->input->post("campaign_id");
        $perk_id = $this->input->post("perk_id");
        $cota_id = $this->input->post("cota_id");

        $campaign = $this->db->where("id", $campaign_id)->get("campaign")->row_array();
        if(!$campaign) {
            return $this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode("INVALID_CAMPAIGN"));
        }
        if($campaign["status"] !== "approved") {
            return $this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode("INVALID_STATUS"));
        }
        $owner = $this->db->where("id", $campaign["user_id"])->get("user")->row();
        $campaign["content"] = $this->db->where("campaign_id",$campaign_id)->get("campaign_content")->result_array();        
        $campaign["perk"] = $this->db->where("campaign_id",$campaign_id)->where("id",$perk_id)->get("campaign_perk")->row();
        $campaign["cota"] = $this->db->where("campaign_id",$campaign_id)->where("id",$cota_id)->get("campaign_cota")->row();
        $campaign["owner_name"] = $owner->name;
        $campaign["owner_city"] = $owner->city;
        $campaign["owner_country"] = $owner->country;
        $campaign["owner_image"] = $owner->img;
        $campaign["owner_campaigns"] = $this->db->where("user_id", $owner->id)->get("campaign")->num_rows();
        $campaign["donators"] = 1337;
        $campaign["remain_days"] = strtotime($campaign["finishAt"])-time();
        $campaign["remain_days"] = $campaign["remain_days"]  > 0 ? round($campaign["remain_days"]/86400) : 0;
        $campaign["country_info"] = $this->db->where("id", $campaign["country_id"])->get("countries")->row_array();
        $campaign["category_info"] = $this->db->where("id", $campaign["category"])->get("category")->row_array();
        return $this->output->set_content_type('application/json')->set_output(json_encode($campaign));

    }


    public function createCardToken()
    {
        $this->load->model('Stripe');

        $name = $this->input->post("name");
        $number = $this->input->post("number");
        $exp_month = $this->input->post("exp_month");
        $exp_year = $this->input->post("exp_year");
        $cvc = $this->input->post("cvc");

        try {
            $source = $this->Stripe->createToken($name, $number, $exp_month, $exp_year, $cvc);
            return $this->output->set_content_type('application/json')->set_output(json_encode($source));
        } catch (Exception $e) {
            return $this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode($e->getMessage()));
        }

    }


    private function validate($campaign, $inputPost, $user) {
        if(!$campaign || $campaign->status !== "approved") {
            $this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode("INVALID_CAMPAIGN"));
            die();
        }
        if($inputPost["perk_id"] && $inputPost["cota_id"]) {
            return $this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode("PERK_OR_COTA"));
            die();
        }
        if(($inputPost["perk_id"] || $inputPost["cota_id"]) && !$user) {
            return $this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode("NEED_LOGGED"));
            die();
        }

    }

    private function validatePerk($campaign_id, $perk_id, $usd, $perk_country) {
        $perk = $this->db->where("campaign_id", $campaign_id)->where("id", $perk_id)->get("campaign_perk")->row();
        if(!$perk) {
            $this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode("INVALID_PERK"));
            die();
        }
        if($perk->price > $usd) {
            $this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode("INVALID_MIN_DONATION"));
            die();
        }
        if($perk->stock_remain == 0) {
            $this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode("INVALID_PERK_STOCK"));
            die();
        } 
        if($perk->shipping_price > 0 && $perk->shipping_worldwide != 'world_wide' && $campaign->country_id !== $perk_country) {
            $this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode("INVALID_COUNTRY_SHIPPING"));
            die();
        }
    }
    private function validateCota($campaign_id, $cota_id, $usd) {
        $cota = $this->db->where("campaign_id", $campaign_id)->where("id", $cota_id)->get("campaign_cota")->row();
        if(!$cota) {                
            $this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode("INVALID_COTA"));
            die();
        }
        if($cota->min_donation > $usd) {
            $this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode("INVALID_MIN_DONATION"));
            die();
        }
        if($cota->stock_remain == 0) {
            $this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode("INVALID_COTA_STOCK"));
            die();
        } 
        return true;
    }

    private function addDonation($campaign_id, $user_id, $payment_type, $usd_donate, $btc_donate, $name, $email) {
        $campaign = $this->db->where("id", $campaign_id)->get("campaign")->row();        
        if($usd_donate + $campaign->amount > $campaign->amount_received && $campaign->flexible == 'static') {                 
            $this->db->where("id", $campaign->id)->update("campaign", [
                "status" => 'finalized'
            ]);
        }
        // aumentar o ammount recebido
        $this->db->where("id", $campaign->id)->update("campaign", [
            "amount_received" => $campaign->amount_received +  $usd_donate
        ]);
        $this->db->where('id', $campaign->user_id);
        ($payment_type == 'bitcoin') && $this->db->set('btc', 'btc+'.$btc_donate, FALSE);
        ($payment_type !== 'bitcoin') &&  $this->db->set('usd', 'usd+'.$usd_donate, FALSE);
        $this->db->update('user');
        $this->db->insert("campaign_donation", [
            "campaign_id" => $campaign->id,
            "user_id" => $user_id,
            "other_id" => $campaign->user_id,
            "name" => $name,
            "email" => $email,
            "payment_method" => $payment_type,
            "value_donation" => $usd_donate
        ]);
        return $this->db->insert_id();
    }





    private function addBuyCota($campaign_id, $user_id, $cota_id, $donation_id) {
        $campaign = $this->db->where("id", $campaign_id)->get("campaign")->row();      
        $cota = $this->db->where("campaign_id", $campaign_id)->where("id", $cota_id)->get("campaign_cota")->row();
        $this->db->insert("campaign_donation_cota", [
            "campaign_id" => $campaign_id,
            "campaign_donation_id" => $donation_id,
            "campaign_cota_id" => $cota_id,
            "expiry" => $cota->expiry,
            "peoples" => $cota->stock,
            "percent" => $cota->percent,
            "user_id" => $user_id,
            "other_id" => $campaign->user_id
        ]);
        $this->db->where('id', $cota_id);
        $this->db->set('stock_remain', 'stock_remain-1', FALSE);
        $this->db->update('campaign_cota');
    }




    private function addBuyPerk($campaign_id, $user_id, $perk_id, $donation_id, $perk_address_shipping) {
        $campaign = $this->db->where("id", $campaign_id)->get("campaign")->row();

        $perk = $this->db->where("campaign_id", $campaign_id)->where("id", $perk_id)->get("campaign_perk")->row();
        $this->db->insert("campaign_donation_perk", [
            "campaign_id" => $campaign_id,
            "campaign_donation_id" => $donation_id,
            "campaign_perk_id" => $perk_id,
            "user_id" => $user_id,
            "other_id" => $campaign->user_id,
            "shipping_price" => $perk->shipping_price,
            "shipping_address" => json_encode($perk_address_shipping),
        ]);
        $this->db->where('id', $perk_id);
        $this->db->set('stock_remain', 'stock_remain-1', FALSE);
        $this->db->update('campaign_perk');
    }

    
    private function secureLogs($tipo) {
        file_put_contents("securelogs/".  time() . "-". uniqid() .".log", json_encode(["tipo"=>$tipo,"info"=>$_SERVER, "post"=>$_POST,"get"=>$_GET]), FILE_APPEND);
    }

}
