<?php

require 'vendor/autoload.php';
require './config.php';

use Firebase\JWT\JWT;

// Get the secret key from the config
$secret_key = require './config.php';
$key = $secret_key['secret_key'];

// Prepare the payload with required claims and data
$payload = array(
    'iss' => 'Your_Issuer_Name', // Replace with your issuer name or domain
    'iat' => time(), // Issued at: current time
    'exp' => strtotime("+2 minutes"), // Expiration time: 2 minutes from now
    'data' => array(
        'firstname' => 'admin',
        'lastname' => 'admin',
        'username' => '123'
    ),
);

// Encode the payload to generate the JWT token
$token = JWT::encode($payload, $key, 'HS256');

// Display the generated JWT token
echo "JWT: " . $token;

?>
