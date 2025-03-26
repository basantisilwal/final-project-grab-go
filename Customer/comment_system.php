<?php
session_start();
include('../conn/conn.php');

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and validate POST data
    $f_id = isset($_POST['f_id']) ? intval($_POST['f_id']) : 0;
    $tbl_user_id = isset($_SESSION['customer_id']) ? intval($_SESSION['customer_id']) : 0;
    $comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';

    // Validate inputs
    $errors = [];
    if ($f_id <= 0) $errors[] = "Invalid food item";
    if ($tbl_user_id <= 0) $errors[] = "You must be logged in to comment";
    if (empty($comment)) $errors[] = "Comment cannot be empty";
    if (strlen($comment) > 500) $errors[] = "Comment is too long (max 500 characters)";

    if (!empty($errors)) {
        echo json_encode(["error" => implode(", ", $errors)]);
        exit;
    }

    try {
        // Debug: Check what food IDs exist
        $all_food = $conn->query("SELECT f_id FROM tbl_addfood")->fetchAll(PDO::FETCH_COLUMN);
        error_log("Available food IDs: " . print_r($all_food, true));
        error_log("Trying to find food ID: " . $f_id);

        // Check if food item exists (case-sensitive comparison)
        $check_food = $conn->prepare("SELECT f_id FROM tbl_addfood WHERE f_id = ?");
        $check_food->execute([$f_id]);
        
        if ($check_food->rowCount() == 0) {
            error_log("Food item not found in database");
            echo json_encode([
                "error" => "Food item not found",
                "debug" => [
                    "provided_f_id" => $f_id,
                    "available_f_ids" => $all_food
                ]
            ]);
            exit;
        }

        // Insert comment
        $stmt = $conn->prepare("INSERT INTO tbl_comments (f_id, tbl_user_id, comment) VALUES (?, ?, ?)");
        $stmt->bindParam(1, $f_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $tbl_user_id, PDO::PARAM_INT);
        $stmt->bindParam(3, $comment, PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            $new_comment_id = $conn->lastInsertId();
            echo json_encode([
                "success" => true,
                "message" => "Comment added successfully",
                "comment_id" => $new_comment_id
            ]);
        } else {
            $error = $stmt->errorInfo();
            error_log("Database error: " . print_r($error, true));
            echo json_encode(["error" => "Database error: " . $error[2]]);
        }
    } catch (PDOException $e) {
        error_log("Database exception: " . $e->getMessage());
        echo json_encode(["error" => "Database error occurred"]);
    }
} else {
    echo json_encode(["error" => "Invalid request method"]);
}
?>