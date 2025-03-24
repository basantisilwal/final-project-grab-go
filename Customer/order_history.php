<?php
// Start session
session_start();

// Establish database connection
require_once('../conn/conn.php'); 

// Ensure user is logged in
if (!isset($_SESSION['customer_id'])) {
    die("Please log in to view your order history.");
}

$customer_id = $_SESSION['customer_id']; // Retrieve customer ID from session

// Fetch order history with food details (including image)
$sql = "
    SELECT 
        o.cid, o.created_at, o.quantity, o.status, 
        f.food_name, f.image, f.price,
        (f.price * o.quantity) AS total_price
    FROM tbl_orders o
    JOIN tbl_addfood f ON o.f_id = f.f_id
    WHERE o.cid = :customer_id
    ORDER BY o.created_at DESC
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
            padding: 20px;
        }
        .order-container {
            width: 100%;
            max-width: 600px;
            margin: auto;
            position: relative;
        }
        /* Close Button */
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
    </style>
</head>
<body>

    <div class="order-container">
        <!-- Close Button -->
        <button class="close-btn" onclick="goToDashboard()">❌</button>

        <h1 style="text-align:center;">Order History</h1>

        <?php foreach ($orders as $order) { ?>
        <div class="order-card">
            <div class="order-header">
                <div class="icon">📦</div>
                <div>
                    <h3>Delivered</h3>
                    <p><?php echo date('d/m/Y', strtotime($order['created_at'])); ?></p>
                </div>
            </div>
            <div class="order-body">
                <!-- Fetch and display image from tbl_addfood -->
                <img src="<?php echo htmlspecialchars($order['image']); ?>" alt="<?php echo htmlspecialchars($order['food_name']); ?>">
                <div class="order-info">
                    <p>Your feedback will help others make the right choice. Tap here to share your review</p>
                    <p>Order # <?php echo rand(100000000000000, 999999999999999); ?></p>
                    <p>Tracking # <?php echo rand(100000000000, 999999999999); ?></p>
                </div>
            </div>
        </div>
        <?php } ?>

    </div>

    <script>
        function goToDashboard() {
            window.location.href = "customerdashboard.php"; // Redirect to dashboard
        }
    </script>

</body>
</html>
