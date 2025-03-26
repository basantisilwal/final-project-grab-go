<?php
session_start();
include('../conn/conn.php');

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['customer_id'])) {
    echo json_encode(['error' => 'You must be logged in to comment']);
    exit;
}

// Get POST data
$f_id = isset($_POST['f_id']) ? intval($_POST['f_id']) : 0;
$tbl_user_id = isset($_POST['tbl_user_id']) ? intval($_POST['tbl_user_id']) : 0;
$comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';

// Validate input
if ($f_id <= 0) {
    echo json_encode(['error' => 'Invalid food item']);
    exit;
}

if ($tbl_user_id <= 0) {
    echo json_encode(['error' => 'Invalid user']);
    exit;
}

if (empty($comment)) {
    echo json_encode(['error' => 'Comment cannot be empty']);
    exit;
}

try {
    // Insert comment
    $stmt = $conn->prepare("INSERT INTO tbl_comments (f_id, tbl_user_id, comment) VALUES (?, ?, ?)");
    $stmt->execute([$f_id, $tbl_user_id, $comment]);

    echo json_encode(['success' => true, 'message' => 'Comment added successfully']);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>