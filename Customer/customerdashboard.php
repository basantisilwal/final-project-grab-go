<?php
include('../conn/conn.php');
session_start();

// Generate CSRF token if not set
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Fetch Customer Notifications
$customer_id = $_SESSION['c_id'] ?? null;
$notification = "";
if ($customer_id) {
    $sql = "SELECT customer_notification FROM tbl_orders WHERE c_id = ? ORDER BY id DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$customer_id]);
    $notification = $stmt->fetchColumn();
}

// Fetch Food Items
$query = "SELECT * FROM tbl_addfood ORDER BY f_id DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$foodItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        <a class="navbar-brand logo" href="#">GRAB & GO</a>
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
        <?php foreach ($foodItems as $row): ?>
            <div class="restaurant <?php echo ($row['stock'] == 0) ? 'out-of-stock' : ''; ?>"
                data-toggle="modal" <?php echo ($row['stock'] == 0) ? '' : 'data-target="#foodModal"'; ?>
                data-name="<?php echo htmlspecialchars($row['food_name']); ?>"
                data-category="<?php echo htmlspecialchars($row['category']); ?>"
                data-description="<?php echo htmlspecialchars($row['description']); ?>"
                data-price="RS <?php echo htmlspecialchars($row['price']); ?>"
                data-image="uploads/<?php echo htmlspecialchars($row['image']); ?>">
                
                <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['food_name']); ?>" class="circle-img">
                <div class="restaurant-info">
                    <h3><?php echo htmlspecialchars($row['food_name']); ?></h3>
                    <p>Category: <?php echo htmlspecialchars($row['category']); ?></p>
                    <p class="description"> <?php echo htmlspecialchars($row['description']); ?></p>
                    <p class="price">Price: RS <?php echo htmlspecialchars($row['price']); ?></p>
                    <?php if ($row['stock'] == 0): ?>
                        <p class="text-danger">Out of Stock</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

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

<footer>
    <p>&copy; 2025 Grab & Go. All Rights Reserved.</p>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
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
