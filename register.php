<?php

require_once __DIR__ . "/connect.php";  // Include the database connection file
require_once __DIR__ . "/cors.php";      // Include CORS headers to allow API calls from different origins

function create_user() {
    global $conn;

    // Capture POST parameters
    $firstname = $_POST["firstname"];
    $secondname = $_POST["secondname"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $password = $_POST["password"];

    // Hash the password before storing it
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL statement to insert data into the users table
    $sql = 'INSERT INTO users (firstname, secondname, email, phone, password) VALUES (?, ?, ?, ?, ?)';
    $stmt = $conn->prepare($sql);
    
    // Bind parameters to the SQL statement
    $stmt->bind_param("sssis", $firstname, $secondname, $email, $phone, $hashedPassword);

    // Execute statement and return JSON response based on success or failure
    if ($stmt->execute()) {
        // Return a success response
        echo json_encode(["status" => "success"]);
    } else {
        // Output error message if the statement fails
        echo json_encode(["status" => "error", "message" => $stmt->error]);
    }

    // Close statement to free up resources
    $stmt->close();
}

// Call the function to create a user
create_user();

?>
