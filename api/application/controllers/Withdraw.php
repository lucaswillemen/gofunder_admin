<?php
class Withdraw extends CI_Controller {

    public function insertwithdraw(){
        $user = $this->user->check($this->input->get_request_header('Authorization'));
        $amount = $this->input->post("amount");
        $withdraw_data = $this->input->post("withdrawJson");
        $fee =  0.01;  // 1% de taxa
        $real_amount = $amount + ($amount*$fee);
        if ( $user->usd < $real_amount) {
            return $this->output->set_content_type('application/json')->set_status_header(404)->set_output(json_encode(['error'=>'INSUFICIENT_FUNDS']));
        }        

        $this->db->where("id", $user->id)->update("user",["usd"=>$user->usd-$real_amount]);
        $this->db->insert("user_withdrawal",[
            "user_id" => $user->id,
            "amount" => $amount,
            "type" => "withdraw",
            "bank_info" => $withdraw_data
        ]);
        $this->db->insert("extract_user",[
            "user_id" => $user->id,
            "amount" => $real_amount,
            "type" => "withdraw",
            "coin" => "usd"         
        ]);   

        $this->output->set_content_type('application/json')->set_output(json_encode(["user_amount" => $user->usd-$real_amount]));
    }

    public function withdrawBtc(){
        $user = $this->user->check($this->input->get_request_header('Authorization'));
        $amount = $this->input->post("amount");
        $address = $this->input->post("address");
        $fee =  0.01;  // 1% de taxa
        $real_amount = $amount + ($amount*$fee);
        if ( $user->btc < $real_amount) {
            return $this->output->set_content_type('application/json')->set_status_header(404)->set_output(json_encode(['error'=>'INSUFICIENT_FUNDS']));
        }        

        $this->db->where("id", $user->id)->update("user",["btc"=>$user->btc-$real_amount]);
        $this->db->insert("user_withdrawal_btc",[
            "user_id" => $user->id,
            "amount" => $amount,
            "address" => $address
        ]);
        $this->db->insert("extract_user",[
            "user_id" => $user->id,
            "amount" => $real_amount,
            "coin" => "btc"           
        ]);   

        $this->output->set_content_type('application/json')->set_output(json_encode(["user_amount_btc" => $user->btc-$real_amount]));
    }

}
