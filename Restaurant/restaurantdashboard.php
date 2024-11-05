<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="rstyle.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</head>
</head>
<body>
<div class="main-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Dashboard</h2>
            </div>
            <ul class="sidebar-menu">
            <li><a href="pandingfoodorder.php">Panding</a></li>
                <li><a href="managefoodmenu.php">Menu</a></li>
                <li><a href="restaurantdashboard.php">Viewr</a></li>
                <li><a href="setting.php">Setting</a></li>
            </ul>
        </aside>


        <div class="main-content">
            <div class="header">
                <h1>Restaurant Dashboard</h1>
            </div>
            <div class="background-img">
                <img src="path/to/your/background.jpg" alt="Food Background">
            </div>
            <div class="buttons">
                <button onclick="showPendingOrders()">Pending food orders</button>
                <button onclick="showAlert('Manage food menu')">Manage food menu</button>
                <button onclick="showAlert('Manage payment')">Manage payment</button>
                <button onclick="showAlert('Give Token ID')">Give Token ID</button>
            </div>
        </div>
    </div>

    <!-- Hidden Pending Orders Section -->
    <div class="modal hidden" id="pendingOrdersModal">
        <div class="modal-content">
            <h2>Pending Orders</h2>
            <ul>
                <li>Order #1 - Pizza</li>
                <li>Order #2 - Burger</li>
                <li>Order #3 - Pasta</li>
            </ul>
            <button onclick="hidePendingOrders()">Close</button>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>