<?php

require_once __DIR__ . '/../connect.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['user_id'])) {
        echo json_encode(['status' => 'error', 'message' => 'user_id is required']);
        exit;
    }

    $user_id = intval($_GET['user_id']);

    // Fetch user details based on user_id
    $sql = "SELECT id, firstname, secondname, email, phone FROM users WHERE id = $user_id";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo json_encode(['status' => 'error', 'message' => 'Database query failed']);
        exit;
    }

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        echo json_encode(['status' => 'success', 'data' => $user]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'User not found']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method. Use GET.']);
}
