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

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #f7e4a3;
            padding: 10px 20px;
        }

        .logo {
            font-size: 1.5em;
            font-weight: bold;
            color: #ff5722;
        }

        .location {
            font-size: 1em;
            color: #333;
        }

        .search input {
            padding: 5px;
            font-size: 1em;
            width: 250px;
        }

        .search button {
            padding: 5px 10px;
            font-size: 1em;
        }

        section.restaurants {
            padding: 20px;
            text-align: center;
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
<header>
    <div class="logo">GRAB & GO</div>
    <div class="location">Damauli, Tanahun</div>
    <div class="search">
        <!-- Notification Icon -->
        <div class="notification">
            <button id="notificationButton">
                <img src="path-to-notification-icon.png" alt="Notifications">
            </button>
        </div>
         <!-- Search Form -->
        <form method="GET" action="search.php">
            <input type="text" name="search" placeholder="Search for restaurant, cuisine or dish" id="searchBar">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>
</header>

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Retrieve form inputs
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $foodDescription = $_POST['foodDescription'];
        $quantity = intval($_POST['quantity']);
        $orderType = $_POST['orderType'];
        $address = $orderType === 'delivery' ? $_POST['address'] : null;
        $time = !empty($_POST['time']) ? $_POST['time'] : null;
        $paymentMethod = $_POST['paymentMethod'];

        // Prepare the SQL query
        $sql = "INSERT INTO tbl_order (name, phone, food_description, quantity, order_type, address, preferred_time, payment_method)
                VALUES (:name, :phone, :foodDescription, :quantity, :orderType, :address, :time, :paymentMethod)";
        
        // Prepare the statement
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

        echo "Order successfully placed!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request method.";
}
?>


<div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="form-container">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h1>Food Order</h1>
                    <form id="orderForm" method="POST" action="">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number:</label>
                            <input type="tel" id="phone" name="phone" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="foodDescription">Food Items:</label>
                            <textarea id="foodDescription" name="foodDescription" class="form-control" placeholder="Enter food item details" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity:</label>
                            <input type="number" id="quantity" name="quantity" class="form-control" value="1" min="1" max="100" required>
                        </div>
                        <div class="form-group">
                            <label for="orderType">Order Type:</label>
                            <select id="orderType" name="orderType" class="form-control" required>
                                <option value="pickup">Pickup</option>
                                <option value="delivery">Delivery</option>
                            </select>
                        </div>
                        <div class="form-group" id="addressGroup" style="display: none;">
                            <label for="address">Delivery Address:</label>
                            <textarea id="address" name="address" class="form-control" placeholder="Enter your address"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="time">Preferred Time:</label>
                            <input type="time" id="time" name="time" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="paymentMethod">Payment Method:</label>
                            <select id="paymentMethod" name="paymentMethod" class="form-control" required>
                                <option value="online">Online Payment</option>
                                <option value="cash">Cash on Delivery</option>
                            </select>
                        </div>
                        <div class="form-group" id="qrCodeContainer">
                            <label>Scan the QR Code to Pay:</label>
                            <img id="qrCodeImage" src="images/download.png" alt="QR Code">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit Order</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
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
    document.getElementById('orderType').addEventListener('change', function () {
        const addressGroup = document.getElementById('addressGroup');
        addressGroup.style.display = this.value === 'delivery' ? 'block' : 'none';
    });

    // Handle form submission with AJAX
    const orderForm = document.getElementById("orderForm");
    orderForm.addEventListener("submit", function (e) {
        e.preventDefault(); // Prevent the default form submission

        const formData = new FormData(orderForm);

        fetch(orderForm.action, {
            method: "POST",
            body: formData,
        })
            .then((response) => response.text())
            .then((data) => {
                if (data.includes("Order successfully placed!")) {
                    alert("Order successfully placed!");
                    const orderModal = new bootstrap.Modal(document.getElementById("orderModal"));
                    orderModal.hide();
                    orderForm.reset();
                } else {
                    alert("An error occurred: " + data);
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                alert("An unexpected error occurred. Please try again.");
            });
    });

    // Show/hide QR Code container based on payment method
    document.getElementById('paymentMethod').addEventListener('change', function () {
        const qrCodeContainer = document.getElementById('qrCodeContainer');
        qrCodeContainer.style.display = this.value === 'online' ? 'block' : 'none';
    });

    // Show or hide address field based on order type
    const orderTypeField = document.getElementById("orderType");
    const addressGroup = document.getElementById("addressGroup");

    orderTypeField.addEventListener("change", function () {
        if (orderTypeField.value === "delivery") {
            addressGroup.style.display = "block";
        } else {
            addressGroup.style.display = "none";
        }
    });
    });
</script>
</body>
</html>
