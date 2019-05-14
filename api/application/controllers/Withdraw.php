<?php
class Withdraw extends CI_Controller {

	public function withdraw(){
		$user = $this->user->check($this->input->get_request_header('Authorization'));
        $inputUser = $this->input->post(['amount','bank','agency','account','name'.'cpf','op']);
        $fee =  0.01;  // 1% de taxa

		if ( $user->usd < ($inputUser['amount'] * ($inputUser['amount']+$fee))) {
			return $this->output->set_content_type('application/json')->set_status_header(404)->set_output(json_encode(['error'=>'INSUFICIENT_FUNDS']));
        }        

        $this->db->where("id", $user->id)->update("user",["usd"=>$user->usd-$inputUser['amount']+$fee]);
        $this->db->insert("user_withdrawal",[
            "user_id" => $user->id,
            "amount" => $inputUser["amount"],
            "bank_info" => json_encode($inputUser)
        ]);
        $this->output->set_content_type('application/json')->set_output(json_encode(true));
	}

}
