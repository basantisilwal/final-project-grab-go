<?php
session_start();
require_once('../conn/conn.php'); // Database connection

// Check if it's an AJAX request for updating order status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    $action = $_POST['action'] ?? '';
    $id = intval($_POST['id'] ?? 0);

    if (!$id || !$action) {
        echo json_encode(["status" => "error", "message" => "Missing required parameters"]);
        exit;
    }

    // Determine the new status and notification message
    switch ($action) {
        case 'confirm':
            $status = 'Confirmed';
            $notification = 'Your order has been confirmed!';
            break;
        case 'reject':
            $status = 'Cancelled';
            $notification = 'Your order has been cancelled!';
            break;
        default:
            echo json_encode(["status" => "error", "message" => "Invalid action"]);
            exit;
    }

    // Update the order status in the database
    $stmt = $conn->prepare("UPDATE tbl_orders 
                            SET status = ?, 
                                customer_notification = ?, 
                                updated_at = CURRENT_TIMESTAMP 
                            WHERE cid = ?");
    
    if ($stmt->execute([$status, $notification, $id])) {
        // Store notification in session for display
        $_SESSION['notification'] = $notification; 
        echo json_encode(["status" => "success", "message" => "Order updated", "notification" => $notification]);
    } else {
        echo json_encode(["status" => "error", "message" => "Database update failed"]);
    }

    exit;
}

// Fetch Logo from Database
$current_logo = "logo.png"; // Default logo
$logoQuery = "SELECT path FROM tbl_owlogo LIMIT 1";
$logoStmt = $conn->prepare($logoQuery);
$logoStmt->execute();
if ($row = $logoStmt->fetch(PDO::FETCH_ASSOC)) {
    $current_logo = $row['path'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #FFE0B2;
            color: #333;
        }
        .main-layout { display: flex; height: 100vh; }
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
        .content { margin-left: 270px; padding: 20px; }
        .table-container { background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); }
    </style>
</head>
<body>
    <div class="main-layout">
        <aside class="sidebar">
            <div class="logo-container">
                <img src="<?php echo htmlspecialchars($current_logo); ?>" alt="Logo">
            </div>
            <h2>Dashboard</h2>
            <a href="das.php"><i class="fas fa-home"></i> Dashboard</a>
            <a href="addfood.php"><i class="fas fa-utensils"></i> Add Food</a>
            <a href="viewfood.php"><i class="fas fa-list"></i> View Food</a>
            <a href="vieworder.php"><i class="fas fa-shopping-cart"></i> View Order</a>
            <a href="setting.php"><i class="bi bi-gear"></i> Settings</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </aside>

        <div class="content">
            <h1>View Orders</h1>
            
            <!-- Notification Box -->
            <?php if (isset($_SESSION['notification'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($_SESSION['notification']); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php unset($_SESSION['notification']); // Clear the notification after displaying ?>
            <?php endif; ?>

            <div class="table-container">
                <?php
                try {
                    $stmt = $conn->query("SELECT cid, name, phone, food_description, quantity, preferred_time, payment_method, created_at, status FROM tbl_orders");
                    
                    if ($stmt->rowCount() > 0) {
                        echo '<table class="table table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Serial No</th><th>Name</th><th>Phone</th><th>Food</th><th>Qty</th>
                                    <th>Time</th><th>Payment</th><th>Order Date</th><th>Status</th><th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>';
                        $serialNo = 1; // Initialize serial number
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo '<tr>
                                <td>' . $serialNo++ . '</td> <!-- Displaying serial number -->
                                <td>' . htmlspecialchars($row["name"]) . '</td>
                                <td>' . htmlspecialchars($row["phone"]) . '</td>
                                <td>' . htmlspecialchars($row["food_description"]) . '</td>
                                <td>' . htmlspecialchars($row["quantity"]) . '</td>
                                <td>' . htmlspecialchars($row["preferred_time"]) . '</td>
                                <td>' . htmlspecialchars($row["payment_method"]) . '</td>
                                <td>' . htmlspecialchars($row["created_at"]) . '</td>
                                <td><strong>' . htmlspecialchars($row["status"]) . '</strong></td>
                                <td>';
                            if ($row["status"] === "Pending") {
                                echo '<button class="btn btn-success btn-sm update-order" data-id="'.$row["cid"].'" data-action="confirm"><i class="fas fa-check-circle"></i> Confirm</button>
                                <button class="btn btn-danger btn-sm update-order" data-id="'.$row["cid"].'" data-action="reject"><i class="fas fa-times-circle"></i> Cancel</button>';
                            }
                            echo '</td></tr>';
                        }
                        echo '</tbody></table>';
                    } else {
                        echo "<p>No orders found.</p>";
                    }
                } catch (PDOException $e) {
                    echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
                }
                ?>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function () {
        $(".update-order").click(function () {
            var orderId = $(this).data("id");
            var action = $(this).data("action");

            $.post("", { id: orderId, action: action }, function (response) {
                if (response.status === "success") {
                    // Reload the page to reflect changes
                    location.reload();
                } else {
                    alert(response.message); // Show error message if any
                }
            }, "json").fail(function () {
                alert("An error occurred. Please try again.");
            });
        });
    });
    </script>
</body>
</html>
