<?php
defined("BASEPATH") or exit("No direct script access allowed");

require_once('vendor/autoload.php');
\Stripe\Stripe::setApiKey("sk_test_H3VhMsD2IBpBo3BRLswdeqXc");

class Stripe extends CI_Model
{
    public function createToken($name, $number, $exp_month, $exp_year, $cvc)
    {
        $token = \Stripe\Token::create(array(
            "card" => array(
                "name" => strtoupper($name),
                "number" => $number,
                "exp_month" => $exp_month,
                "exp_year" => $exp_year,
                "cvc" => $cvc
            )
        ));
        return $token;
    }
    public function createChargeAnonymous($amountCents, $cardToken, $currency = 'USD')
    {
        $charge = \Stripe\Charge::create([
            'amount' => $amountCents,
            'currency' => $currency,
            'source' => $cardToken
        ]);
        return $charge;
    }
    public function createCharge($amountCents, $customerId, $currency = 'USD')
    {
        $charge = \Stripe\Charge::create([
            'amount' => $amountCents,
            'currency' => $currency,
            'customer' => $customerId
        ]);
        return $charge;
    }
    public function createCustomer($email, $source)
    {
        $customer = \Stripe\Customer::create([
            'email' => $email,
            'source' => $source,
        ]);
        return $customer;
    }
    public function retrieveAllCards($customer_id)
    {
        $cards = \Stripe\Customer::retrieve($customer_id)->sources->all(array('limit'=>10, 'object' => 'card'));
        return $cards;
    }
    public function getCard($customer_id, $card_id)
    {
        $customer = \Stripe\Customer::retrieve($customer_id);
        $card = $customer->sources->retrieve($card_id);
        return $card;
    }
    public function createCard($customer_id, $source)
    {
        $customer = \Stripe\Customer::retrieve($customer_id);
        $customer->sources->create(array("source" => $source));
        return $customer;
    }
    public function deleteCard($customer_id, $card_id)
    {
        $customer = \Stripe\Customer::retrieve($customer_id);
        $customer->sources->retrieve($card_id)->delete();
        return $customer;
    }
    public function getDefaultCard($customer_id)
    {
        $customer = \Stripe\Customer::retrieve($customer_id);
        return $customer->default_source;
    }
    public function setDefaultCard($customer_id, $card_id)
    {
        $customer = \Stripe\Customer::retrieve($customer_id);
        $customer->default_source = $card_id;
        $customer->save();
        return $customer->default_source;
    }
    public function deleteCustomer($customer_id)
    {
        $cu = \Stripe\Customer::retrieve($customer_id);
        $cu->delete();
        return $cu;
    }
}
