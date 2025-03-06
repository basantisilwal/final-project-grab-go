<?php include('../conn/conn.php');
session_start(); // Start session for CSRF token and other session-based operations

// Generate CSRF token if not set
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Handle order submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['csrf_token'])) {
    if ($_POST['csrf_token'] === $_SESSION['csrf_token']) {
        // Get form data
        $name = htmlspecialchars($_POST['name']);
        $phone = htmlspecialchars($_POST['phone']);
        $foodDescription = htmlspecialchars($_POST['foodDescription']);
        $quantity = (int)$_POST['quantity'];
        $preferred_time = $_POST['time'];
        $paymentMethod = $_POST['paymentMethod'];
        $status = "Pending"; // Default status

        // Insert into database
        $sql = "INSERT INTO tbl_orders (name, phone, food_description, quantity, preferred_time, payment_method, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        if ($stmt->execute([$name, $phone, $foodDescription, $quantity, $preferred_time, $paymentMethod, $status])) {
            $_SESSION['message'] = "Order placed successfully!";
        } else {
            $_SESSION['message'] = "Error placing order. Please try again.";
        }
    } else {
        $_SESSION['message'] = "Invalid CSRF token!";
    }
}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grab & Go</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand logo" href="#">GRAB & GO</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <form class="d-flex search-container" method="GET" action="search.php">
                <input class="form-control me-2" type="text" name="search" placeholder="Search for restaurant, cuisine or dish" id="searchBar">
                <button class="btn btn-outline-primary" type="submit">Search</button>
                <img id="bell" src="../images/bell.png" alt="Notification Bell">
            </form>
        </div>
    </nav>

    <section class="restaurants">
        <h2>Order Food Online Near You</h2>
        <div class="restaurant-list">
            <?php
            $query = "SELECT * FROM tbl_addfood ORDER BY f_id DESC";
            $stmt = $conn->prepare($query);
            $stmt->execute();

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
                echo '<p>No food items available at the moment. Please check back later!</p>';
            }
            ?>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#orderModal">Order</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Form Modal -->
     
    <?php
include('../conn/conn.php');

$c_id = $_SESSION['c_id']; // Assuming session is used to identify customers

$sql = "SELECT customer_notification FROM tbl_orders WHERE c_id = :c_id ORDER BY c_id DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bindParam('c_id', $customer_id, PDO::PARAM_INT);
$stmt->execute();
$notification = $stmt->fetch(PDO::FETCH_ASSOC);

if ($notification && !empty($notification['customer_notification'])) {
    echo "<div class='alert alert-success'>" . htmlspecialchars($notification['customer_notification']) . "</div>";
}
?>


    <div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderModalLabel">Place Your Order</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="orderForm" method="POST" action="">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name:</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number:</label>
                            <input type="tel" id="phone" name="phone" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="foodDescription" class="form-label">Food Description:</label>
                            <textarea id="foodDescription" name="foodDescription" class="form-control" rows="2" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity:</label>
                            <input type="number" id="quantity" name="quantity" class="form-control" value="1" min="1" max="100" step="1" required>
                        </div>
                        <div class="mb-3">
                            <label for="time" class="form-label">Preferred Time:</label>
                            <input type="time" id="time" name="time" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="paymentMethod" class="form-label">Payment Method:</label>
                            <select id="paymentMethod" name="paymentMethod" class="form-control" required>
                                <option value="online">Online Payment</option>
                                <option value="cash">Cash on Delivery</option>
                            </select>
                        </div>
                        <div class="mb-3" id="qrCodeContainer">
                            <p>Scan QR Code to make Payment:</p>
                            <img id="qrCodeImage" src="" alt="QR Code">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Order</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Grab & Go. All Rights Reserved.</p>
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
                
       
    </script>
</body>
</html>
