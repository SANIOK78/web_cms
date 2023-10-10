<?php
    // Funtion qui va generer une "string" aleatoir
    function tokenAleaString($len = 20){

        $token ='';

        // String contenant [a-z A-Z 0-9] 
        $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        // On va génerer un "string" aleatoir a partir de ca
        for($i = 0; $i < $len; $i++){

            $token = $token.$str[rand(0, strlen($str)-1)];
        }

        return $token;  
    }

    $token = tokenAleaString(20);


?>