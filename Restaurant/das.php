<?php
include('../conn/conn.php'); // Ensure this uses PDO

// Get today's date
$today = date('Y-m-d');

// Count completed orders (status = 'Confirmed')
$sql_completed = "SELECT COUNT(*) AS completed FROM tbl_orders WHERE status='Confirmed' AND DATE(created_at) = :today";
$stmt_completed = $conn->prepare($sql_completed);
$stmt_completed->bindParam(':today', $today);
$stmt_completed->execute();
$row_completed = $stmt_completed->fetch(PDO::FETCH_ASSOC);
$completed = $row_completed['completed'] ?? 0;

// Count pending orders (status = 'Pending')
$sql_pending = "SELECT COUNT(*) AS pending FROM tbl_orders WHERE status='Pending' AND DATE(created_at) = :today";
$stmt_pending = $conn->prepare($sql_pending);
$stmt_pending->bindParam(':today', $today);
$stmt_pending->execute();
$row_pending = $stmt_pending->fetch(PDO::FETCH_ASSOC);
$pending = $row_pending['pending'] ?? 0;

// Count total food items
$sql_food = "SELECT COUNT(*) AS total_food FROM tbl_addfood";
$stmt_food = $conn->prepare($sql_food);
$stmt_food->execute();
$row_food = $stmt_food->fetch(PDO::FETCH_ASSOC);
$total_food = $row_food['total_food'] ?? 0;

// Fetch Logo
$current_logo = "logo.png"; // fallback if none in DB
$logoQuery    = "SELECT name, path FROM tbl_owlogo LIMIT 1";
$logoStmt     = $conn->prepare($logoQuery);
$logoStmt->execute();

if ($row = $logoStmt->fetch(PDO::FETCH_ASSOC)) {
    // If a logo exists in DB, use that
    $current_logo = $row['path'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            background-color: #FFE0B2;
        }

        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, #f7b733, #fc4a1a);
            color: #fff;
            height: 100vh;
            display: flex;
            flex-direction: column;
            padding: 20px;
            position: fixed;
            top: 0;
            left: 0;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.2);
        }

        .sidebar h2 {
            font-size: 1.4rem;
            font-weight: bold;
            margin-bottom: 20px;
            text-transform: uppercase;
            text-align: center;
            letter-spacing: 1px;
        }

        .sidebar a {
            color: #000;
            text-decoration: none;
            padding: 12px 15px;
            border-radius: 5px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            font-size: 1.1rem;
            transition: all 0.3s ease-in-out;
            font-weight: 500;
        }

        .sidebar a:hover {
            background: #000;
            color: #fff;
            transform: translateX(5px);
        }

        .logo-container {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .logo-container img {
            width: 80px;
            border-radius: 50%;
            border: 2px solid black;
        }

        .content-container {
            flex: 1;
            padding: 20px;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-left: 250px;
        }

        .content {
            background-color: #FFE0B2;
            border-radius: 5px;
            padding: 15px;
            color: #000;
            width: 100%;
            max-width: 600px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .content h3 {
            margin-bottom: 15px;
            font-size: 1.2rem;
        }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="logo-container">
        <img src="<?php echo htmlspecialchars($current_logo); ?>" alt="Admin Logo">
    </div>
    <h2>Dashboard</h2>
    <a href="das.php"><i class="fas fa-home"></i> Dashboard</a>
    <a href="addfood.php"><i class="fas fa-utensils"></i> Add Food</a>
    <a href="viewfood.php"><i class="fas fa-list"></i> View Food</a>
    <a href="vieworder.php"><i class="fas fa-shopping-cart"></i> View Order</a>
    <a href="setting.php"><i class="bi bi-gear"></i> Settings</a>
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</aside>

<div class="content-container">
    <div class="content">
        <h3>Orders Today</h3>
        <p>Completed: <span id="orders-completed"><?php echo $completed; ?></span></p>
        <p>Pending: <span id="orders-pending"><?php echo $pending; ?></span></p>
        <button onclick="updateOrders()">Refresh</button>

        <h3 style="margin-top: 20px;">Total Menu</h3>
        <p>Available Food Items: <span id="menu"><?php echo $total_food; ?></span></p>
        <button onclick="refreshMenu()">View All</button>
    </div>
</div>

<script>
    function updateOrders() {
        fetch('api.php?action=orders')
            .then(response => response.json())
            .then(data => {
                document.getElementById('orders-completed').innerText = data.completed;
                document.getElementById('orders-pending').innerText = data.pending;
            })
            .catch(error => console.error('Error fetching order data:', error));
    }

    function refreshMenu() {
        fetch('api.php?action=menu')
            .then(response => response.json())
            .then(data => {
                document.getElementById('menu').innerText = data.total_food;
            })
            .catch(error => console.error('Error fetching menu data:', error));
    }
</script>

</body>
</html>
