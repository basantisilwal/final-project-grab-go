<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Dashboard</title>
    <link rel="stylesheet" href="rstyle.css">
</head>
<body>
    <div class="dashboard">
        <nav class="sidebar">
            <h2>Dashboard</h2>
            <ul>
                <li>My Project</li>
                <li>Data</li>
                <li>Statistics</li>
                <li>Team</li>
                <li>Saved</li>
                <li>Draft</li>
                <li>Trash</li>
            </ul>
        </nav>

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