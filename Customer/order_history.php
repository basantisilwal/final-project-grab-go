<?php
session_start();
require_once('../conn/conn.php'); 

// Ensure user is logged in
if (!isset($_SESSION['customer_id'])) {
    die("Please log in to view your order history.");
}

$customer_id = $_SESSION['customer_id']; 

// Fetch confirmed orders
$sql = "
    SELECT 
        o.cid, o.created_at, o.quantity, o.status, 
        f.food_name, f.image, f.price,
        (f.price * o.quantity) AS total_price
    FROM tbl_orders o
    JOIN tbl_addfood f ON o.f_id = f.f_id
    WHERE o.cid = :customer_id AND o.status = 'Confirmed'
    ORDER BY o.created_at DESC
";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Delete order history
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_order'])) {
    $order_id = $_POST['order_id'];

    $delete_sql = "DELETE FROM tbl_orders WHERE cid = :order_id AND cid = :customer_id";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $delete_stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
    
    if ($delete_stmt->execute()) {
        header("Location: order_history.php");
        exit();
    } else {
        echo "Error deleting order.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Order History</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            padding: 20px;
        }
        .order-container {
            width: 100%;
            max-width: 600px;
            margin: auto;
            position: relative;
        }
        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #e63946;
        }
        .order-card {
            background: white;
            border-radius: 10px;
            padding: 15px;
            margin: 10px 0;
            box-shadow: 0px 2px 5px rgba(0,0,0,0.1);
            position: relative;
        }
        .order-header {
            display: flex;
            align-items: center;
        }
        .order-header .icon {
            width: 40px;
            height: 40px;
            background: #007bff;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            font-size: 18px;
            margin-right: 10px;
        }
        .order-header h3 {
            margin: 0;
            font-size: 16px;
            color: #333;
        }
        .order-header p {
            margin: 0;
            font-size: 14px;
            color: gray;
        }
        .order-body {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }
        .order-body img {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            margin-right: 15px;
            object-fit: cover;
            border: 1px solid #ddd;
        }
        .order-info {
            flex-grow: 1;
        }
        .order-info p {
            margin: 5px 0;
            font-size: 14px;
            color: gray;
        }
        .order-info span {
            font-size: 16px;
            font-weight: bold;
            color: #e63946;
        }
        .delete-btn {
            background-color: #e63946;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            margin-top: 10px;
        }
        .delete-btn:hover {
            background-color: #c92b39;
        }
    </style>
</head>
<body>
    <div class="order-container">
        <button class="close-btn" onclick="goToDashboard()">❌</button>
        <h1 style="text-align:center;">Order History</h1>
        
        <?php if (empty($orders)) { ?>
            <p style="text-align:center; color: gray;">No confirmed orders found.</p>
        <?php } else { ?>
            <?php foreach ($orders as $order) { ?>
            <div class="order-card">
                <div class="order-header">
                    <div class="icon">📦</div>
                    <div>
                        <h3><?php echo ucfirst($order['status']); ?></h3>
                        <p><?php echo date('d/m/Y', strtotime($order['created_at'])); ?></p>
                    </div>
                </div>
                <div class="order-body">
                    <img src="<?php echo htmlspecialchars($order['image']); ?>" alt="<?php echo htmlspecialchars($order['food_name']); ?>">
                    <div class="order-info">
                        <p><b><?php echo htmlspecialchars($order['food_name']); ?></b></p>
                        <p>Quantity: <?php echo $order['quantity']; ?></p>
                        <p>Total Price: <span>$<?php echo number_format($order['total_price'], 2); ?></span></p>
                        <form method="POST">
                            <input type="hidden" name="order_id" value="<?php echo $order['cid']; ?>">
                            <button type="submit" name="delete_order" class="delete-btn">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php } ?>
        <?php } ?>
    </div>

    <script>
        function goToDashboard() {
            window.location.href = "customerdashboard.php";
        }
    </script>
</body>
</html>
