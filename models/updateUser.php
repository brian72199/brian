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
if (isset($_PUT['user_id'], $_PUT['firstname'], $_PUT['lastname'], $_PUT['birthdate'], $_PUT['address'], $_PUT['email'], $_PUT['username'], $_PUT['password'])) {
    $data = array(
        'user_id' => $_PUT['user_id'],
        'firstname' => $_PUT['firstname'],
        'lastname' => $_PUT['lastname'],
        'birthdate' => $_PUT['birthdate'],
        'address' => $_PUT['address'],
        'email' => $_PUT['email'],
        'username' => $_PUT['username'],
        'password' => $_PUT['password']
    );

    // Prepare the UPDATE statement
    $set_values = [];
    foreach ($data as $key => $value) {
        if ($key !== 'user_id') { // Exclude user_id from update
            $escaped_value = pg_escape_literal($connection, $value);
            $set_values[] = "$key = $escaped_value";
        }
    }

    $set_clause = implode(', ', $set_values);
    $user_id = pg_escape_literal($connection, $data['user_id']);
    $sql = "UPDATE elective.users SET $set_clause WHERE user_id = $user_id";

    // Execute the statement
    $result = pg_query($connection, $sql);

    // Check the result and prepare the response
    if ($result) {
        $message = array(
            'statusCode' => 200,
            'message' => 'User updated successfully.'
        );
    } else {
        $message = array(
            'statusCode' => 500,
            'message' => 'Failed to update user: ' . pg_last_error($connection)
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
