<?php 
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
    } elseif ($action === "cancel") {
        $newStatus = "Cancelled";
    } else {
        die("Invalid action.");
    }

    try {
        // Update order status in the database
        $sql = "UPDATE tbl_order SET status = :status WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':status', $newStatus, PDO::PARAM_STR);
        $stmt->bindParam(':id', $orderId, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch customer's phone number
        $sql = "SELECT phone FROM tbl_order WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $orderId, PDO::PARAM_INT);
        $stmt->execute();
        $customer = $stmt->fetch(PDO::FETCH_ASSOC);
        $customerPhone = $customer['phone'];

        // Send SMS notification
        $message = $action === "confirm" 
            ? "Dear customer, your order #$orderId has been CONFIRMED. Thank you!" 
            : "Dear customer, your order #$orderId has been CANCELLED. Please contact support.";
        
        sendSMS($customerPhone, $message, $twilio_sid, $twilio_token, $twilio_from);

        // Redirect with success message
        header("Location: vieworder.php?message=Order updated successfully");
        exit();
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
}

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
    if(curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
        }
        .main-layout { display: flex; height: 100vh; }
        .sidebar {
            width: 250px; background-color: #f7e4a3; color: #333;
            padding: 20px 15px; position: fixed; height: 100%;
        }
        .sidebar a {
            color: #ff6700; text-decoration: none; padding: 10px 15px; display: block; margin-bottom: 10px;
        }
        .sidebar a:hover { background-color: #ff6700; color: #fff; }
        .content { margin-left: 270px; padding: 20px; }
        .table-container { background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); }
    </style>
</head>
<body>
    <div class="main-layout">
        <aside class="sidebar">
            <h2>Restaurant Dashboard</h2>
            <a href="das.php">Dashboard</a>
            <a href="addfood.php">Add Food</a>
            <a href="viewfood.php">View Food</a>
            <a href="vieworder.php">View Order</a>
            <a href="managepayment.php">View Payment</a>
            <a href="account.php">Account</a>
            <a href="updateprofile.php">Profile</a>
            <a href="#">Logout</a>
        </aside>
        <div class="content">
            <h1>View Orders</h1>
            <div class="table-container">
                <?php
                try {
                    $sql = "SELECT id, name, phone, food_description, quantity, order_type, address, preferred_time, payment_method, created_at, status FROM tbl_order";
                    $stmt = $conn->query($sql);
                    if ($stmt->rowCount() > 0) {
                        echo '<table class="table table-striped"><thead class="table-dark"><tr><th>ID</th><th>Name</th><th>Phone</th><th>Food</th><th>Qty</th><th>Type</th><th>Address</th><th>Time</th><th>Payment</th><th>Order Date</th><th>Status</th><th>Actions</th></tr></thead><tbody>';
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo '<tr><td>' . htmlspecialchars($row["id"]) . '</td><td>' . htmlspecialchars($row["name"]) . '</td><td>' . htmlspecialchars($row["phone"]) . '</td><td>' . htmlspecialchars($row["food_description"]) . '</td><td>' . htmlspecialchars($row["quantity"]) . '</td><td>' . htmlspecialchars($row["order_type"]) . '</td><td>' . htmlspecialchars($row["address"]) . '</td><td>' . htmlspecialchars($row["preferred_time"]) . '</td><td>' . htmlspecialchars($row["payment_method"]) . '</td><td>' . htmlspecialchars($row["created_at"]) . '</td><td><strong>' . htmlspecialchars($row["status"]) . '</strong></td><td>';
                            if ($row["status"] === "Pending") {
                                echo '<a href="?id=' . htmlspecialchars($row["id"]) . '&action=confirm" class="btn btn-success btn-sm">Confirm</a> ';
                                echo '<a href="?id=' . htmlspecialchars($row["id"]) . '&action=cancel" class="btn btn-danger btn-sm">Cancel</a>';
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
