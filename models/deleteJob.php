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
if (isset($_POST['job_id']) && is_numeric($_POST['job_id'])) {
    $job_id = $_POST['job_id'];

    // Prepare the DELETE statement
    $query = "DELETE FROM elective.jobs WHERE job_id = $1";

    // Execute the statement with parameters
    $result = pg_query_params($connection, $query, array($job_id));

    // Check the result and prepare the response
    if ($result) {
        echo json_encode(['statusCode' => 200, 'message' => 'Job deleted successfully.']);
    } else {
        echo json_encode(['statusCode' => 500, 'message' => 'Failed to delete job: ' . pg_last_error($connection)]);
    }
} else {
    echo json_encode(['statusCode' => 400, 'message' => 'Invalid or missing job_id.']);
}

// Close the connection
pg_close($connection);
?>
