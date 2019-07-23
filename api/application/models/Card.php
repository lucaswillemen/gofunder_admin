<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Card extends CI_Model
{
    public function getCustomerByUserId($user_id)
    {
        $response = $this->db->where("id", $user_id)->get("user")->row_array();
        return $response['customer_id'];
    }
    public function getUserIdByCustomerId($customer_id)
    {
        $response = $this->db->where("customer_id", $customer_id)->get("user")->row_array();
        return $response['id'];
    }
    public function insertCustomerInStripe($email, $token, $user_id)
    {
        $this->load->model('Stripe');
        $customer = $this->Stripe->createCustomer($email, $token);
        return $this->insertCustomerId($customer->id, $user_id);
    }
    public function getCustomerByEmail($email)
    {
        $customer = $this->db->where('email', $email)->get('user')->row();
        return $customer && strlen($customer->customer_id) > 0 ? $customer->customer_id : '';
    }
    private function insertCustomerId($customer_id, $user_id)
    {
        $params["customer_id"] = $customer_id;
        $this->db->where("id", $user_id)->update("user", $params);
        return $this->db->affected_rows();
    }
}
