
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="astyle.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</head>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="astyle.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Admin Dashboard</h2>
            </div>
            <ul class="sidebar-menu">
                <li><a href="admindashboard.php">Dashboard</a></li>
                <li><a href="manage.php">Manage Restaurant</a></li>
                <li><a href="admindashboard.php">View Customer</a></li>
                <li><a href="setting.php">Setting</a></li>
            </ul>
        </aside>

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
                            <div class="mb-3">
                                <label for="restaurant-name" class="form-label">Restaurant Name:</label>
                                <input type="text" id="restaurant-name" name="restaurant_name" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Restaurant Email:</label>
                                <input type="email" id="email" name="restaurant_email" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Restaurant Address:</label>
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