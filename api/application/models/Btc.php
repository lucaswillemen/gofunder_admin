<?php

defined("BASEPATH") or exit("No direct script access allowed");


class Btc extends CI_Model
{
    public function createInvoice($params)
    {
        $params["version"] = "1";
        $params["cmd"] = "create_transaction";
        $params["key"] = "bdebf47bd4be7ec62ae19726e5b46f8e5cd855ae374f54d2cfd03e2c26160667";
        $params["format"] = "json";
        $encoded = http_build_query($params, '', '&');
        $hmac = hash_hmac('sha512', $encoded, 'aC20723C3e66abE4daa3d65524914838CC58e111Bf86cDb33E8a0FC7a9808FB7');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.coinpayments.net/api.php");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('HMAC: '.$hmac));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded);
        $response = curl_exec($ch);
        $retorno = json_decode($response, true);
        curl_close($ch);
        return $retorno;
    }
}
