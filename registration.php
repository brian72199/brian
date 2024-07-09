<?php
session_start();
require './database_helper/db_helper.php'; // Adjust the path as per your file structure

// Function to generate a unique random user_id
function generateUniqueUserId($connection) {
    $unique = false;
    $user_id = null;

    // Keep generating until we find a unique user_id
    while (!$unique) {
        // Generate a random user_id (e.g., between 1000 and 99999)
        $user_id = rand(1000, 99999);

        // Check if the user_id already exists in the database
        $query = "SELECT user_id FROM elective.users WHERE user_id = $1";
        $stmt = pg_prepare($connection, "check_user_id", $query);

        if (!$stmt) {
            $error = "Failed to prepare statement: " . pg_last_error();
            return null; // Handle error
        }

        $result = pg_execute($connection, "check_user_id", array($user_id));

        if (!$result) {
            $error = "Error executing query: " . pg_last_error();
            return null; // Handle error
        }

        // If user_id doesn't exist, mark it as unique
        if (pg_num_rows($result) == 0) {
            $unique = true;
        }
    }

    return $user_id;
}

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validate form data
    if (empty($username) || empty($password) || empty($confirm_password)) {
        $error = "All fields are required.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Check if the username already exists
        $query = "SELECT * FROM elective.users WHERE username = $1";
        $stmt = pg_prepare($connection, "check_username", $query);

        if (!$stmt) {
            $error = "Failed to prepare statement: " . pg_last_error();
        } else {
            $result = pg_execute($connection, "check_username", array($username));

            if (!$result) {
                $error = "Error executing query: " . pg_last_error();
            } else {
                $user = pg_fetch_assoc($result);

                if ($user) {
                    $error = "Username already taken.";
                } else {
                    // Generate unique user_id
                    $user_id = generateUniqueUserId($connection);

                    if (!$user_id) {
                        $error = "Failed to generate unique user ID.";
                    } else {
                        // Insert the new user into the database
                        $insert_query = "INSERT INTO elective.users (user_id, username, password) VALUES ($1, $2, $3)";
                        $insert_stmt = pg_prepare($connection, "insert_user", $insert_query);

                        if (!$insert_stmt) {
                            $error = "Failed to prepare insert statement: " . pg_last_error();
                        } else {
                            $insert_result = pg_execute($connection, "insert_user", array($user_id, $username, $password));

                            if (!$insert_result) {
                                $error = "Error inserting user: " . pg_last_error();
                            } else {
                                $_SESSION['username'] = $username;
                                header('Location: login.php');
                                exit;
                            }
                        }
                    }
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/reg.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
        <img src="pictures/paglaum.jpg" alt="Paglaum" />
            <div class="form-header">
                <h2>Register</h2>
            </div>
            <?php
            if (isset($error)) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
            ?>
            <form action="registration.php" method="POST">
                <div class="mb-3">
                    <label for="registerUsername" class="form-label">Username</label>
                    <input type="text" class="form-control" id="registerUsername" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="registerPassword" class="form-label">Password</label>
                    <input type="password" class="form-control" id="registerPassword" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="registerConfirmPassword" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="registerConfirmPassword" name="confirm_password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Register</button>
            </form>
            <p class="mt-3 form-text">Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>




