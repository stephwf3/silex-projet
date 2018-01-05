<?php
 
    function register(array $user, $app) { 


    }



    function verifParam($request, $verifRequest = array()): array{

        $error = false;
        $messageError = "";

        foreach($verifRequest as $key => $val) {
            if( !$request->has($val) || trim($request->get($val)) == ""){ // si la $val n'existe pas et qu'elle est vide
                $error = true;
                $messageError .= " $val, ";
            }           
        }
        
        return array("error" => $error, "message" => $messageError);
    }