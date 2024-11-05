
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
<div class="main-container">
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

   <!-- Main Form -->
   <div class="form-container">
    <section class= "form">
            <form action="#" method="post">
                <h2>Restaurant Registration</h2>
                
                <div class="form-group">
                    <input type="text" id="restaurant-name" name="restaurant-name" required>
                    <label for="restaurant-name">Restaurant Name:</label>
                </div>

                <div class="form-group">
                    <input type="text" id="address" name="address" required>
                    <label for="address">Address:</label>
                </div>

                <div class="form-group">
                    <input type="email" id="email" name="email" required>
                    <label for="email">Email:</label>
                </div>

                <div class="form-group">
                    <input type="text" id="contact" name="contact" required>
                    <label for="contact">Contact:</label>
                </div>

                

                <input type="submit" value="Register">

                <div class="button-group">
      <button type="button" onclick="goBack()">Back</button>
      <button type="button" onclick="deleteEntry()">Delete</button>
    </div>
            </form>
</section>
    <script src="script.js"></script>
</body>
</html>