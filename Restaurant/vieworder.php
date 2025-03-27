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
    } elseif ($action === "cancel") {
        $newStatus = "Cancelled";
    } else {
        die("Invalid action.");
    }

    try {
        // Update order status in the database
        $sql = "UPDATE tbl_orders SET status = :status WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':status', $newStatus, PDO::PARAM_STR);
        $stmt->bindParam(':id', $orderId, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch customer's phone number
        $sql = "SELECT phone FROM tbl_orders WHERE id = :id";
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
        .btn i { font-size: 1.2rem; }
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
                    $sql = "SELECT cid, name, phone, food_description, quantity,time, payment_method, created_at, status FROM tbl_orders";
                    $stmt = $conn->query($sql);
                    if ($stmt->rowCount() > 0) {
<<<<<<< HEAD
                        echo '<table class="table table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Serial No</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Food</th>
                                    <th>Qty</th>
                                    <th>Time</th>
                                    <th>Payment</th>
                                    <th>Order Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody>';
                        $serialNo = 1; // Initialize serial number
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo '<tr>
                                <td>' . $serialNo++ . '</td>
                                <td>' . htmlspecialchars($row["name"]) . '</td>
                                <td>' . htmlspecialchars($row["phone"]) . '</td>
                                <td>' . htmlspecialchars($row["food_description"]) . '</td>
                                <td>' . htmlspecialchars($row["quantity"]) . '</td>
                                <td>' . htmlspecialchars($row["preferred_time"]) . '</td>
                                <td>' . htmlspecialchars($row["payment_method"]) . '</td>
                                <td>' . htmlspecialchars($row["created_at"]) . '</td>
                                <td><strong>' . htmlspecialchars($row["status"]) . '</strong></td>
                                <td>';
                            
=======
                        echo '<table class="table table-striped"><thead class="table-dark"><tr><th>ID</th><th>Name</th><th>Phone</th><th>Food</th><th>Qty</th><th>Time</th><th>Payment</th><th>Order Date</th><th>Status</th><th>Actions</th><th>Details</th></tr></thead><tbody>';
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo '<tr><td>' . htmlspecialchars($row["id"]) . '</td><td>' . htmlspecialchars($row["name"]) . '</td><td>' . htmlspecialchars($row["phone"]) . '</td><td>' . htmlspecialchars($row["food_description"]) . '</td><td>' . htmlspecialchars($row["quantity"]) . '</td><td>' . htmlspecialchars($row["time"]) . '</td><td>' . htmlspecialchars($row["payment_method"]) . '</td><td>' . htmlspecialchars($row["created_at"]) . '</td><td><strong>' . htmlspecialchars($row["status"]) . '</strong></td><td>';
>>>>>>> d1c5025688dfccdf5a5f0489bdaf7e588ccedb60
                            if ($row["status"] === "Pending") {
                                echo '<a href="?id=' . $row["id"] . '&action=confirm" class="btn btn-success btn-sm"><i class="fas fa-check-circle"></i> Confirm</a> ';
                                echo '<a href="?id=' . $row["id"] . '&action=cancel" class="btn btn-danger btn-sm"><i class="fas fa-times-circle"></i> Cancel</a>';
                            }
<<<<<<< HEAD
                            
                            echo '</td>
                                <td>
                                    <button class="btn btn-primary view-details" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#foodModal" 
                                            data-image="' . htmlspecialchars($row['food_image'] ?? '') . '" 
                                            data-name="' . htmlspecialchars($row['food_description']) . '" 
                                            data-category="' . htmlspecialchars($row['category'] ?? 'N/A') . '" 
                                            data-description="' . htmlspecialchars($row['description'] ?? 'No description available.') . '" 
                                            data-price="' . htmlspecialchars($row['price'] ?? 'N/A') . '">
                                        View Details
                                    </button>
                                </td>
                            </tr>';
=======
                            echo '</td>';
                            echo '<td><a href="#" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#orderModal' . $row['id'] . '">View Details</a></td>';
                            echo '</tr>';

                            // Modal for order details
                            echo '<div class="modal fade" id="orderModal' . $row['id'] . '" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="orderModalLabel">Order Details</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Order ID:</strong> ' . htmlspecialchars($row['id']) . '</p>
                                                <p><strong>Name:</strong> ' . htmlspecialchars($row['name']) . '</p>
                                                <p><strong>Phone:</strong> ' . htmlspecialchars($row['phone']) . '</p>
                                                <p><strong>Food Description:</strong> ' . htmlspecialchars($row['food_description']) . '</p>
                                                <p><strong>Quantity:</strong> ' . htmlspecialchars($row['quantity']) . '</p>
                                                <p><strong>Time:</strong> ' . htmlspecialchars($row['time']) . '</p>
                                                <p><strong>Payment Method:</strong> ' . htmlspecialchars($row['payment_method']) . '</p>
                                                <p><strong>Status:</strong> ' . htmlspecialchars($row['status']) . '</p>
                                                <p><strong>Order Date:</strong> ' . htmlspecialchars($row['created_at']) . '</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
>>>>>>> d1c5025688dfccdf5a5f0489bdaf7e588ccedb60
                        }
                        echo '</tbody></table>';
                    } else {
                        echo "<p class='text-center text-danger'>No orders found.</p>";
                    }
                } catch (PDOException $e) {
                    echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
                }
                ?>
            </div>
        </div>
<<<<<<< HEAD
        
        <!-- Food Details Modal -->
        <div class="modal fade" id="foodModal" tabindex="-1" aria-labelledby="foodModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="foodModalLabel">Food Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img id="modalFoodImage" src="" alt="Food Image" class="img-fluid mb-3">
                        <p><strong>Name:</strong> <span id="modalFoodName"></span></p>
                        <p><strong>Category:</strong> <span id="modalFoodCategory"></span></p>
                        <p><strong>Description:</strong> <span id="modalFoodDescription"></span></p>
                        <p><strong>Price:</strong> <span id="modalFoodPrice"></span></p>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Order Now</button>
                    </div>
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
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".view-details").forEach(button => {
            button.addEventListener("click", function() {
                document.getElementById("modalFoodImage").src = this.getAttribute("data-image") || 'default-image.jpg';
                document.getElementById("modalFoodName").textContent = this.getAttribute("data-name");
                document.getElementById("modalFoodCategory").textContent = this.getAttribute("data-category");
                document.getElementById("modalFoodDescription").textContent = this.getAttribute("data-description");
                document.getElementById("modalFoodPrice").textContent = this.getAttribute("data-price");
            });
        });
    });
    </script>
=======
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
>>>>>>> d1c5025688dfccdf5a5f0489bdaf7e588ccedb60
</body>
</html>