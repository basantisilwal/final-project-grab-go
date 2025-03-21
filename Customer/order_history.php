<?php
// Establish the database connection
require_once('../conn/conn.php'); 

// Assume $customer_id is retrieved from session or request
$customer_id = 1; // Replace this with actual customer ID

// Fetch order history with food details
$sql = "
    SELECT 
        o.cid, o.order_time, o.quantity, o.total, 
        f.food_name, f.image, f.price
    FROM tbl_orders o
    JOIN tbl_addfood f ON o.food_id = f.f_id
    WHERE o.cid = :customer_id
    ORDER BY o.order_time DESC
";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        }
        .order-container {
            width: 80%;
            margin: auto;
        }
        .order-item {
            display: flex;
            align-items: center;
            background: white;
            border-radius: 10px;
            padding: 15px;
            margin: 10px 0;
            box-shadow: 0px 2px 5px rgba(0,0,0,0.1);
        }
        .order-item img {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            margin-right: 15px;
        }
        .order-info {
            flex-grow: 1;
        }
        .order-info h3 {
            margin: 0;
            font-size: 16px;
            color: #333;
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
        .order-actions a {
            margin-right: 10px;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            color: #e63946;
        }
    </style>
</head>
<body>

    <h1 style="text-align:center;">Order History</h1>
    <div class="order-container">

        <?php foreach ($orders as $order) { ?>
        <div class="order-item">
            <img src="<?php echo $order['image']; ?>" alt="<?php echo $order['food_name']; ?>">
            <div class="order-info">
                <h3><?php echo $order['food_name']; ?></h3>
                <p>Order Time: <?php echo date('Y-m-d H:i:s', strtotime($order['order_time'])); ?></p>
                <p>Quantity: <?php echo $order['quantity']; ?></p>
                <p>Total: <span>$<?php echo $order['total']; ?></span></p>
            </div>
            <div class="order-actions">
                <a href="#">Reorder</a>
                <a href="#">Write a Review</a>
                <a href="#">Remove</a>
            </div>
        </div>
        <?php } ?>

    </div>

</body>
</html>
