<?php
session_start();
include('../conn/conn.php'); // Database connection

// Check if the customer is logged in
$customer_id = $_SESSION['customer_id'] ?? null;

if (!$customer_id) {
    // Redirect to login if not logged in
    header("Location: http://localhost/Grabandgo/final-project-grab-go/Customer/customerdashboard.php");
    exit();
}

// Assuming customer details are stored in session or fetched from DB
$customerFirstName = $_SESSION['customerFirstName'] ?? 'Guest';
$customerLastName = $_SESSION['customerLastName'] ?? '';
$customerPhone = $_SESSION['customerPhone'] ?? '';

// Generate CSRF token if not set
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Handle order submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['csrf_token'])) {
    if ($_POST['csrf_token'] === $_SESSION['csrf_token']) {
        // Get form data and sanitize
        $name = htmlspecialchars($_POST['name']);
        $phone = htmlspecialchars($_POST['phone']);
        $foodDescription = htmlspecialchars($_POST['fooddescription']);
        $quantity = (int)$_POST['quantity'];
        $preferred_time = $_POST['time'];
        $paymentMethod = $_POST['paymentMethod'];
        $status = "Pending"; // Default status

        // Insert order into database
        $sql = "INSERT INTO tbl_orders (name, phone, food_description, quantity, preferred_time, payment_method, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);

        if ($stmt->execute([$name, $phone, $foodDescription, $quantity, $preferred_time, $paymentMethod, $status])) {
            $_SESSION['message'] = "Order placed successfully!";
            header("Location: " . $_SERVER['PHP_SELF']); // Prevent resubmission
            exit();
        } else {
            $_SESSION['message'] = "Error placing order: " . implode(", ", $stmt->errorInfo());
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    } else {
        $_SESSION['message'] = "Invalid CSRF token!";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}


// Fetch food items based on search query
$searchQuery = "";
$foods = [];

if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $searchQuery = trim($_GET['search']);
    $query = "SELECT * FROM tbl_addfood WHERE food_name LIKE :search OR description LIKE :search ORDER BY f_id DESC";
    $stmt = $conn->prepare($query);
    $stmt->execute([':search' => "%$searchQuery%"]);
    $foods = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $query = "SELECT * FROM tbl_addfood ORDER BY f_id DESC";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $foods = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/// Fetch latest customer notification
$notification = '';
$sql = "SELECT customer_notification FROM tbl_orders WHERE cid = :customer_id ORDER BY updated_at DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
$stmt->execute();
$notification = $stmt->fetchColumn();

// Unset the notification after fetching
if ($notification) {
    $_SESSION['dashboard_notification'] = htmlspecialchars($notification);
    $sql = "UPDATE tbl_orders SET customer_notification = '' WHERE cid = :customer_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
    $stmt->execute();
}


// Fetch customer profile information
$sql = "SELECT first_name, last_name, profile_pic FROM tbl_otp WHERE tbl_user_id = :customer_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
$stmt->execute();
$customer = $stmt->fetch(PDO::FETCH_ASSOC);

// Set the profile picture path
$profilePicPath = $customer['profile_pic'] ? "uploads/{$customer['profile_pic']}" : "default_profile.png";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grab & Go</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            overflow-x: hidden; /* Prevent horizontal scrolling */
        }

        .navbar {
            background-color: #f7e4a3;
            color: #000;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar .navbar-brand {
            color: #000;
        }

        .navbar .navbar-brand:hover {
            color: #000;
        }

        .navbar .form-control {
            background-color: #fff;
            color: #000;
        }

        .btn-outline-primary {
            color: #000;
            border-color: #000;
        }

        .btn-outline-primary:hover {
            background-color: white;
            color: #000;
        }

        .navbar-toggler {
            border: 1px solid white;
        }

        .navbar-toggler-icon {
            background-color: white;
        }

        #bell {
            width: 25px;
            height: 25px;
            margin-left: 10px;
            cursor: pointer;
        }

        .search-container input {
            width: 300px;
        }

        .restaurant-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .restaurant {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            margin: 10px;
            padding: 15px;
            width: 200px;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .restaurant:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .circle-img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            display: block;
            margin: 0 auto 10px;
        }

        .restaurant-info h3 {
            margin: 10px 0 5px;
            font-size: 1.2em;
        }

        .restaurant-info p {
            margin: 0;
            font-size: 0.9em;
            color: #555;
        }

        .restaurant-info .price {
            color: #ff5722;
            font-weight: bold;
        }
        .availability {
            font-weight: bold;
            padding: 4px 10px;
            border-radius: 12px;
            display: inline-block;
            margin-top: 8px;
            font-size: 0.9em;
        }

        .available {
            background-color: #d4edda;
            color: #155724;
        }

        .unavailable {
            background-color: #f8d7da;
            color: #721c24;
        }
        /* Change search button background to black */
.btn-primary {
    background-color: black !important;
    border-color: black !important;
}

/* Change order button background to black */
.modal-footer .btn-primary {
    background-color: black !important;
    border-color: black !important;
    
}

/* Change submit order button background to black */
#orderForm .btn-primary {
    background-color: black !important;
    border-color: black !important;
}
h2 {
    font-size: 1.3rem; /* Decrease the size */
}


        .form-container {
            max-width: 500px;
            padding: 20px;
            overflow-y: auto; /* Allow scrolling if the form is too large */
        }

        .form-group {
            margin-bottom: 12px;
        }

        .form-group label {
            font-size: 14px;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 8px;
            font-size: 14px;
        }

        .form-group button {
            padding: 10px;
            font-size: 14px;
        }

        #qrCodeContainer {
            display: none;
            text-align: center;
        }

        #qrCodeImage {
            width: 200px;
            height: 200px;
        }

        /* Smaller Modal */
        .modal-dialog.modal-sm {
            max-width: 400px;
        }

        /* Smaller Form Controls */
        .form-control-sm {
            font-size: 0.875rem;
            padding: 0.375rem 0.75rem;
            height: calc(1.5em + .75rem + 2px);
        }

        /* Smaller Buttons */
        .btn-sm {
            font-size: 0.875rem;
            padding: 0.375rem 0.75rem;
        }

        /* Optional: Reduce spacing between form fields */
        .mb-3 {
            margin-bottom: 0.5rem;
        }

        /* Optional: Adjust the QR code container size */
        #qrCodeContainer img {
            max-width: 150px;
            height: auto;
        }

        footer {
            text-align: center;
            padding: 10px 0;
            background-color: #f7e4a3;
        }

        .modal-body {
            max-height: 400px;
            overflow-y: auto; /* Allow scrolling in modal if content exceeds height */
        }
        .modal-footer {
    text-align: left;
}
.comment-box {
    width: 100%;
    max-width: 500px;
    margin: 20px auto;
    padding: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background: #f9f9f9;
}
textarea {
    width: 100%;
    height: 80px;
    margin-bottom: 10px;
    padding: 10px;
}
button {
    background: #28a745;
    color: #fff;
    padding: 10px;
    border: none;
    cursor: pointer;
}
button:hover {
    background: #218838;
}
.navbar .btn-order {
    font-size: 16px;
    font-weight: bold;
    padding: 10px 20px;
}
.btn-success {
    padding: 10px 20px;
    font-weight: bold;
}
    </style>
</head>
<body>

<?php
include('../conn/conn.php');

$customer_id = $_SESSION['customer_id'] ?? null; // Get logged-in customer ID
$notification = '';

if ($customer_id) {
    $stmt = $conn->prepare("SELECT customer_notification FROM tbl_orders 
                            WHERE cid = ? ORDER BY updated_at DESC LIMIT 1");
    $stmt->execute([$customer_id]);
    $notification = $stmt->fetchColumn();
}
?>
<!-- Notification Box -->
<div class="container mt-3">
    <?php if (isset($_SESSION['dashboard_notification'])): ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong>Notification:</strong> <?php echo $_SESSION['dashboard_notification']; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php unset($_SESSION['dashboard_notification']); ?>
    <?php endif; ?>
 
    <?php if (isset($_SESSION['notification'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($_SESSION['notification']); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php unset($_SESSION['notification']); // Clear the notification after displaying ?>
            <?php endif; ?>
</div>





  <!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand logo" href="#">UNICAFE</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Search Bar -->
        <form class="d-flex search-container me-auto" method="GET" action="">
            <input class="form-control" type="text" name="search" placeholder="Search for food..." value="<?php echo htmlspecialchars($searchQuery); ?>" required>
            <button class="btn btn-primary" type="submit">Search</button>
        </form>

        <!-- Right-side Items (Order Button + Profile) -->
        <div class="d-flex align-items-center">
            <!-- Order Button -->
            <a href="order.php" class="btn btn-success mx-3">Order Now</a>

            <!-- Profile Dropdown -->
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="profile.php" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="<?php echo $profilePicPath; ?>" alt="Profile Picture" class="rounded-circle" style="width: 32px; height: 32px;">
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="profile.php">View Profile</a>
                    <a class="dropdown-item" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>
</nav>



   <!-- Search Results Section -->
<?php if (!empty($searchQuery)): ?>
    <section class="restaurants">
        <h2>Search Results for "<?php echo htmlspecialchars($searchQuery); ?>"</h2>
        <div class="restaurant-list">
            <?php
            $query = "SELECT * FROM tbl_addfood WHERE food_name LIKE :search OR description LIKE :search ORDER BY f_id DESC";
            $stmt = $conn->prepare($query);
            $stmt->execute([':search' => "%$searchQuery%"]);

            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $imagePath = "uploads/" . htmlspecialchars($row['image']);
                    if (!file_exists($imagePath) || empty($row['image'])) {
                        $imagePath = "/Grabandgo/final-project-grab-go/Restaurant/uploads/" . htmlspecialchars($row['image']);   
                    }
                    ?>
                    <div class="restaurant" data-toggle="modal" data-target="#foodModal" 
                         data-name="<?php echo htmlspecialchars($row['food_name']); ?>" 
                         data-category="<?php echo htmlspecialchars($row['category']); ?>" 
                         data-description="<?php echo htmlspecialchars($row['description']); ?>" 
                         data-price="RS <?php echo htmlspecialchars($row['price']); ?>" 
                         data-image="<?php echo $imagePath; ?>">
                        <img src="<?php echo $imagePath; ?>" alt="<?php echo htmlspecialchars($row['food_name']); ?>" class="circle-img">
                        <div class="restaurant-info">
                            <h3><?php echo htmlspecialchars($row['food_name']); ?></h3>
                            <p>Category: <?php echo htmlspecialchars($row['category']); ?></p>
                            <p class="description"><?php echo htmlspecialchars($row['description']); ?></p>
                            <p class="price">Price: RS <?php echo htmlspecialchars($row['price']); ?></p>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<p>No matching food items found.</p>';
            }
            ?>
        </div>
    </section>
<?php endif; ?>

<?php
include('../conn/conn.php');

// Debugging: Print session variables (REMOVE in production)
if (isset($_GET['debug'])) {
    echo "<pre>";
    var_dump($_SESSION);
    echo "</pre>";
}

// ✅ Check if user is logged in
$customer_id = $_SESSION['customer_id'] ?? null;

$customerFirstName = '';
$customerLastName = '';
$customerPhone = '';

// ✅ Fetch customer details securely
if ($customer_id !== null) {
    $sql = "SELECT first_name, last_name, contact_number FROM tbl_otp WHERE tbl_user_id = :customer_id LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
    $stmt->execute();
    $customer = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($customer) {
        $customerFirstName = htmlspecialchars($customer['first_name']);
        $customerLastName = htmlspecialchars($customer['last_name']);
        $customerPhone = htmlspecialchars($customer['contact_number']);
    }
}

// Fetch latest customer notification
$notification = null;
if ($customer_id !== null) {
    $sql = "SELECT customer_notification FROM tbl_orders 
            WHERE cid = :customer_id ORDER BY updated_at DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
    $stmt->execute();
    $notification = $stmt->fetchColumn();
}



// ✅ Fetch food items from database
$query = "SELECT * FROM tbl_addfood ORDER BY f_id DESC";
$stmt = $conn->prepare($query);
$stmt->execute();

// ✅ Fetch QR Code (if applicable)
$sql = "SELECT qr_path FROM tbl_qr WHERE q_id = 1"; 
$stmt_qr = $conn->prepare($sql);
$stmt_qr->execute();
$row_qr = $stmt_qr->fetch(PDO::FETCH_ASSOC);
$qr_path = $row_qr['qr_path'] ?? '';


?>

<!-- ✅ Food Items Section -->
<section class="restaurants">
    <h2>Order Food Online Near You</h2>
    <div class="restaurant-list">
        <?php if ($stmt->rowCount() > 0): ?>
            <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                <?php
                $imagePath = "uploads/" . htmlspecialchars($row['image']);
                if (!file_exists($imagePath) || empty($row['image'])) {
                    $imagePath = "/Grabandgo/final-project-grab-go/Restaurant/uploads/" . htmlspecialchars($row['image']);
                }

                $availabilityClass = (strtolower($row['availability']) === 'available') ? 'available' : 'unavailable';
                $isAvailable = strtolower($row['availability']) === 'available';
                ?>
                
                <div class="restaurant <?php echo !$isAvailable ? 'disabled' : ''; ?>" 
                     data-toggle="<?php echo $isAvailable ? 'modal' : ''; ?>" 
                     data-target="<?php echo $isAvailable ? '#foodModal' : ''; ?>" 
                     data-name="<?php echo htmlspecialchars($row['food_name']); ?>" 
                     data-category="<?php echo htmlspecialchars($row['category']); ?>" 
                     data-description="<?php echo htmlspecialchars($row['description']); ?>" 
                     data-price="RS <?php echo htmlspecialchars($row['price']); ?>" 
                     data-image="<?php echo $imagePath; ?>"
                     style="<?php echo !$isAvailable ? 'pointer-events: none; opacity: 0.5;' : ''; ?>">
                    
                    <img src="<?php echo $imagePath; ?>" alt="<?php echo htmlspecialchars($row['food_name']); ?>" class="circle-img">
                    
                    <div class="restaurant-info">
                        <h3><?php echo htmlspecialchars($row['food_name']); ?></h3>
                        <p>Category: <?php echo htmlspecialchars($row['category']); ?></p>
                        <p class="description"><?php echo htmlspecialchars($row['description']); ?></p>
                        <p class="price">Price: RS <?php echo htmlspecialchars($row['price']); ?></p>
                        <p class="availability <?php echo $availabilityClass; ?>">Status: <?php echo htmlspecialchars($row['availability']); ?></p>

                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No food items available at the moment. Please check back later!</p>
        <?php endif; ?>
    </div>
</section>



    <!-- Food Details Modal -->
    <div class="modal fade" id="foodModal" tabindex="-1" role="dialog" aria-labelledby="foodModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="foodModalLabel">Food Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img id="modalFoodImage" src="" alt="Food Image" class="img-fluid mb-3">
                    <p><strong>Name:</strong> <span id="modalFoodName"></span></p>
                    <p><strong>Category:</strong> <span id="modalFoodCategory"></span></p>
                    <p><strong>Description:</strong> <span id="modalFoodDescription"></span></p>
                    <p><strong>Price:</strong> <span id="modalFoodPrice"></span></p>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#orderModal">Order</button>
                </div>
                 <!-- Comment Section -->
<div class="modal-footer">
    <div class="comment-box">
        <h3>Leave a Comment</h3>
        <textarea id="commentText" placeholder="Write your comment here..." required></textarea>
        <button onclick="submitComment()">Submit</button>
        <div id="commentsSection"></div>
    </div>
</div>
                </div>
            </div>
        </div>
    </div>

     <!-- ✅ Display Session Message -->
<?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <?php
        echo $_SESSION['message'];
        unset($_SESSION['message']); // Clear message after displaying
        ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>


<!-- ✅ Order Modal -->
<div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderModalLabel">Place Your Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="orderForm" method="POST" action="">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] ?? ''; ?>">

                    <div class="mb-3">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" id="name" name="name" class="form-control"
                               value="<?php echo $customerFirstName . ' ' . $customerLastName; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number:</label>
                        <input type="tel" id="phone" name="phone" class="form-control"
                               value="<?php echo $customerPhone; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity:</label>
                        <input type="number" id="quantity" name="quantity" class="form-control" value="1" min="1" required>
                    </div>

                    <div class="mb-3">
                        <label for="fooddescription" class="form-label">Food Description:</label>
                        <textarea id="fooddescription" name="fooddescription" class="form-control" rows="2" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="time" class="form-label">Preferred Time:</label>
                        <input type="time" id="time" name="time" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Payment Method:</label><br>
                        <input type="radio" id="cash" name="paymentMethod" value="cash" required>
                        <label for="cash">Cash</label><br>

                        <input type="radio" id="online" name="paymentMethod" value="online" required>
                        <label for="online">Online Payment</label>

                        <button type="button" id="payOnlineBtn" class="btn btn-success mt-2" style="display: none;">Pay Online</button>
                    </div>

                    <!-- QR Code Display -->
                    
                    <div id="qrCodeContainer" class="mt-4" style="display: none;">
    <p><strong>Scan this QR Code to Pay:</strong></p>
    <?php if (!empty($qr_path)): ?>
        <img id="qrCodeImage" src="/Grabandgo/final-project-grab-go/Restaurant/<?php echo htmlspecialchars($qr_path); ?>" alt="Scan this QR code to pay" class="img-fluid" style="max-width: 300px; height: auto;">

    <?php else: ?>
        <p>No QR Code Available</p>
    <?php endif; ?>
</div>


                    <button type="submit" class="btn btn-primary mt-3">Submit Order</button>
                </form>
            </div>
        </div>
    </div>
</div>





    <!-- Footer -->
    <footer>
        <p>&copy; 2025 UniCafe. All Rights Reserved.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.restaurant').on('click', function() {
                $('#modalFoodName').text($(this).data('name'));
                $('#modalFoodCategory').text($(this).data('category'));
                $('#modalFoodDescription').text($(this).data('description'));
                $('#modalFoodPrice').text($(this).data('price'));
                $('#modalFoodImage').attr('src', $(this).data('image'));
            });
        });
        document.addEventListener('DOMContentLoaded', function () {
    const onlinePaymentRadio = document.getElementById('online');
    const cashPaymentRadio = document.getElementById('cash');
    const payOnlineBtn = document.getElementById('payOnlineBtn');
    const qrCodeContainer = document.getElementById('qrCodeContainer');

    function togglePaymentElements() {
        if (onlinePaymentRadio.checked) {
            payOnlineBtn.style.display = 'block';
            qrCodeContainer.style.display = 'block';
        } else {
            payOnlineBtn.style.display = 'none';
            qrCodeContainer.style.display = 'none';
        }
    }

    togglePaymentElements(); // Call on load
    onlinePaymentRadio.addEventListener('change', togglePaymentElements);
    cashPaymentRadio.addEventListener('change', togglePaymentElements);
});
function fetchNotification() {
        $.ajax({
            url: "fetch_notification.php",
            method: "GET",
            dataType: "json",
            success: function(data) {
                if (data.notification) {
                    $("#notificationBox").html(`
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <strong>Notification:</strong> ${data.notification}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `);
                }
            }
        });
    }
    setInterval(fetchNotification, 5000);
    
    function submitComment() {
    let commentText = document.getElementById("commentText").value.trim();
    let foodId = document.getElementById("foodModal").getAttribute("data-food-id");

    if (!foodId || commentText === "") {
        alert("Please enter a comment.");
        return;
    }

    fetch('comment_system.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ f_id: foodId, comment: commentText })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Comment submitted successfully!");
            document.getElementById("commentText").value = "";
        } else {
            alert("Error: " + data.error);
        }
    })
    .catch(error => {
        alert("Request failed: " + error);
    });
}

    </script>
</body>
</html>