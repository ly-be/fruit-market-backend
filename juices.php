<?php

require_once __DIR__ . "/connect.php";  // Include the database connection file
require_once __DIR__ . "/cors.php";     // Include CORS headers to allow API calls from different origins

// Function to fetch juices from the database
function fetch_juices() {
    global $conn;

    // SQL query to fetch juice details from the 'juices' table
    $sql = "SELECT juice_name, juice_price, image_url FROM juices";

    // Execute the query
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result === false) {
        // Output any error in the query
        echo json_encode(["error" => "Error in query: " . $conn->error]);
        return;
    }

    // Check if there are any records in the database
    if ($result->num_rows > 0) {
        // Initialize an empty array to store juice records
        $juices = [];

        // Loop through the results and store each juice in the array
        while ($row = $result->fetch_assoc()) {
            $juices[] = $row;
        }

        // Return the juices as a JSON response
        echo json_encode($juices);
    } else {
        // Return an empty array if no juices are found
        echo json_encode([]);
    }
}

// Call the function to fetch juices
fetch_juices();

?>
