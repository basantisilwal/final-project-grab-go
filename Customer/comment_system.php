<?php
session_start();
include('../conn/conn.php'); // Database connection

// Set the Content-Type header to application/json
header('Content-Type: application/json');

// Check if the user is logged in
$customer_id = $_SESSION['customer_id'] ?? null;

if (!$customer_id) {
    http_response_code(401); // Unauthorized
    echo json_encode(["error" => "User not logged in"]);
    exit;
}

// Read JSON input
$data = json_decode(file_get_contents("php://input"), true);

// Check if action is set
if (!isset($data['action'])) {
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "Invalid request"]);
    exit;
}

$action = $data['action'];

try {
    if ($action === 'submit') {
        // Submit a comment
        if (empty($data['f_id']) || empty($data['comment'])) {
            http_response_code(400); // Bad Request
            echo json_encode(["error" => "All fields are required"]);
            exit;
        }

        $f_id = intval($data['f_id']);
        $comment = htmlspecialchars($data['comment'], ENT_QUOTES, 'UTF-8');

        $stmt = $conn->prepare("INSERT INTO tbl_comments (f_id, tbl_user_id, comment) VALUES (?, ?, ?)");
        $stmt->execute([$f_id, $customer_id, $comment]);

        http_response_code(200); // OK
        echo json_encode(["success" => true]);
        exit;
    } else {
        http_response_code(400); // Bad Request
        echo json_encode(["error" => "Invalid action"]);
        exit;
    }
} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    error_log("Database error: " . $e->getMessage());
    echo json_encode(["error" => "An error occurred while processing your request"]);
}
?>