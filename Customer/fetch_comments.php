<?php
session_start();
include('../conn/conn.php');

$f_id = isset($_GET['f_id']) ? intval($_GET['f_id']) : 0;

if ($f_id <= 0) {
    die("Invalid food item");
}

try {
    $stmt = $conn->prepare("
        SELECT c.*, u.first_name, u.last_name 
        FROM tbl_comments c
        JOIN tbl_otp u ON c.tbl_user_id = u.tbl_user_id
        WHERE c.f_id = ?
        ORDER BY c.created_at DESC
    ");
    $stmt->execute([$f_id]);
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($comments)) {
        echo "<p>No comments yet. Be the first to comment!</p>";
    } else {
        foreach ($comments as $comment) {
            echo '<div class="comment">';
            echo '<strong>' . htmlspecialchars($comment['first_name'] . ' ' . htmlspecialchars($comment['last_name']) . '</strong>';
            echo '<small> ' . date('M j, Y g:i A', strtotime($comment['created_at'])) . '</small>';
            echo '<p>' . htmlspecialchars($comment['comment']) . '</p>';
            echo '</div><hr>';
        }
    }
} catch (PDOException $e) {
    echo "<p>Error loading comments</p>";
}
?>