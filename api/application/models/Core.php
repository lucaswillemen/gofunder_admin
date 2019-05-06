<?php
class Core extends CI_Model {
    
    function address(){
        $ch = curl_init();  
        $options = array(
            CURLOPT_URL            => 'https://eltouro.com/api/btc/splyko/getnewaddress',
            CURLOPT_HTTPHEADER     => ['Authorization: 44cb94515c28fec54afa5e8436df8b72667915c9'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => false,
            CURLOPT_SSL_VERIFYPEER => 0
        ); 
        curl_setopt_array($ch, $options);
        $content = curl_exec($ch); 
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return json_decode($content);
    }
}