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

// Fetch logo details
$current_logo = "logo.png"; // Default logo
$logoQuery = $conn->prepare("SELECT logo_path FROM tbl_logo LIMIT 1");
$logoQuery->execute();
$row = $logoQuery->fetch(PDO::FETCH_ASSOC);
if ($row) {
    $current_logo = $row['logo_path'];
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
        .order-details-modal .modal-body {
            display: flex;
            flex-wrap: wrap;
        }
        .order-details-modal .food-image {
            flex: 0 0 40%;
            padding-right: 20px;
        }
        .order-details-modal .food-info {
            flex: 0 0 60%;
        }
        .order-details-modal .food-image img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="main-layout">
        <!-- Sidebar -->
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
            <div class="table-container">
                <?php
                try {
                    // Join tbl_orders with tbl_addfood to get food details
                    $sql = "SELECT o.*, f.food_name, f.description as food_description_full, 
                            f.price, f.category, f.image, f.availability
                            FROM tbl_orders o
                            LEFT JOIN tbl_addfood f ON o.f_id = f.f_id
                            ORDER BY o.created_at DESC";
                    $stmt = $conn->query($sql);
                    
                    if ($stmt->rowCount() > 0) {
                        echo '<table class="table table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
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
                        
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            // Build image path
                            $imagePath = "uploads/" . htmlspecialchars($row['image']);
                            if (!file_exists($imagePath) || empty($row['image'])) {
                                $imagePath = "/Grabandgo/final-project-grab-go/Restaurant/uploads/" . htmlspecialchars($row['image']);
                            }
                            
                            echo '<tr>
                                <td>' . htmlspecialchars($row["cid"]) . '</td>
                                <td>' . htmlspecialchars($row["name"]) . '</td>
                                <td>' . htmlspecialchars($row["phone"]) . '</td>
                                <td>' . htmlspecialchars($row["food_name"]) . '</td>
                                <td>' . htmlspecialchars($row["quantity"]) . '</td>
                                <td>' . htmlspecialchars($row["preferred_time"]) . '</td>
                                <td>' . htmlspecialchars($row["payment_method"]) . '</td>
                                <td>' . htmlspecialchars($row["created_at"]) . '</td>
                                <td><strong>' . htmlspecialchars($row["status"]) . '</strong></td>
                                <td>';
                            
                            if ($row["status"] === "Pending") {
                                echo '<a href="?id=' . $row["cid"] . '&action=confirm" class="btn btn-success btn-sm"><i class="fas fa-check-circle"></i> Confirm</a> ';
                                echo '<a href="?id=' . $row["cid"] . '&action=cancel" class="btn btn-danger btn-sm"><i class="fas fa-times-circle"></i> Cancel</a>';
                            }
                            
                            echo '</td>
                                <td>
                                    <button class="btn btn-primary view-details" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#orderDetailsModal" 
                                            data-image="' . $imagePath . '" 
                                            data-name="' . htmlspecialchars($row['food_name']) . '" 
                                            data-category="' . htmlspecialchars($row['category']) . '" 
                                            data-description="' . htmlspecialchars($row['food_description_full']) . '" 
                                            data-price="RS ' . htmlspecialchars($row['price']) . '"
                                            data-customer="' . htmlspecialchars($row['name']) . '"
                                            data-phone="' . htmlspecialchars($row['phone']) . '"
                                            data-quantity="' . htmlspecialchars($row['quantity']) . '"
                                            data-time="' . htmlspecialchars($row['preferred_time']) . '"
                                            data-payment="' . htmlspecialchars($row['payment_method']) . '"
                                            data-status="' . htmlspecialchars($row['status']) . '"
                                            data-date="' . htmlspecialchars($row['created_at']) . '">
                                        View Details
                                    </button>
                                </td>
                            </tr>';
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
        
        <!-- Order Details Modal -->
        <div class="modal fade order-details-modal" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="orderDetailsModalLabel">Order Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="food-image">
                            <img id="modalFoodImage" src="" alt="Food Image" class="img-fluid mb-3">
                            <h4 id="modalFoodName"></h4>
                            <p><strong>Category:</strong> <span id="modalFoodCategory"></span></p>
                            <p><strong>Description:</strong> <span id="modalFoodDescription"></span></p>
                            <p><strong>Price:</strong> <span id="modalFoodPrice"></span></p>
                        </div>
                        <div class="food-info">
                            <h4>Order Information</h4>
                            <p><strong>Customer Name:</strong> <span id="modalCustomerName"></span></p>
                            <p><strong>Phone Number:</strong> <span id="modalCustomerPhone"></span></p>
                            <p><strong>Quantity:</strong> <span id="modalQuantity"></span></p>
                            <p><strong>Preferred Time:</strong> <span id="modalPreferredTime"></span></p>
                            <p><strong>Payment Method:</strong> <span id="modalPaymentMethod"></span></p>
                            <p><strong>Order Status:</strong> <span id="modalOrderStatus"></span></p>
                            <p><strong>Order Date:</strong> <span id="modalOrderDate"></span></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <script>
        $(document).ready(function () {
            $(".update-order").click(function () {
                var orderId = $(this).data("id");
                var action = $(this).data("action");

                $.post("", { id: orderId, action: action }, function (response) {
                    if (response.status === "success") {
                        location.reload();
                    } else {
                        alert(response.message);
                    }
                }, "json").fail(function () {
                    alert("An error occurred. Please try again.");
                });
            });
            
            // Handle view details button click
            $(document).on("click", ".view-details", function() {
                // Set food details
                $("#modalFoodImage").attr("src", $(this).data("image"));
                $("#modalFoodName").text($(this).data("name"));
                $("#modalFoodCategory").text($(this).data("category"));
                $("#modalFoodDescription").text($(this).data("description"));
                $("#modalFoodPrice").text($(this).data("price"));
                
                // Set order details
                $("#modalCustomerName").text($(this).data("customer"));
                $("#modalCustomerPhone").text($(this).data("phone"));
                $("#modalQuantity").text($(this).data("quantity"));
                $("#modalPreferredTime").text($(this).data("time"));
                $("#modalPaymentMethod").text($(this).data("payment"));
                $("#modalOrderStatus").text($(this).data("status"));
                $("#modalOrderDate").text($(this).data("date"));
            });
        });
        </script>
    </div>
</body>
</html>