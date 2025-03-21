<?php
// Include database connection
include('../conn/conn.php');

// Start session to get user details
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: order.php");
    exit();
}

// Get logged-in user's ID
$customer_id = $_SESSION['user_id'];

try {
    // SQL Query to fetch order history with food details
    $sql = "SELECT o.cid, o.food_description, o.quantity, 
                   (f.price * o.quantity) AS total_price, 
                   o.status, o.created_at, 
                   f.food_name, f.price, f.category, f.image
            FROM tbl_orders o
            JOIN tbl_addfood f ON o.food_description = f.description
            WHERE o.cid = :customer_id
            ORDER BY o.created_at DESC";

    // Prepare and execute the query
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error fetching orders: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History - Grab & Go</title>
    <link rel="stylesheet" href="styles.css"> <!-- Add your CSS file -->
</head>
<body>

    <header>
        <h1>Grab & Go - Order History</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="menu.php">Menu</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <section class="order-history">
        <h2>Your Order History</h2>
        <?php if (!empty($orders)): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Food Name</th>
                        <th>Quantity</th>
                        <th>Price (Per Unit)</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Order Date</th>
                        <th>Image</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['food_name']); ?></td>
                            <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                            <td>RS <?php echo number_format($order['price'], 2); ?></td>
                            <td>RS <?php echo number_format($order['total_price'], 2); ?></td>
                            <td><?php echo htmlspecialchars($order['status']); ?></td>
                            <td><?php echo htmlspecialchars($order['created_at']); ?></td>
                            <td>
                                <img src="uploads/<?php echo htmlspecialchars($order['image']); ?>" width="50" height="50" alt="Food Image">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>You have no past orders.</p>
        <?php endif; ?>
    </section>

</body>
</html>
