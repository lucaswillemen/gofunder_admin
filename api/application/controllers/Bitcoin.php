<?php
use Mailgun\Mailgun;
class Bitcoin extends CI_Controller {

	function deposit(){
		$user = $this->user->check($this->input->get_request_header('Authorization'));
		if (!$user->address) {
			$address = $this->core->address();
			$insert = [
			"address" => $address
			];
			$this->db->where("id", $user->id)->update("users", $insert);

		}else{
			$address = $user->address;
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($address));
	}	
	function hook(){

		$data = json_decode(file_get_contents("php://input"));

		if ($this->input->get("secret") != '093c8712cbc180b7a76e451d473952152ecc43f0' || $data->token != "44cb94515c28fec54afa5e8436df8b72667915c9") {
			$this->output->set_content_type('application/json')->set_status_header(403);
			exit();
		}


		if ($data->confirmations == 0) {
			$config = $this->db->get("config")->row();

			$user = $this->db->where("address", $data->address)->get("users")->row();
			if (!$user) {
				exit();
			}
			$insert = [
			"txid" => $data->txid,
			"user_id" => $user->id,
			"unconfirmed" => $data->amount
			];
			$this->db->insert("deposit", $insert);	
			$this->user->extratar($user->id, $data->amount*$config->cota, "deposit");
			// $mg = Mailgun::create('key-4f5c5c70ab45c128df806e89628be784');
			// $mg->messages()->send('wiseminner.com', [
			//   'from'    => 'postmaster@wiseminner.com',
			//   'to'      => 'lucaswillemen@gmail.com, novaeraonlinebtc@gmail.com',
			//   'subject' => $data->amount.' bitcoins deposited!',
			//   'text'    => 'Congratulations, '.$data->amount.' deposited'
			// ]);
			// $mg->messages()->send('wiseminner.com', [
			//   'from'    => 'postmaster@wiseminner.com',
			//   'to'      => $user->email,
			//   'subject' => $data->amount.' bitcoins deposited!',
			//   'text'    => 'Ready, we identified the '.$data->amount.' btc deposit in your account, now just wait to confirm. :D'
			// ]);

		}

		if ($data->confirmations == 1) {
			$user = $this->db->where("address", $data->address)->get("users")->row();
			if (!$user) {
				exit();
			}
			$this->db->where("user_id", $user->id)->where("txid", $data->txid)->set("confirmed", $data->amount)->set("unconfirmed", 0)->update("deposit");

			$config = $this->db->get("config")->row();
			$this->user->extratar($user->id, $data->amount*$config->cota, "deposit");
			$this->db->where("id", $user->id)->set("usd", "usd+".$data->amount*$config->cota, FALSE)->update("users");
			// $this->extratar->inserir($id->user_id, $data->amount, 0, 0, 'deposit');
		}
		print_r($data->token);

	}





}
