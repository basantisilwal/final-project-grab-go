<?php
session_start();
include('../conn/conn.php'); // Ensure database connection

header('Content-Type: application/json');

// Get JSON input data
$data = json_decode(file_get_contents("php://input"), true);

// Validate input
if (!isset($data['f_id']) || !isset($data['comment']) || empty(trim($data['comment']))) {
    echo json_encode(["error" => "Food ID and comment are required"]);
    exit;
}

$f_id = intval($data['f_id']);
$comment = htmlspecialchars(trim($data['comment']), ENT_QUOTES, 'UTF-8');

// Check if user is logged in
if (!isset($_SESSION['customer_id'])) {
    echo json_encode(["error" => "User not logged in"]);
    exit;
}

$customer_id = $_SESSION['customer_id'];

try {
    // Insert comment into the database
    $stmt = $conn->prepare("INSERT INTO tbl_comments (f_id, tbl_user_id, comment) VALUES (?, ?, ?)");
    $stmt->execute([$f_id, $customer_id, $comment]);

    echo json_encode(["success" => true, "message" => "Comment stored successfully"]);
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    echo json_encode(["error" => "An error occurred while processing your request"]);
} catch (Exception $e) {
    error_log("General error: " . $e->getMessage());
    echo json_encode(["error" => "An error occurred while processing your request"]);
}
?>
