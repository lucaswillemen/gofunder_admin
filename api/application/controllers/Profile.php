<?php
class Profile extends CI_Controller {

    public function edit()
    {
        $data = $this->input->post(["name","birthday","description","twitter","facebook","address","zipcode","instagram","city","country","website", "linkedin", "youtube"]);
        $user = $this->user->check($this->input->get_request_header('Authorization'));

        
        $config["upload_path"]          = "./uploads/profile/";
        $config["allowed_types"]        = "gif|jpg|png|jpeg";
        $config["encrypt_name"]					= true;
        $this->load->library("upload", $config);
        
        if($this->upload->do_upload("image")) {
            $imageUploaded = $this->upload->data();
            $data["img"] = "uploads/profile/" . $imageUploaded["file_name"];
        }


        $this->db->where("id", $user->id)->update("user", $data);
        $this->output->set_content_type('application/json')->set_output(json_encode((array)$this->user->check($this->input->get_request_header('Authorization'))));
    }
    
    public function getuserbyid() {
      $id = $this->input->get("user_id");
      $user_data = $this->db->
      select("
        name,
        email,
        img,
        description,
        instagram,
        facebook,
        twitter,
        linkedin,
        youtube,
        website")
      ->where('id', $id)->get('user')->row();
      $user_data->donations_done = $this->db->where('user_id', $id)->get('campaign_donation')->num_rows();
      $user_data->donations_received = $this->db->where('other_id', $id)->get('campaign_donation')->num_rows();

      $this->output->set_content_type('application/json')->set_output(json_encode($user_data));

    }

}
