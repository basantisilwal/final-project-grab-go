<?php
require_once('../conn/conn.php'); 

$customer_id = $_SESSION['customer_id'] ?? null;

if ($customer_id) {
    $stmt = $mysqli->prepare("SELECT customer_notification FROM tbl_orders WHERE cid = ? ORDER BY updated_at DESC LIMIT 1");
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $stmt->bind_result($notification);
    $stmt->fetch();
    $stmt->close();

    echo json_encode(["notification" => $notification]);
}
?>
