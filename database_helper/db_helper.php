<?php

$host = "localhost";
$port = "62824";
$dbname = "pmpc";
$user = "postgres";
$password = "accreditationsystem@2024";

// Create connection string
$connection = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$connection) {
    // Connection failed
    echo "Connection failed: " . pg_last_error();
}

?>
