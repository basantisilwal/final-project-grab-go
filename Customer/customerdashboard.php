<?php
include('../conn/conn.php'); 
session_start();

// Generate CSRF token if not set
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Handle order submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['csrf_token'])) {
    if ($_POST['csrf_token'] === $_SESSION['csrf_token']) {
        // Get form data securely
        $name = htmlspecialchars($_POST['name']);
        $phone = htmlspecialchars($_POST['phone']);
        $foodDescription = htmlspecialchars($_POST['foodDescription']);
        $quantity = (int)$_POST['quantity'];
        $preferred_time = $_POST['time'];
        $paymentMethod = $_POST['paymentMethod'];
        $status = "Pending";
        $c_id = $_SESSION['c_id'] ?? null;

        // Check stock availability
        $query = "SELECT stock FROM tbl_addfood WHERE food_name = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$foodDescription]);
        $food = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($food && $food['stock'] >= $quantity) {
            // Insert order into database
            $sql = "INSERT INTO tbl_orders (c_id, name, phone, food_description, quantity, preferred_time, payment_method, status) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt->execute([$c_id, $name, $phone, $foodDescription, $quantity, $preferred_time, $paymentMethod, $status])) {
                // Reduce stock
                $updateStock = "UPDATE tbl_addfood SET stock = stock - ? WHERE food_name = ?";
                $stmt = $conn->prepare($updateStock);
                $stmt->execute([$quantity, $foodDescription]);
                $_SESSION['message'] = "Order placed successfully!";
            } else {
                $_SESSION['message'] = "Error placing order. Please try again.";
            }
        } else {
            $_SESSION['message'] = "Sorry, this item is out of stock!";
        }
    } else {
        $_SESSION['message'] = "Invalid CSRF token!";
    }
}

// Fetch Customer Notifications
$customer_id = $_SESSION['c_id'] ?? null;
if ($customer_id) {
    $sql = "SELECT customer_notification FROM tbl_orders WHERE c_id = ? ORDER BY id DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$customer_id]);
    $notification = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grab & Go</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">GRAB & GO</a>
            <form class="d-flex search-container" method="GET" action="search.php">
                <input class="form-control me-2" type="text" name="search" placeholder="Search for restaurant, cuisine or dish">
                <button class="btn btn-outline-primary" type="submit">Search</button>
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

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $imagePath = "uploads/" . htmlspecialchars($row['image']);
                if (!file_exists($imagePath) || empty($row['image'])) {
                    $imagePath = "/Grabandgo/final-project-grab-go/Restaurant/uploads/" . htmlspecialchars($row['image']);   
                }
            ?>
            <div class="restaurant <?php echo ($row['stock'] == 0) ? 'out-of-stock' : ''; ?>" 
                 data-toggle="modal" data-target="#foodModal"
                 data-name="<?php echo htmlspecialchars($row['food_name']); ?>" 
                 data-category="<?php echo htmlspecialchars($row['category']); ?>" 
                 data-description="<?php echo htmlspecialchars($row['description']); ?>" 
                 data-price="RS <?php echo htmlspecialchars($row['price']); ?>" 
                 data-image="<?php echo $imagePath; ?>">
                
                <img src="<?php echo $imagePath; ?>" alt="<?php echo htmlspecialchars($row['food_name']); ?>" class="circle-img">
                <div class="restaurant-info">
                    <h3><?php echo htmlspecialchars($row['food_name']); ?></h3>
                    <p>Category: <?php echo htmlspecialchars($row['category']); ?></p>
                    <p class="description"> <?php echo htmlspecialchars($row['description']); ?> </p>
                    <p class="price">Price: RS <?php echo htmlspecialchars($row['price']); ?></p>
                </div>
            </div>
            <?php } ?>
        </div>
    </section>

    <footer>
        <p>&copy; 2025 Grab & Go. All Rights Reserved.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.restaurant').on('click', function() {
                $('#foodModalLabel').text($(this).data('name'));
                $('#modalFoodCategory').text($(this).data('category'));
                $('#modalFoodDescription').text($(this).data('description'));
                $('#modalFoodPrice').text($(this).data('price'));
                $('#modalFoodImage').attr('src', $(this).data('image'));
            });
        });
    </script>
</body>
</html>
