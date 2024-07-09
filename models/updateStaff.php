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
if (isset($_PUT['staff_id'], $_PUT['firstname'], $_PUT['lastname'], $_PUT['staff_description'], $_PUT['privilege'], $_PUT['username'], $_PUT['password'])){
    $data = array(
        'staff_id' => $_PUT['staff_id'],
        'firstname' => $_PUT['firstname'],
        'lastname' => $_PUT['lastname'],
        'staff_description' => $_PUT['staff_description'],
        'privilege' => $_PUT['privilege'],
        'username' => $_PUT['username'],
        'password' => $_PUT['password']
    );

    // Prepare the UPDATE statement
    $set_values = [];
    foreach ($data as $key => $value) {
        if ($key !== 'staff_id') { // Exclude staff_id from update
            $escaped_value = pg_escape_string($connection, $value);
            $set_values[] = "$key = '$escaped_value'";
        }
    }

    $set_clause = implode(', ', $set_values);
    $staff_id = pg_escape_string($connection, $data['staff_id']);
    $sql = "UPDATE elective.staffs SET $set_clause WHERE staff_id = '$staff_id'";

    // Execute the statement
    $result = pg_query($connection, $sql);

    // Check the result and prepare the response
    if ($result) {
        $message = array(
            'statusCode' => 200,
            'message' => 'Staff updated successfully.'
        );
    } else {
        $message = array(
            'statusCode' => 500,
            'message' => 'Failed to update staff: ' . pg_last_error($connection)
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
