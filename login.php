<?php

require_once __DIR__ . "/connect.php";  // Include the database connection file
require_once __DIR__ . "/cors.php";      // Include CORS headers to allow API calls from different origins

function login_user() {
    global $conn;

    // Capture POST parameters (email and password)
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Prepare SQL statement to check if the user exists by email
    $sql = 'SELECT id, password FROM users WHERE email = ?';
    $stmt = $conn->prepare($sql);

    // Bind parameters to the SQL statement
    $stmt->bind_param("s", $email);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if the email exists in the database
    if ($result->num_rows > 0) {
        // Fetch the user's data (id and hashed password)
        $row = $result->fetch_assoc();
        $userId = $row['id'];
        $hashedPassword = $row['password'];

        // Verify the entered password against the stored hashed password
        if (password_verify($password, $hashedPassword)) {
            // Return success response and user ID
            echo json_encode([
                "status" => "success",
                "message" => "Login successful",
                "user_id" => $userId
            ]);
        } else {
            // Invalid password
            echo json_encode([
                "status" => "error",
                "message" => "Invalid email or password"
            ]);
        }
    } else {
        // No user found with the provided email
        echo json_encode([
            "status" => "error",
            "message" => "Invalid email or password"
        ]);
    }

    // Close the statement to free up resources
    $stmt->close();
}

// Call the function to authenticate the user
login_user();

?>
