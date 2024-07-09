<?php


require 'vendor/autoload.php';
require './config.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$key = $secret_key['secret_key'];

$headers = apache_request_headers();
// print_r($headers['Authorization']);

if (isset($headers['Authorization'])){
    $header = $headers['Authorization'];
    $headerString = explode(' ', $header);
    $token = $headerString[1];
    // print_r($token);

    try {
        $decoded = JWT::decode($token, new Key($key, 'HS256'));
        print_r($decoded);
    } catch (Exception $e) {
        echo 'Error: Expired token';
    }
} else {
    echo 'No authorization found';
}

?>