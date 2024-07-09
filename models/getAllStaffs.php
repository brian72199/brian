<?php

include_once '../database_helper/db_helper.php';

// Set the content type to application/json
header('Content-Type: application/json');

// Get the search query and page number if they exist
$search = isset($_GET['search']) ? $_GET['search'] : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Modify the query to include search functionality and pagination
$query = "SELECT staff_id, firstname, lastname, staff_description, username, privilege
          FROM elective.staffs 
          WHERE firstname ILIKE '%$search%' 
             OR lastname ILIKE '%$search%' 
             OR staff_description ILIKE '%$search%' 
             OR username ILIKE '%$search%'
          ORDER BY staff_id ASC
          LIMIT $limit OFFSET $offset";

$result = pg_query($connection, $query);

$data = array();

if ($result && pg_num_rows($result) > 0) {
    while ($row = pg_fetch_assoc($result)) {
        $data[] = $row;
    }

    // Get the total count of matching records for pagination
    $queryTotal = "SELECT COUNT(*) AS total_count 
                   FROM elective.staffs 
                   WHERE firstname ILIKE '%$search%' 
                      OR lastname ILIKE '%$search%' 
                      OR staff_description ILIKE '%$search%' 
                      OR username ILIKE '%$search%'";
    $resultTotal = pg_query($connection, $queryTotal);
    $total_count = pg_fetch_assoc($resultTotal)['total_count'];

    // Encode the data array as JSON and output it with total count
    echo json_encode(['data' => $data, 'total_count' => $total_count]);
} else {
    echo json_encode(['message' => 'No records found']);
}

// Close the connection
pg_close($connection);
?>
