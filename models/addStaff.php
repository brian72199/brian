<?php

include_once '../database_helper/db_helper.php';

$_POST = json_decode(file_get_contents('php://input'), true);

// Set the content type to application/json
header('Content-Type: application/json');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    echo json_encode(['statusCode' => 405, 'message' => 'Invalid request method']);
    exit();
}

// Check if required fields are provided in the POST request data
if (isset($_POST['firstname'], $_POST['lastname'], $_POST['staff_description'], $_POST['privilege'], $_POST['username'], $_POST['password'])) {
    // Escape each value to prevent SQL injection
    $data = array(
        'firstname' => $_POST['firstname'],
        'lastname' => $_POST['lastname'],
        'staff_description' => $_POST['staff_description'],
        'privilege' => $_POST['privilege'],
        'username' => $_POST['username'],
        'password' => $_POST['password']
    );

    // Prepare column names and values for the SQL query
    $columns = implode(',', array_keys($data));
    $escaped_values = array_map(function($value) use ($connection) {
        return pg_escape_literal($value);
    }, array_values($data));
    $save_values = implode(", ", $escaped_values);

    // Construct the SQL query
    $sql = "INSERT INTO elective.staffs ($columns) VALUES ($save_values)";
    $result = pg_query($connection, $sql);
    $message = array();

    // Check the result and prepare the response
    if ($result) {
        $message = array(
            'statusCode' => 200,
            'message' => 'New staff added successfully.'
        );
    } else {
        $message = array(
            'statusCode' => 500,
            'message' => 'Failed to add new staff: ' . pg_last_error($connection)
        );
    }

    echo json_encode($message);
} else {
    // Error message if required fields are not provided
    echo json_encode(array(
        'statusCode' => 400,
        'message' => 'Required fields are missing.'
    ));
}

// Close the connection
pg_close($connection);

?>
