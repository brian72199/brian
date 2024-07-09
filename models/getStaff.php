<?php

include_once '../database_helper/db_helper.php';

// Set the content type to application/json
header('Content-Type: application/json');

// Check if the request method is GET   
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode(['statusCode' => 405, 'message' => 'Invalid request method. Only GET is allowed.']);
    exit();
}

// Check if user_id is provided and is numeric
if (isset($_GET['staff_id']) && is_numeric($_GET['staff_id'])) {
    $staff_id = $_GET['staff_id'];

    // Prepare the SQL statement with a placeholder for user_id
    $query = "SELECT * FROM elective.staffs WHERE staff_id = $staff_id";
    
    // Execute query
    $result = pg_query($connection, $query);
    
    // Check if query was successful
    if ($result) {
        // Check if there are rows in the result
        if (pg_num_rows($result) > 0) {
            // Fetch the user details
            $user = pg_fetch_assoc($result);
            
            // Return JSON response with all user information
            echo json_encode($user);
        } else {
            // No user found
            echo json_encode(['statusCode' => 404, 'message' => 'Staff not found']);
        }
    } else {
        // Query execution failed
        echo json_encode(['statusCode' => 500, 'message' => 'Failed to fetch staff details: ' . pg_last_error($connection)]);
    }
} else {
    // Invalid request or user_id not provided
    echo json_encode(['statusCode' => 400, 'message' => 'Invalid or missing staff_id']);
}

// Close the connection
pg_close($connection);

?>
