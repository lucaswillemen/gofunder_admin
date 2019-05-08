<?php
class campaign extends CI_Controller
{

	public function deletegalery()
	{
			$user = $this->user->check($this->input->get_request_header('Authorization'));

			$gallery = $this->db->where("id",$this->input->post("id"))->get("campaign_galery")->row();

			if(!$gallery) {
				$response = ['error'=>'INVALID_GALLERY'];
				$this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode($response));
				exit();
			}

			if(!$this->db->where("id",$gallery->campaign_id)->where("user_id", $user->id)->get("campaign")->num_rows()) {
				$response = ['error'=>'NOT_YOUR_CAMPAIGN'];
				$this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode($response));
				exit();
			}

			$this->db->where("id", $gallery->id)->delete('campaign_galery');
			$this->output->set_content_type('application/json')->set_output(json_encode(["MSG"=>"REMOVED"]));
	}


	public function addgalery()
	{
			$user = $this->user->check($this->input->get_request_header('Authorization'));
			if(!$this->db->where("id", $this->input->post("campaign_id"))->where("user_id", $user->id)->get("campaign")->num_rows()) {
				$response = ['error'=>'NOT_YOUR_CAMPAIGN'];
				$this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode($response));
				exit();
			}
			$this->db->insert('campaign_galery', [
				"campaign_id"  => $this->input->post("campaign_id"),
				"picture_url"  => $this->input->post("picture_url"),
				"name" => $this->input->post("legend")
			]);
			$this->output->set_content_type('application/json')->set_output(json_encode(["MSG"=>"ADDED"]));
	}


	public function getgalery()
	{
			$images = $this->db->where('campaign_id', $this->input->get("campaign_id"))->get('campaign_galery')->result_array();
			$this->output->set_content_type('application/json')->set_output(json_encode($images));
	}

    public function getlist()
    {
        //$user = $this->user->check($this->input->get_request_header('Authorization'));
        $campaigns = $this->db->where('user_id', $this->input->get("user_id"))->get('campaign')->result_array();
        foreach($campaigns as $k => $v) {
            // se possível tirar isso aqui do loop e mandar no join
            $campaigns[$k]["number_of_investor"] = rand(0, 100); // arrumar aqui pra pegar numero de doadores
            $campaigns[$k]["arrecadation"] = rand(0, $v["amount"]); // arrumar aqui pra pegar doação
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($campaigns));
    }

    public function option()
    {
        $result = [
        "country" => $this->db->get("countries")->result(),
        "campaign_type" => $this->db->where("type", "type")->get("campaign_opt")->result(),
        "campaign_develop" => $this->db->where("type", "develop")->get("campaign_opt")->result(),
        "campaign_funds" => $this->db->where("type", "funds")->get("campaign_opt")->result(),
        "campaign_category" => $this->db->get("category")->result(),
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    public function create()
    {
        $user = $this->user->check($this->input->get_request_header('Authorization'));
        $uri = str_replace(" ", "-", preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"), explode(" ", "a A e E i I o O u U n N"), $this->input->post("title")));
        $result = [
        "title" => $this->input->post("title"),
        "country_id" => $this->input->post("country_id"),
        "amount" => $this->input->post("amount"),
        "description" => $this->input->post("description"),
        "allow_funds" => $this->input->post("allow_funds"),
        "allow_presale" => $this->input->post("allow_presale"),
        "allow_speedup" => $this->input->post("allow_speedup"),
        "allow_share" => $this->input->post("allow_share"),
        "allow_other_country" => $this->input->post("allow_other_country"),
        "startAt" => $this->input->post("startAt"),
        "finishAt" => $this->input->post("finishAt"),
        "opt_develop" => $this->input->post("opt_develop"),
        "opt_type" => $this->input->post("opt_type"),
        "opt_category" => $this->input->post("opt_category"),
        "opt_funds" => $this->input->post("opt_funds"),
        "cover_url" => $this->input->post("cover_url"),
        "uri" => $uri,
        "user_id" => $user->id,
        ];
        $this->db->insert("campaign", $result);
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    public function cover()
    {
        $uri = str_replace(" ", "-", preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"), explode(" ", "a A e E i I o O u U n N"), $this->input->post("title")));
        $this->input->post("title");
        $config['upload_path']          = './uploads/';
        $config['allowed_types']        = 'jpg|png';
        $config['file_name']            = $uri."-cover";
        $this->load->library('upload', $config);
        $this->upload->do_upload('image');
        $result = ["cover_url"=> "api/uploads/".$this->upload->data('file_name')];
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }


		public function upload_gallery()
		{
				$uri = str_replace(" ", "-", preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"), explode(" ", "a A e E i I o O u U n N"), $this->input->post("title"))) . uniqid();
				$this->input->post("title");
				$config['upload_path']          = './uploads/';
				$config['allowed_types']        = 'jpg|png';
				$config['file_name']            = $uri."-gallery";
				$this->load->library('upload', $config);
				$this->upload->do_upload('image');
				$result = ["gallery_url"=> "api/uploads/gallery/".$this->upload->data('file_name')];
				$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}

}
