<?php
session_start();

// Ensure user is logged in and has contact_number in session
if (!isset($_SESSION['contact_number'])) {
    header("Location: login.php"); // Redirect to login page
    exit();
}

$contact_number = $_SESSION['contact_number'];

// Database connection
$host = "localhost";
$username = "root";  
$password = "";      
$dbname = "grab&go"; 

// Create connection with error handling
try {
    $conn = new mysqli($host, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Base query for orders using phoneno column
    $query = "SELECT * FROM tbl_orders WHERE phone = ?";
    $params = [$contact_number];
    $types = "s"; // 's' for string
    
    // Apply status filter if provided
    if (isset($_GET['status']) && in_array($_GET['status'], ['Pending', 'Confirmed', 'Cancelled'])) {
        $query .= " AND status = ?";
        $params[] = $_GET['status'];
        $types .= "s";
    }
    
    $query .= " ORDER BY created_at DESC";
    
    // Prepare and execute orders query
    $stmt_orders = $conn->prepare($query);
    $stmt_orders->bind_param($types, ...$params);
    $stmt_orders->execute();
    $result = $stmt_orders->get_result();

} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        .btn {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            text-decoration: none;
            margin: 10px;
            border-radius: 5px;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .status-btn {
            margin-right: 10px;
        }

        .btn-back {
            background-color: #f44336;
            color: white;
        }

        .btn-back:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Back Button -->
    <a href="customerdashboard.php" class="btn btn-back">Back to Dashboard</a>

    <h1>Order List</h1>

    <!-- Sorting buttons -->
    <div style="text-align: center; margin-bottom: 20px;">
        <a href="?status=" class="btn status-btn">All</a>
        <a href="?status=Pending" class="btn status-btn">Pending</a>
        <a href="?status=Confirmed" class="btn status-btn">Confirmed</a>
        <a href="?status=Cancelled" class="btn status-btn">Cancelled</a>
    </div>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Food Description</th>
                    <th>Quantity</th>
                    <th>Preferred Time</th>
                    <th>Payment Method</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['food_description']; ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td><?php echo $row['preferred_time']; ?></td>
                        <td><?php echo $row['payment_method']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No orders found.</p>
    <?php endif; ?>
</div>

</body>
</html>

<?php $conn->close(); ?>
