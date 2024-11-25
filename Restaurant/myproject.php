<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }
        header {
            background-color: #555;
            color: white;
            text-align: center;
            padding: 20px;
        }

        /* Main Layout: Sidebar and Content */
        .main-layout {
            display: flex;
            height: 100vh; /* Full viewport height */
        }

        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background-color: #000; /* Black background */
            color: #fff;
            height: 100%;
            display: flex;
            flex-direction: column;
            padding: 20px 15px;
        }

        .sidebar h2 {
            font-size: 1.2rem;
            margin-bottom: 20px;
        }

        .sidebar a {
            color: #ff6700; /* Orange text */
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 10px;
            display: block;
            transition: background 0.3s;
        }

        .sidebar a:hover {
            background-color: #ff6700;
            color: #fff;
        }

        /* Main Content */
        .main-content {
            flex-grow: 1;
            padding: 20px;
            background-color: #f8f8f8;
            overflow-y: auto;
        }

        /* Container Styles */
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-bottom: 20px;
            color: #555;
        }

        .section {
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"], input[type="number"], select, button {
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            background-color: #555;
            color: white;
            cursor: pointer;
            border: none;
        }

        button:hover {
            background-color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #555;
            color: white;
        }

        .success {
            color: #155724;
            background-color: #d4edda;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
            display: none;
        }
    </style>
</head>
<body>
    <header>
        <h1>Restaurant Dashboard</h1>
    </header>

    <div class="main-layout">
        <!-- Sidebar -->
        <aside class="sidebar">
    <h2>Restaurant Dashboard</h2>
    <a href="das.php">Dashboard</a>
    <a href="myproject.php">My Project</a>
    <a href="addfood.php">Add Food</a>
    <a href="viewfood.php">View food</a>
    <a href="managepayment.php">View payment</a>
    <a href="account.php">Account</a>
    <a href="updateprofile.php">Profile</a>
    <a href="#">Logout</a>
    </aside>

        <!-- Main Content -->
        <div class="main-content">
            <div class="container">
                <!-- Section: Order Management -->
                <div class="section" id="order-management">
                    <h2>Order Management</h2>
                    <button onclick="viewOrders()">View Current Orders</button>
                    <table id="order-table" style="display: none;">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Token ID</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="order-table-body">
                            <!-- Orders will be dynamically loaded here -->
                        </tbody>
                    </table>
                </div>

                <!-- Section: Menu Management -->
                <div class="section" id="menu-management">
                    <h2>Menu Management</h2>
                    <form id="menu-form">
                        <div class="form-group">
                            <label for="menu-item">Menu Item</label>
                            <input type="text" id="menu-item" placeholder="Enter menu item">
                        </div>
                        <div class="form-group">
                            <label for="menu-price">Price</label>
                            <input type="number" id="menu-price" placeholder="Enter price">
                        </div>
                        <button type="button" onclick="addMenuItem()">Add Menu Item</button>
                    </form>
                    <table id="menu-table">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="menu-table-body">
                            <!-- Menu items will be dynamically loaded here -->
                        </tbody>
                    </table>
                </div>

                <!-- Section: Notifications -->
                <div class="section" id="notifications">
                    <h2>Notifications</h2>
                    <button onclick="sendNotifications()">Send Order Updates</button>
                    <div id="notification-message" class="success">Notifications sent to customers!</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Add your JavaScript functions here (unchanged from original)
    </script>
</body>
</html>
