<?php
class Cota extends CI_Controller {

	public function index(){
		$bitstamp = file_get_contents("https://www.bitstamp.net/api/ticker/");
		$bitstamp = json_decode($bitstamp);

		$this->db->set('cota', $bitstamp->last)->update('config');
	}


}
