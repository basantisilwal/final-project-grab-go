<?php
session_start();
include('../conn/conn.php'); // Ensure database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get POST data
    $f_id = isset($_POST['f_id']) ? intval($_POST['f_id']) : 0;
    $tbl_user_id = isset($_SESSION['customer_id']) ? $_SESSION['customer_id'] : 0;
    $comment = isset($_POST['comment']) ? htmlspecialchars(trim($_POST['comment']), ENT_QUOTES, 'UTF-8') : '';

    // Validate input
    if ($f_id <= 0 || empty($comment)) {
        error_log("Error: Food ID or comment is missing");
        echo json_encode(["error" => "Food ID and comment are required"]);
        exit;
    }

    try {
        // Insert comment into the database
        $stmt = $conn->prepare("INSERT INTO tbl_comments (f_id, tbl_user_id, comment) VALUES (?, ?, ?)");
        $result = $stmt->execute([$f_id, $tbl_user_id, $comment]);

        if ($result) {
            echo json_encode(["success" => true, "message" => "Comment stored successfully"]);
        } else {
            error_log("Error: Comment was not stored in the database");
            echo json_encode(["error" => "An error occurred while processing your request"]);
        }
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        echo json_encode(["error" => "An error occurred while processing your request"]);
    } catch (Exception $e) {
        error_log("General error: " . $e->getMessage());
        echo json_encode(["error" => "An error occurred while processing your request"]);
    }
}
?>
