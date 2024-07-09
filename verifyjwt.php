<?php
require 'vendor/autoload.php';
require './config.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

session_start();

// Get the secret key from the config
$secret_key = require './config.php';
$key = $secret_key['secret_key'];

// Check if JWT token is set in the session or request header
if (!isset($_SESSION['jwt'])) {
    header('Location: login.php');
    exit; // Exit here to prevent further execution if not authenticated
} else {
    $jwt = $_SESSION['jwt'];

    try {
        // Decode and verify the JWT token
        $decoded = JWT::decode($jwt, new Key($key, 'HS256'));

    } catch (Exception $e) {
        // Invalid token
        echo 'Error: Expired token';
        header('Location: login.php'); // Redirect to login page on token error
        exit;
    }
}
?>
