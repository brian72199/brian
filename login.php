<?php
session_start();
require 'vendor/autoload.php';
require './config.php';
require './database_helper/db_helper.php'; // Adjust the path as per your file structure

use Firebase\JWT\JWT;

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Query to fetch user data by username
    $query = "SELECT * FROM elective.users WHERE username = $1";
    $stmt = pg_prepare($connection, "login_query", $query);
    
    if (!$stmt) {
        $error = "Failed to prepare statement: " . pg_last_error();
    } else {
        $result = pg_execute($connection, "login_query", array($username));
        
        if (!$result) {
            $error = "Error executing query: " . pg_last_error();
        } else {
            $user = pg_fetch_assoc($result);
            
            // Simple password check (without hashing)
            if ($user && $password === $user['password']) {
                // Generate JWT token
                $secret_key = require './config.php';
                $key = $secret_key['secret_key'];

                $payload = array(
                    'iss' => 'cineeeeeee', // Replace with your issuer name or domain
                    'iat' => time(), // Issued at: current time
                    'exp' => strtotime("+2 minutes"), // Expiration time: 2 hours from now
                    'data' => array(
                        'firstname' => $user['firstname'],
                        'lastname' => $user['lastname'],
                        'username' => $user['username']
                    ),
                );

                $token = JWT::encode($payload, $key, 'HS256');

                // Store the token in the session
                $_SESSION['jwt'] = $token;
                $_SESSION['username'] = $username;

                // Redirect to the header page
                header('Location: staff_index.php');
                exit;
            } else {
                $error = "Invalid username or password.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/reg.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
        <img src="pictures/paglaum.jpg" alt="Paglaum" />
            <div class="form-header">
                <h2>Login</h2>
            </div>
            <?php
            if (isset($error)) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
            ?>
            <form action="login.php" method="POST">
                <div class="mb-4">
                    <label for="loginUsername" class="form-label">Username</label>
                    <input type="text" class="form-control" id="loginUsername" name="username" required>
                </div>
                <div class="mb-4">
                    <label for="loginPassword" class="form-label">Password</label>
                    <input type="password" class="form-control" id="loginPassword" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
            <p class="mt-3 form-text">Don't have an account? <a href="registration.php">Register here</a></p>
        </div>
    </div>
</body>
</html>
