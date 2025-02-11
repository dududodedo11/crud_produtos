<?php

namespace Client\Middlewares;

class VerifyLogin {
    public static function redirect() {
        if(!isset($_SESSION['user_logged'])) {
            header("Location: {$_ENV['APP_URL']}login?login=required");
        }
    }

    public static function verify() {
        if(isset($_SESSION['user_logged'])) {
            return true;
        } else {
            return false;
        }
    }
}