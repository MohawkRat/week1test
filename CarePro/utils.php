<?php

class utils {
    
    public static function generateSessionId(int $length = 21) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
        $sessionId = "";
        
        for ($i = 0; $i < $length; $i++) {
            $sessionId .= $chars[rand(0, strlen($chars) - 1)];
        }

        return $sessionId;
    }

}