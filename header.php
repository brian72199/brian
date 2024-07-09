<?php
require './verifyjwt.php';

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paglaum Multi-Purpose Cooperative</title>
    <!-- Custom Stylesheet -->
    <link href="css/styles.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- Favicon -->
    <link href="pictures/paglaum.jpg" rel="icon">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="assets/js/jquery.min.js"></script>
    <!-- Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</head>
<body>
    <div class="sidebar">
        <div class="logo"><img src="pictures/paglaum.jpg" alt="Paglaum"></div>
            <nav>
                <ul>
                    <li><a href="#" data-tooltip="Profile"><i class="fas fa-user"></i><span class="tooltip-text"><?php
                    if (isset($_SESSION['username'])) {
                        echo '<span class="username">' . htmlspecialchars($_SESSION['username']) . '</span>';
                    }?></span></a></li>
                    <li><a href="#" data-tooltip="Home"><i class="fas fa-home"></i><span class="tooltip-text">Home</span></a></li>
                    <li><a href="job_index.php" data-tooltip="Jobs"><i class="fas fa-briefcase"></i><span class="tooltip-text">Jobs</span></a></li>
                    <li><a href="staff_index.php" data-tooltip="Staffs"><i class="fas fa-users"></i><span class="tooltip-text">Staffs</span></a></li>
                    <li><a href="user_index.php" data-tooltip="Users"><i class="fas fa-user"></i><span class="tooltip-text">Users</span></a></li>
                    <!-- <li><a href="#" data-tooltip="Ranking"><i class="fas fa-trophy"></i><span class="tooltip-text">Ranking</span></a></li> -->
                    <div class="logout">
                        <ul>
                            <li><a href="Login.php" data-tooltip="Logout"><i class="fas fa-sign-out-alt"></i><span class="tooltip-text">Logout</span></a></li>
                        </ul>
                    </div>
                </ul>
            </nav>
    </div>

