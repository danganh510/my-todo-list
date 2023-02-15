<?php
$publicController = [
    'login' => 'login'
];

if (!isset($publicController[$controller_name]) || (!key_exists($controller_name,$publicController) && $action_name != $publicController[$controller_name])) {
    if (!Session::get("auth")) {
        header("Location: /login");
        die();
    }
   
}