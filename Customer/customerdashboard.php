<?php include('../conn/conn.php'); ?>
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
        }
        .navbar {
        background-color: #f7e4a3; 
        color: #000; /* Text color */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .navbar .navbar-brand {
        color: #000/* Brand text color */
    }

    .navbar .navbar-brand:hover {
        color: #000;; /* Slightly lighter color on hover */
    }

    .navbar .form-control {
        background-color: #fff; /* White search bar */
        color: #000; /* Black text in search bar */
    }

    .btn-outline-primary {
        color: #000; /* White button text */
        border-color: #000; /* White border */
    }

    .btn-outline-primary:hover {
        background-color: white; /* White background on hover */
        color: #000; 
    }

    .navbar-toggler {
        border: 1px solid white; /* White border for toggler */
    }

    .navbar-toggler-icon {
        background-color: white; /* White toggler icon */
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

       

        footer {
            text-align: center;
            padding: 10px 0;
            background-color: #f7e4a3;
        }
    </style>
</head>
<body>
     <!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <!-- Logo Section -->
            <a class="navbar-brand logo" href="#">GRAB & GO</a>
            
            <!-- Toggler for small screens -->
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
<?php
include('../conn/conn.php'); // Database connection
?>

<section class="restaurants">
    <h2>Order Food Online Near You</h2>
    <div class="restaurant-list">
        <?php
        include('../conn/conn.php');
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
// Include the database connection file
include('../conn/conn.php');

// Generate CSRF Token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Handle form submission
$response = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // CSRF Token Validation
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Invalid CSRF token.");
    }

    try {
        // Retrieve form inputs
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $foodDescription = $_POST['foodDescription'];
        $quantity = intval($_POST['quantity']);
        $orderType = $_POST['orderType'];
        $address = $orderType === 'delivery' && !empty($_POST['address']) ? $_POST['address'] : null;
        $time = !empty($_POST['time']) ? $_POST['time'] : null;
        $paymentMethod = $_POST['paymentMethod'];

        // Prepare the SQL query
        $sql = "INSERT INTO tbl_order (name, phone, food_description, quantity, order_type, address, preferred_time, payment_method)
                VALUES (:name, :phone, :foodDescription, :quantity, :orderType, :address, :time, :paymentMethod)";
        
        $stmt = $conn->prepare($sql);

        // Bind parameters to the statement
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':foodDescription', $foodDescription);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':orderType', $orderType);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':time', $time);
        $stmt->bindParam(':paymentMethod', $paymentMethod);

        // Execute the statement
        $stmt->execute();
        $response = "Order successfully placed!";
    } catch (PDOException $e) {
        $response = "Error: " . $e->getMessage();
    }
}
?>


        <!-- Order Form Modal -->
    <?php if (!empty($response)): ?>
        <div class="alert alert-info"><?php echo htmlspecialchars($response); ?></div>
    <?php endif; ?>

    <!-- Order Form Modal -->
    <div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderModalLabel">Place Your Order</h5>
                    <button type="button" class="btn-close"  data-dismiss="modal" aria-label="Close"></button>
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
                            <input type="foodDescription" id="foodDescription" name="foodDescription" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity:</label>
                            <input type="number" id="quantity" name="quantity" class="form-control" value="1" min="1" max="100" step="1" required>
                        </div>
                        <div class="mb-3">
                            <label for="payment" class="form-label">Payment Method:</label>
                            <select id="payment" name="payment" class="form-control" required>
                                <option value="cash">Hand Cash</option>
                                <option value="online">Online Payment</option>
                            </select>
                        </div>
                        <div class="mb-3" id="qrCodeContainer" style="display: none;">
                        <label>Scan the QR Code to Pay:</label>
                        <img id="qrCodeImage" src="/images/download.png" alt="QR Code">
                        </div>
                        <div class="mb-3">
                            <label for="time" class="form-label">Preferred Time:</label>
                            <input type="time" id="time" name="time" class="form-control">
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Submit Order</button>
                            <button type="button" class="btn btn-secondary ms-2" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<footer>
    <p>&copy; 2024 Grab & Go</p>
</footer>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const modal = document.getElementById('foodModal');
         $('#foodModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget);
            document.getElementById('modalFoodName').textContent = button.data('name');
            document.getElementById('modalFoodCategory').textContent = button.data('category');
            document.getElementById('modalFoodDescription').textContent = button.data('description');
            document.getElementById('modalFoodPrice').textContent = button.data('price');
            document.getElementById('modalFoodImage').src = button.data('image');
        });

        document.getElementById('orderType').addEventListener('change', function () {
            const addressGroup = document.getElementById('addressGroup');
            addressGroup.style.display = this.value === 'delivery' ? 'block' : 'none';
        });

        document.getElementById('orderForm').addEventListener('submit', function (e) {
            const name = document.getElementById('name').value.trim();
            const phone = document.getElementById('phone').value.trim();

            if (!name || !phone) {
                alert('Please fill in all required fields.');
                e.preventDefault();
            }
        });
        document.addEventListener("DOMContentLoaded", function () {
            const paymentMethod = document.getElementById("paymentMethod");
            const qrCodeContainer = document.getElementById("qrCodeContainer");

            paymentMethod.addEventListener("change", function () {
                if (paymentMethod.value === "online") {
                    qrCodeContainer.style.display = "block"; // Show QR Code
                } else {
                    qrCodeContainer.style.display = "none"; // Hide QR Code
                }
            });

        });
        const openOrderFormButton = document.getElementById('openOrderForm');

        // Add click event listener
        openOrderFormButton.addEventListener('click', () => {
            // Hide the current modal (#foodModal)
            $('#foodModal').modal('hide');

            // Wait for the current modal to close, then show the order modal (#orderModal)
            $('#foodModal').on('hidden.bs.modal', () => {
                $('#orderModal').modal('show');
            });
        });
        const orderType = document.getElementById('orderType');
            const addressGroup = document.getElementById('addressGroup');
            const paymentMethod = document.getElementById('paymentMethod');
            const qrCodeContainer = document.getElementById('qrCodeContainer');

            // Show/hide delivery address field based on initial order type
            if (orderType.value === 'delivery') {
                addressGroup.style.display = 'block';
            }

            // Show/hide delivery address field when order type changes
            orderType.addEventListener('change', () => {
                addressGroup.style.display = orderType.value === 'delivery' ? 'block' : 'none';
            });

            // Show/hide QR code for online payment
            paymentMethod.addEventListener('change', () => {
                qrCodeContainer.style.display = paymentMethod.value === 'online' ? 'block' : 'none';
            });
            const orderForm = document.getElementById("orderForm");

    });
    $(document).ready(function () {
            // Handle form submission
            $('#orderForm').on('submit', function (e) {
                e.preventDefault(); // Prevent default form submission

                const formData = $(this).serialize(); // Serialize form data

                // Send AJAX request
                $.ajax({
                    url: '', // Submit to the same file
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        try {
                            const data = JSON.parse(response);
                            if (data.success) {
                                $('#successMessage').show();
                                $('#errorMessage').hide();
                                $('#orderForm')[0].reset(); // Reset form
                            } else {
                                $('#successMessage').hide();
                                $('#errorMessage').text(data.message).show();
                            }
                        } catch (e) {
                            $('#successMessage').hide();
                            $('#errorMessage').text("Error processing the request.").show();
                        }
                    },
                    error: function () {
                        $('#successMessage').hide();
                        $('#errorMessage').text("Error sending the request.").show();
                    }
                });
            });

        });
        document.addEventListener("DOMContentLoaded", function () {
        const payment = document.getElementById("payment");
        const qrCodeContainer = document.getElementById("qrCodeContainer");
        const qrCodeImage = document.getElementById("qrCodeImage");

        payment.addEventListener("change", function () {
            if (payment.value === "online") {
                qrCodeContainer.style.display = "block";
                qrCodeImage.src = "images/download.png"; // Ensure this path is correct
            } else {
                qrCodeContainer.style.display = "none";
            }
        });
    });
        
</script>
</body>
</html>
