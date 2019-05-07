<?php
class Campaing extends CI_Controller {
	
	public function option(){
		// $user = $this->user->check($this->input->get_request_header('Authorization'));


		$result = [
			"country" => $this->db->get("countries")->result(),
			"campaing_type" => $this->db->where("type", "type")->get("campaing_opt")->result(),
			"campaing_develop" => $this->db->where("type", "develop")->get("campaing_opt")->result(),
			"campaing_funds" => $this->db->where("type", "funds")->get("campaing_opt")->result(),
			"campaing_category" => $this->db->get("category")->result(),
		];
		// var_dump($result);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function create(){
		$user = $this->user->check($this->input->get_request_header('Authorization'));

	    $uri = str_replace(" ", "-", preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$this->input->post("title")));

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
	public function cover(){
		// $user = $this->user->check($this->input->get_request_header('Authorization'));

	    $uri = str_replace(" ", "-", preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$this->input->post("title")));

		$this->input->post("title");
		$config['upload_path']          = './uploads/';
        $config['allowed_types']        = 'jpg|png';
        $config['file_name']            = $uri."-cover";

        $this->load->library('upload', $config);
        $this->upload->do_upload('image');
        $result = ["cover_url"=> "api/uploads/".$this->upload->data('file_name')];
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

}
