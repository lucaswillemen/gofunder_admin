<?php
class Binary extends CI_Model {

    public function dist($id, $amount){
        $receiver = $this->db->where("left_id", $id)->or_where('right_id', $id)->get('users')->row();

        if ($receiver->left_id == $id) {
            $direction = "left_point";
        }else if ($receiver->right_id == $id) {
            $direction = "right_point";
        }

        $this->db->where("id", $receiver->id)->set($direction, $direction."+".$amount, false)->update("users");
        // echo $this->db->last_query()."<br>";

        if ($receiver->id == 0) {
            return true;
        }else{            
            return $this->dist($receiver->id, $amount);
        }
    }   
    public function pay($usd){
        $usd = floatval($usd);
        $total = $this->db->query("SELECT 
            sum(IF (`left_point`>`right_point`, `right_point`, `left_point`)) as points
            FROM `users` WHERE `left_point` != 0 AND `right_point` != 0")->row();
        // $saldo = $this->db->get("binary")->row();
        // echo "<br>Saldo para compartilhar: ".$usd." equivalente a 40% recebido das compras";
        // echo "<br>Para dividir entre: ".$total->points;
        if (!$total->points) {
            return false;
            # code...
        }
        $perpoint = $usd/$total->points;
        // echo "<br>Send assim, cada ponto vale: ".$perpoint;
        
        $query = $this->db->query("SELECT *,
            IF (`left_point`>`right_point`, `right_point`, `left_point`) as points
            FROM `users` WHERE `left_point` != 0 AND `right_point` != 0")->result();
        foreach ($query as $key => $value) {
            // echo "<br>Login ".$value->login." bateu binario e teve ".$value->points." no menor lado e vai receber: ".$value->points*$perpoint." USD, porem o maximo que ele podera receber e ". $value->max_binary;
            // echo "<br>Entao ele vai ficar com  ".$value->login." bateu binario e teve ".$value->points." no menor lado e vai receber: ".$value->points*$perpoint." USD, porem o maximo que ele podera receber e ". $value->max_binary;



            $receiveUSD = $value->points*$perpoint;
            if ($receiveUSD > $value->max_binary) {
                $receiveUSD = $value->max_binary;
            }

            $update = [
                "left_point" => $value->left_point - $value->points,
                "right_point" => $value->right_point - $value->points,
                "usd" => $value->usd + $receiveUSD,
                "max_binary" => $value->max_binary-$receiveUSD
            ];
            $this->db->where("id", $value->id)->update("users", $update);

            $this->user->extratar($value->id, $receiveUSD, "binary");
        }
        // $this->output->set_content_type('application/json')->set_output(json_encode($query));
    }

}

