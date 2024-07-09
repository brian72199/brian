<?php

include_once '../database_helper/db_helper.php';

$_PUT = json_decode(file_get_contents('php://input'), true);

// Set the content type to application/json
header('Content-Type: application/json');

// Check if the request method is PUT
if ($_SERVER['REQUEST_METHOD'] !== "PUT") {
    echo json_encode(['statusCode' => 405, 'message' => 'Invalid request method']);
    exit();
}

// Check if all required fields are present
if (isset($_PUT['job_id'], $_PUT['job_title'], $_PUT['job_description'], $_PUT['trail'])) {
    $data = array(
        'job_id' => $_PUT['job_id'],
        'job_title' => $_PUT['job_title'],
        'job_description' => $_PUT['job_description'],
        'trail' => $_PUT['trail']
    );

    // Prepare the UPDATE statement
    $set_values = [];
    foreach ($data as $key => $value) {
        if ($key !== 'job_id') { // Exclude user_id from update
            $escaped_value = pg_escape_literal($connection, $value);
            $set_values[] = "$key = $escaped_value";
        }
    }

    $set_clause = implode(', ', $set_values);
    $job_id = pg_escape_literal($connection, $data['job_id']);
    $sql = "UPDATE elective.jobs SET $set_clause WHERE job_id = $job_id";

    // Execute the statement
    $result = pg_query($connection, $sql);

    // Check the result and prepare the response
    if ($result) {
        $message = array(
            'statusCode' => 200,
            'message' => 'Job updated successfully.'
        );
    } else {
        $message = array(
            'statusCode' => 500,
            'message' => 'Failed to update job: ' . pg_last_error($connection)
        );
    }

    echo json_encode($message);
} else {
    echo json_encode(array(
        'statusCode' => 400,
        'message' => 'Required fields are missing.'
    ));
}

// Close the connection
pg_close($connection);

?>
