<?php

require_once __DIR__ . "/connect.php"; // Include the database connection script

// Add CORS headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");

// Fetch fruits from the database
function fetch_fruits() {
    global $conn;

    try {
        $sql = "SELECT id, fruit_name AS name, price, image_url FROM fruits";
        $result = $conn->query($sql);

        if ($result === false) {
            echo json_encode(["error" => "Error in query: " . $conn->error]);
            return;
        }

        $fruits = $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : [];
        echo json_encode($fruits);
    } catch (Exception $e) {
        echo json_encode(["error" => $e->getMessage()]);
    }
}

// Execute the function
fetch_fruits();

?>
