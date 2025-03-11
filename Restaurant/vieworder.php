<?php
// Include database connection
include('../conn/conn.php');

// Twilio Credentials (Replace with your actual credentials)
$twilio_sid = "YOUR_TWILIO_SID";
$twilio_token = "YOUR_TWILIO_AUTH_TOKEN";
$twilio_from = "+1234567890"; // Twilio phone number

if (isset($_GET['id']) && isset($_GET['action'])) {
    $orderId = $_GET['id'];
    $action = $_GET['action'];

    if ($action === "confirm") {
        $newStatus = "Confirmed";
        $notificationMessage = "Your order #$orderId has been CONFIRMED!";
        
        // Update the status to Confirmed
        try {
            $sql = "UPDATE tbl_orders SET status = :status, customer_notification = :notification WHERE c_id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':status', $newStatus, PDO::PARAM_STR);
            $stmt->bindParam(':notification', $notificationMessage, PDO::PARAM_STR);
            $stmt->bindParam(':id', $orderId, PDO::PARAM_INT);
            $stmt->execute();

            // Fetch customer's phone number
            $sql = "SELECT phone FROM tbl_orders WHERE c_id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $orderId, PDO::PARAM_INT);
            $stmt->execute();
            $customer = $stmt->fetch(PDO::FETCH_ASSOC);
            $customerPhone = $customer['phone'] ?? '';

            // Send SMS notification if phone exists
            if ($customerPhone) {
                sendSMS($customerPhone, $notificationMessage, $twilio_sid, $twilio_token, $twilio_from);
            }

            // Redirect with success message
            header("Location: vieworder.php?message=Order updated successfully");
            exit();

        } catch (PDOException $e) {
            echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
        }

    } elseif ($action === "cancel") {
        // Delete the order after cancelling
        try {
            // Fetch customer's phone number before deleting
            $sql = "SELECT phone FROM tbl_orders WHERE c_id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $orderId, PDO::PARAM_INT);
            $stmt->execute();
            $customer = $stmt->fetch(PDO::FETCH_ASSOC);
            $customerPhone = $customer['phone'] ?? '';

            // Delete the order from the database
            $sql = "DELETE FROM tbl_orders WHERE c_id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $orderId, PDO::PARAM_INT);
            $stmt->execute();

            // Send SMS notification if phone exists
            if ($customerPhone) {
                $notificationMessage = "Your order #$orderId has been CANCELED!";
                sendSMS($customerPhone, $notificationMessage, $twilio_sid, $twilio_token, $twilio_from);
            }

            // Redirect with success message
            header("Location: vieworder.php?message=Order cancelled successfully");
            exit();

        } catch (PDOException $e) {
            echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
        }
    } else {
        die("Invalid action.");
    }
}

// Close database connection
$conn = null;

// Function to send SMS via Twilio API
function sendSMS($to, $message, $sid, $token, $from) {
    $url = "https://api.twilio.com/2010-04-01/Accounts/$sid/Messages.json";
    $data = [
        'From' => $from,
        'To' => $to,
        'Body' => $message
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_USERPWD, "$sid:$token");
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        error_log('Twilio SMS Error: ' . curl_error($ch));
    }

    curl_close($ch);
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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:#FFE0B2;
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
        .content { margin-left: 270px; padding: 20px; }
        .table-container { background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); }
    </style>
</head>
<body>
    <div class="main-layout">
        <aside class="sidebar">
            <h2>Restaurant Dashboard</h2>
            <a href="das.php"><i class="fas fa-home"></i> Dashboard</a>
            <a href="addfood.php"><i class="fas fa-utensils"></i> Add Food</a>
            <a href="viewfood.php"><i class="fas fa-list"></i> View Food</a>
            <a href="vieworder.php"><i class="fas fa-shopping-cart"></i> View Order</a>
            <a href="managepayment.php"><i class="fas fa-money-bill"></i> View Payment</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </aside>

        <div class="content">
            <h1>View Orders</h1>
            <div class="table-container">
                <?php
                try {
                    include('../conn/conn.php');
                    $sql = "SELECT c_id, name, phone, food_description, quantity, preferred_time, payment_method, created_at, status FROM tbl_orders";
                    $stmt = $conn->query($sql);

                    if ($stmt->rowCount() > 0) {
                        echo '<table class="table table-striped"><thead class="table-dark"><tr><th>ID</th><th>Name</th><th>Phone</th><th>Food</th><th>Qty</th><th>Time</th><th>Payment</th><th>Order Date</th><th>Status</th><th>Actions</th></tr></thead><tbody>';
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo '<tr><td>' . htmlspecialchars($row["c_id"]) . '</td><td>' . htmlspecialchars($row["name"]) . '</td><td>' . htmlspecialchars($row["phone"]) . '</td><td>' . htmlspecialchars($row["food_description"]) . '</td><td>' . htmlspecialchars($row["quantity"]) . '</td><td>' . htmlspecialchars($row["preferred_time"]) . 
                            '</td><td>' . htmlspecialchars($row["payment_method"]) . '</td><td>' . htmlspecialchars($row["created_at"]) . '</td><td><strong>' . htmlspecialchars($row["status"]) . '</strong></td><td>';
                            if ($row["status"] === "Pending") {
                                echo '<a href="?id=' . $row["c_id"] . '&action=confirm" class="btn btn-success btn-sm"><i class="fas fa-check-circle"></i> Confirm</a> ';
                                echo '<a href="?id=' . $row["c_id"] . '&action=cancel" class="btn btn-danger btn-sm"><i class="fas fa-times-circle"></i> Cancel</a>';
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
</body>
</html>
