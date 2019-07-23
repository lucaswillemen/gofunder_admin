<?php
class Campaign extends CI_Controller
{


    public function search()
    {
        $search_text = $this->input->post("search");
        //         $page_limit = $this->input->post("limit_page"); //1 2 3 4 5
        $category_id = $this->input->post("category_id"); //0 1 2 3 4 5
        //         $asc_order = $this->input->post("asc_order"); //true false
        $project_type = $this->input->post("type_project"); //marketplace funding all
        $categories = $this->db->get("category")->result_array();
        $categories = array_combine(array_column($categories, "id"), array_column($categories, "name"));
        if($project_type == "all" && $category_id == 0)
            $data = $this->db->where('status','approved')->like('title', $search_text)->order_by('rand()')->limit(5)->get("campaign")->result_array();
        else if($category_id != 0 && $project_type == "all") 
            $data = $this->db->where('status','approved')->where("category", $category_id)->like('title', $search_text)->order_by('rand()')->limit(5)->get("campaign")->result_array();
        else if($category_id == 0 && $project_type != "all")
            $data = $this->db->where('status','approved')->where("tipo", $project_type)->like('title', $search_text)->order_by('rand()')->limit(5)->get("campaign")->result_array();
        else 
            $data = $this->db->where('status','approved')->where("tipo", $project_type)->where("category", $category_id)->like('title', $search_text)->order_by('rand()')->limit(5)->get("campaign")->result_array();

        foreach ($data as $k => $v) {
            $data[$k]["category_name"] = $categories[$v["category"]];
            $data[$k]["lancamento"] = 'Lançamento em Breve';
            $data[$k]["remain_days"] = round((strtotime($v["finishAt"]) - time())/ 86400);
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    public function campaigninfo() {
        $campaign_id = $this->input->post("campaign_id");
        $campaign = $this->db->where("id", $campaign_id)->get("campaign")->row_array();
        if(!$campaign) {
            return $this->output->set_content_type('application/json')->set_status_header(401)->set_output(json_encode(["MSG"=>"INVALID_CAMPAIGN"]));
        }
        if($campaign["status"] !== "approved") {
            $user = $this->db->select('*')->where("token", $this->input->get_request_header('Authorization'))->get('user')->row();
            if(!$user || $user->id !== $campaign["user_id"]) {
                return $this->output->set_content_type('application/json')->set_status_header(401)->set_output(json_encode(["MSG"=>"INVALID_CAMPAIGN_USER"]));
            }
        }

        $campaign["gallery"] = $this->db->where("campaign_id", $campaign_id)->get("campaign_galery")->result_array();
        $campaign["faq"] = $this->db->where("campaign_id",$campaign_id)->get("campaign_faq")->result_array();
        $campaign["content"] = $this->db->where("campaign_id",$campaign_id)->get("campaign_content")->result_array();
        $campaign["comment"] = $this->db->where("campaign_id",$campaign_id)->get("campaign_coment")->result_array();
        $campaign["perk"] = $this->db->where("campaign_id",$campaign_id)->get("campaign_perk")->result_array();
        $campaign["cota"] = $this->db->where("campaign_id",$campaign_id)->get("campaign_cota")->result_array();

        $owner = $this->db->where("id", $campaign["user_id"])->get("user")->row();

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

    public function getlistcampaignid()
    {       
        $campaigns = $this->db->select("
        campaign.*,
        campaign.category as category_id,
        category.name as category_name,
        category.icon_name as category_icon")
            ->from('campaign')->where('user_id', $this->input->get("user_id"))->join("category", "campaign.category = category.id")->get()->result_array();
        foreach ($campaigns as $k => $v) {
            $campaigns[$k]["number_of_investor"] = rand(0, 100); 
            $campaigns[$k]["arrecadation"] = rand(0, $v["amount"]);
            $campaigns[$k]["remain_days"] = round((strtotime($v["finishAt"]) - time())/ 86400);
            $campaigns[$k]["tipo"] = "Funding";
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($campaigns));
    }

    public function getlist()
    {
        $user = $this->user->check($this->input->get_request_header('Authorization'));
        $campaigns = $this->db->where('user_id', $user->id)->get('campaign')->result_array();
        foreach ($campaigns as $k => $v) {
            $campaigns[$k]["number_of_investor"] = rand(0, 100); // arrumar aqui pra pegar numero de doadores
            $campaigns[$k]["arrecadation"] = rand(0, $v["amount"]); // arrumar aqui pra pegar doação
            $campaigns[$k]["remain_days"] = round((strtotime($v["finishAt"]) - time())/ 86400);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($campaigns));
    }

    public function option()
    {
        $result = [
            "country" => $this->db->get("countries")->result(),
            "category" => $this->db->get("category")->result(),
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    public function create()
    {
        $user = $this->user->check($this->input->get_request_header('Authorization'));
        $uri = str_replace(" ", "-", preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/"), explode(" ", "a A e E i I o O u U n N"), $this->input->post("title")));

        $config['upload_path']          = './uploads/';
        $config['allowed_types']        = 'jpg|png|jpeg|bmp';
        $config['file_name']            = $uri . "-cover.jpeg";

        $this->load->library('upload', $config);

        if(!$this->upload->do_upload('image_upload')) {
            return $this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode(["MSG"=>"INVALID_COVER","ERROR"=>$this->upload->display_errors()]));
        }

        $this->db->insert("campaign", [
            "title" => $this->input->post("title"),
            "country_id" => $this->input->post("country"),
            "category" => $this->input->post("category"),
            "amount" => $this->input->post("amount"),
            "description" => $this->input->post("description"),
            "startAt" => $this->input->post("startAt"),
            "finishAt" => $this->input->post("finishAt"), 
            "cover_url" => "uploads/".$this->upload->data('file_name'),
            "payment_method"=> $this->input->post("payment_method"),
            "product_stage"=> $this->input->post("product_stage"),
            "flexible"=> $this->input->post("flexible"), 
            "uri" => $uri,
            "user_id" => $user->id,
        ]);

        $this->output->set_content_type('application/json')->set_output(json_encode(["id"=>$this->db->insert_id(), "title"=>$this->input->post("title")]));
    }



    public function cover_campaigns() {
        $campaign = $this->db
            ->select('id, title, description, uri, cover_url as image_overlay, amount as cash, amount_received as cash_received')            
            ->where('status','approved')
            ->limit(5)
            ->get('campaign')
            ->result_array();

        return $this->output->set_content_type('application/json')->set_output(json_encode($campaign)); 
    }
    
    public function getCampaignCountry() {
     $user = $this->user->check($this->input->get_request_header('Authorization'));
      $campaign_id = $this->input->get("campaign_id");
      $campaign = $this->db->select("countries.*")->from("campaign")->where("campaign.id", $campaign_id)->join("countries", "countries.id = campaign.country_id")->get()->row_array();
//       if(!$campaign) 
//           return $this->output->set_content_type('application/json')->set_status_header(401)->set_output(json_encode(["MSG"=>"CAMPAIGN_NOT_FOUND"]));
      return $this->output->set_content_type('application/json')->set_output(json_encode($campaign));
    }

    public function getoverview()
    {
        $user = $this->user->check($this->input->get_request_header('Authorization'));
        $campaign = $this->db->where("id", $this->input->get("campaign_id"))->where("user_id", $user->id)->get("campaign")->row_array();
        if (!$campaign) {
            return $this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode(['error' => 'NOT_YOUR_CAMPAIGN']));
        }
        $campaign_content = $this->db
            ->select('youtube_page,facebook_page,instagram_page,linkedin_page,html')
            ->where("campaign_id", $this->input->get("campaign_id"))
            ->get("campaign_content")
            ->row_array();

        if($campaign_content) {
            $campaign = array_merge($campaign, $campaign_content);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($campaign));
    }


    public function saveoverview()
    {
        $user = $this->user->check($this->input->get_request_header('Authorization'));
        $campaign = $this->db->where("id", $this->input->get("campaign_id"))->where("user_id", $user->id)->get("campaign")->row();
        if (!$campaign) {
            return $this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode(['error' => 'NOT_YOUR_CAMPAIGN']));
        }
        $this->db->where("id", $this->input->get("campaign_id"))->update("campaign", $this->input->post(["title", "description"]));

        $dataContent = $this->input->post(["html","instagram_page","facebook_page","youtube_page", "linkedin_page"]);
        var_dump($dataContent);
        if(!$this->db->where("campaign_id", $this->input->get("campaign_id"))->get("campaign_content")->num_rows()) {
            $this->db->insert("campaign_content",array_merge($dataContent,["campaign_id"=>$this->input->get("campaign_id")]));
        }
        else {
            $this->db->where("campaign_id", $this->input->get("campaign_id"))->update("campaign_content",$dataContent);
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($campaign));
    }
}
