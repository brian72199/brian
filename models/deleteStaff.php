<?php
include_once '../database_helper/db_helper.php';

// Read input data from POST request
$_POST = json_decode(file_get_contents('php://input'), true);

// Set the content type to application/json
header('Content-Type: application/json');

// Check if the request method is DELETE
if ($_SERVER['REQUEST_METHOD'] !== "DELETE") {
    echo json_encode(['statusCode' => 405, 'message' => 'Invalid request method']);
    exit();
}

// Check if user_id is provided in the request body
if (isset($_POST['staff_id']) && is_numeric($_POST['staff_id'])) {
    $staff_id = $_POST['staff_id'];

    // Prepare the DELETE statement
    $query = "DELETE FROM elective.staffs WHERE staff_id = $1";

    // Execute the statement with parameters
    $result = pg_query_params($connection, $query, array($staff_id));

    // Check the result and prepare the response
    if ($result) {
        echo json_encode(['statusCode' => 200, 'message' => 'User deleted successfully.']);
    } else {
        echo json_encode(['statusCode' => 500, 'message' => 'Failed to delete user: ' . pg_last_error($connection)]);
    }
} else {
    echo json_encode(['statusCode' => 400, 'message' => 'Invalid or missing user_id.']);
}

// Close the connection
pg_close($connection);
?>
