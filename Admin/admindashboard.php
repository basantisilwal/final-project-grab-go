<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="astyle.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Admin Dashboard</h2>
                <input type="text" placeholder="Search" class="search-bar">
            </div>
            <ul class="sidebar-menu">
                <li><a href="#">Dashboard</a></li>
                <li><a href="#">My Project</a></li>
                <li><a href="#">Data</a></li>
                <li><a href="#">Statistics</a></li>
                <li><a href="#">Team</a></li>
                <li><a href="#">Saved</a></li>
                <li><a href="#">Draft</a></li>
                <li><a href="#">Trash</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="content">
            <section class="content-header">
                <h1>Admin Dashboard</h1>
            </section>
            <section class="management-buttons">
            <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#restaurantModal">Manage Restaurant</button>
                <button class="manage-btn">Food Menu</button>
                <button class="manage-btn">Manage Payment</button>
            </section>
            <section class="images">
                <img src="phone-food.jpg" alt="Food Image">
            </section>
        </main>
    </div>
    <!-- Manage Restaurant Modal -->
    <div class="modal fade" id="restaurantModal" tabindex="-1" aria-labelledby="restaurantModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="restaurantModalLabel">Manage Restaurant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body restaurant-container">
                    <section class="restaurant-management">
                        <h2>Restaurant Details Form</h2>

                        <!-- Display success or error messages -->
                        <?php if (isset($success_message)): ?>
                            <p class="success-message"><?php echo $success_message; ?></p>
                        <?php elseif (isset($error_message)): ?>
                            <p class="error-message"><?php echo $error_message; ?></p>
                        <?php endif; ?>

                        <!-- Form to input restaurant details -->
                        <form action="manage-restaurant.php" method="POST">
                            <div class="form-group">
                                <label for="restaurant-name">Restaurant Name:</label>
                                <input type="text" id="restaurant-name" name="restaurant_name" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Restaurant Email:</label>
                                <input type="email" id="email" name="restaurant_email" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="address">Restaurant Address:</label>
                                <input type="text" id="address" name="restaurant_address" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3">Save Details</button>
                        </form>
                    </section>
                </div>
            </div> 
        </div>
    </div> 



    <script src="script.js"></script>
</body>
</html>