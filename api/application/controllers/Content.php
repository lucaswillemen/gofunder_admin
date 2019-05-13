<?php
class Content extends CI_Controller
{

	public function getsocial()
	{		
		$campaign_id = $this->input->get("campaign_id");
		$social = $this->db->select("facebook,instagram, youtube")->where('id', $campaign_id)->get("campaign")->result_array();
		$this->output->set_content_type('application/json')->set_output(json_encode($social));
	}
	public function updatesocial()
	{
		$user = $this->user->check($this->input->get_request_header('Authorization'));
		$campaign_id = $this->input->post("campaign_id");
		$social = [
			"facebook" => $this->input->post("facebook"),
			"instagram" => $this->input->post("instagram"),
			"youtube" => $this->input->post("youtube")
		];
		$this->db->where('id', $campaign_id)->update("campaign", $social);
		$this->output->set_content_type('application/json')->set_output(json_encode($social));
	}
	public function getfaq()
	{
		$user = $this->user->check($this->input->get_request_header('Authorization'));
		$campaign_id = $this->input->get("campaign_id");
		$faq = $this->db->where('campaign_id', $campaign_id)->get('campaign_faq')->result();
		$this->output->set_content_type('application/json')->set_output(json_encode($faq));
	}

	public function getgalery()
	{
		$user = $this->user->check($this->input->get_request_header('Authorization'));
		$campaign_id = $this->input->get("campaign_id");
		$images = $this->db->where('campaign_id', $campaign_id)->get('campaign_galery')->result_array();
		$this->output->set_content_type('application/json')->set_output(json_encode($images));
	}

	public function addfaq()
	{
		$user = $this->user->check($this->input->get_request_header('Authorization'));
		$campaign_id = $this->input->post("campaign_id");
		if (!$this->db->where("id", $campaign_id)->where("user_id", $user->id)->get("campaign")->row()) {
			$response = ['error' => 'NOT_YOUR_CAMPAIGN'];
			$this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode($response));
			exit();
		}
		$this->db->insert('campaign_faq', [
			"campaign_id"  => $campaign_id,
			"question"  => $this->input->post("question"),
			"answer" => $this->input->post("answer")
		]);
		$this->output->set_content_type('application/json')->set_output(json_encode(["MSG" => "ADDED"]));
	}

	public function editfaq()
	{
		$user = $this->user->check($this->input->get_request_header('Authorization'));
		$faq = $this->db->where("id", $this->input->post("id"))->get("campaign_faq")->row();

		if (!$faq) {
			$response = ['error' => 'INVALID_FAQ'];
			$this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode($response));
			exit();
		}

		if (!$this->db->where("id", $faq->campaign_id)->where("user_id", $user->id)->get("campaign")->num_rows()) {
			$response = ['error' => 'NOT_YOUR_CAMPAIGN'];
			$this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode($response));
			exit();
		}

		$this->db->where("id", $faq->id)->update('campaign_faq', [
			'answer' => $this->input->post('answer'),
			'question' => $this->input->post('question')
		]);

		$this->output->set_content_type('application/json')->set_output(json_encode(["MSG" => "EDITED"]));
	}

	
	public function deleteperk()
	{
		$user = $this->user->check($this->input->get_request_header('Authorization'));
		$perk = $this->db->where("id", $this->input->post("id"))->get("campaign_perk")->row();

		if (!$perk) {
			$response = ['error' => 'INVALID_PERK'];
			$this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode($response));
			exit();
		}

		if (!$this->db->where("id", $perk->campaign_id)->where("user_id", $user->id)->get("campaign")->num_rows()) {
			$response = ['error' => 'NOT_YOUR_CAMPAIGN'];
			$this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode($response));
			exit();
		}

		$this->db->where("id", $perk->id)->delete('campaign_perk');
		$this->output->set_content_type('application/json')->set_output(json_encode(["MSG" => "REMOVED"]));
	}



	public function deletefaq()
	{
		$user = $this->user->check($this->input->get_request_header('Authorization'));
		$faq = $this->db->where("id", $this->input->post("id"))->get("campaign_faq")->row();

		if (!$faq) {
			$response = ['error' => 'INVALID_FAQ'];
			$this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode($response));
			exit();
		}

		if (!$this->db->where("id", $faq->campaign_id)->where("user_id", $user->id)->get("campaign")->num_rows()) {
			$response = ['error' => 'NOT_YOUR_CAMPAIGN'];
			$this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode($response));
			exit();
		}

		$this->db->where("id", $faq->id)->delete('campaign_faq');
		$this->output->set_content_type('application/json')->set_output(json_encode(["MSG" => "REMOVED"]));
	}



	public function addgalery()
	{
		$user = $this->user->check($this->input->get_request_header('Authorization'));
		if (!$this->db->where("id", $this->input->post("campaign_id"))->where("user_id", $user->id)->get("campaign")->num_rows()) {
			$response = ['error' => 'NOT_YOUR_CAMPAIGN'];
			$this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode($response));
			exit();
		}
		$this->db->insert('campaign_galery', [
			"campaign_id"  => $this->input->post("campaign_id"),
			"picture_url"  => $this->input->post("picture_url"),
			"name" => $this->input->post("legend")
		]);
		$this->output->set_content_type('application/json')->set_output(json_encode(["MSG" => "ADDED"]));
	}

	public function deletegalery()
	{
		$user = $this->user->check($this->input->get_request_header('Authorization'));
		$gallery = $this->db->where("id", $this->input->post("id"))->get("campaign_galery")->row();

		if (!$gallery) {
			$response = ['error' => 'INVALID_GALLERY'];
			$this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode($response));
			exit();
		}

		if (!$this->db->where("id", $gallery->campaign_id)->where("user_id", $user->id)->get("campaign")->num_rows()) {
			$response = ['error' => 'NOT_YOUR_CAMPAIGN'];
			$this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode($response));
			exit();
		}

		$this->db->where("id", $gallery->id)->delete('campaign_galery');
		$this->output->set_content_type('application/json')->set_output(json_encode(["MSG" => "REMOVED"]));
	}


	public function upload_gallery()
	{
		$user = $this->user->check($this->input->get_request_header('Authorization'));
		$uri = str_replace(" ", "-", preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/"), explode(" ", "a A e E i I o O u U n N"), $this->input->post("title"))) . uniqid();
		$this->input->post("title");
		$config['upload_path']          = './uploads/gallery/';
		$config['allowed_types']        = 'jpg|png';
		$config['file_name']            = $uri . "-gallery";
		$this->load->library('upload', $config);
		$this->upload->do_upload('image');
		$result = ["gallery_url" => "api/uploads/gallery/" . $this->upload->data('file_name')];
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}



	public function getperk()
	{
		$user = $this->user->check($this->input->get_request_header('Authorization'));
		$campaign_id = $this->input->get("campaign_id");
		$perk = $this->db->where('campaign_id', $campaign_id)->get('campaign_perk')->result();
		$this->output->set_content_type('application/json')->set_output(json_encode($perk));
	}

	public function editperk()
	{
		$user = $this->user->check($this->input->get_request_header('Authorization'));
		$campaign_id = $this->input->post("campaign_id");
		$perk_id = $this->input->post("id");

		if (!$this->db->where("id", $campaign_id)->where("user_id", $user->id)->get("campaign")->row()) {
			$response = ['error' => 'NOT_YOUR_CAMPAIGN'];
			$this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode($response));
			exit();
		}

		$this->db->where("id", $perk_id)->update('campaign_perk', [
			"name"  => $this->input->post("name"),
			"price" => $this->input->post("price"),
			"stock" => $this->input->post("stock"),			
			"description" => $this->input->post("description"),
			"shipping_worldwide" => $this->input->post("shipping_worldwide"),
			"shipping_date" => $this->input->post("shipping_date"),
			"shipping_price" => $this->input->post("shipping_price"),
			"discount" => $this->input->post("discount")
		]);
		$this->output->set_content_type('application/json')->set_output(json_encode(["MSG" => "EDITED"]));
	}

	public function addperk()
	{
		$user = $this->user->check($this->input->get_request_header('Authorization'));
		$campaign_id = $this->input->post("campaign_id");
		if (!$this->db->where("id", $campaign_id)->where("user_id", $user->id)->get("campaign")->row()) {
			$response = ['error' => 'NOT_YOUR_CAMPAIGN'];
			$this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode($response));
			exit();
		}

		$uri = str_replace(" ", "-", preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/"), explode(" ", "a A e E i I o O u U n N"), $this->input->post("title"))) . uniqid();
		$this->input->post("title");
		$config['upload_path']          = './uploads/perk/';
		$config['allowed_types']        = 'jpg|png';
		$config['file_name']            = $uri . "-perk";
		$this->load->library('upload', $config);
		$this->upload->do_upload('image');


		$this->db->insert('campaign_perk', [
			"campaign_id"  => $campaign_id,
			"name"  => $this->input->post("name"),
			"price" => $this->input->post("price"),
			"stock" => $this->input->post("stock"),			
			"description" => $this->input->post("description"),
			"shipping_worldwide" => $this->input->post("shipping_worldwide"),
			"shipping_date" => $this->input->post("shipping_date"),
			"shipping_price" => $this->input->post("shipping_price"),
			"discount" => $this->input->post("discount"),
			"cover_url" => "api/uploads/perk/" . $this->upload->data('file_name')
		]);
		$this->output->set_content_type('application/json')->set_output(json_encode(["MSG" => "ADDED"]));
	}

}
