<?php

namespace App\Service;


class MessageGenerator 
{
    public function getMessage(string $cleMsg): string
    {
        $message = [
           'loginOk' =>'Bienvenue',
           'csrfNOk' =>'jetom CSRF invalide',
           'troisieme' =>'Troisieme Message',
            ];
        
        return $message[$cleMsg];
    }

}