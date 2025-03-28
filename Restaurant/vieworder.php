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
        // Store notification in session for display on customer dashboard
        $_SESSION['notification'] = $notification; 
        echo json_encode(["status" => "success", "message" => "Order updated", "notification" => $notification]);
    } else {
        echo json_encode(["status" => "error", "message" => "Database update failed"]);
    }

    exit;
}

// Fetch Logo
$current_logo = "logo.png"; // fallback if none in DB
$logoQuery    = "SELECT name, path FROM tbl_logo LIMIT 1";
$logoStmt     = $conn->prepare($logoQuery);
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        .table-container { background-color: #FFE0B2; padding: 20px;
            border: 1px solid #000;
             border-radius: 8px; box-shadow: #FFE0B2 }
        .btn i { font-size: 1.2rem; }
        table td, table th {
            vertical-align: middle;
            border: 1px solid #000;
        }

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
        .logo-container {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .logo-container img {
            width: 80px;
            border-radius: 50%;
            border: 2px solid black;
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
                        $serialNumber = 1; // ✅ Initialize Serial Number
                        echo '<table class="table table-striped">
                            <thead class="">
                                <tr>
                                    <th>Serial No</th> <!-- Serial Number -->
                                    <th>User</th>
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
                            <td>' . $serialNumber++ . '</td> <!-- ✅ Replace Random ID with Serial Number -->
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
                                echo '<button class="btn btn-success btn-sm update-order" data-id="'.$row["cid"].'" data-action="confirm"><i class="fas fa-check-circle"></i> Confirm</button>
                                <button class="btn btn-danger btn-sm update-order" data-id="'.$row["cid"].'" data-action="reject"><i class="fas fa-times-circle"></i> Cancel</button>';
                            }
                            
                            echo '</td>
                                <td>
                                    <button class="btn btn-success view-details"   
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