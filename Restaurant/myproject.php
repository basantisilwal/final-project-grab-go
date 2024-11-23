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
        .container {
            max-width: 1200px;
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
            background-color: #555;
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
            background-color:#555;
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

    <script>
        // Mock Data for Orders and Menu
        const orders = [
            { orderId: "101", tokenId: "TOK101", status: "Preparing" },
            { orderId: "102", tokenId: "TOK102", status: "Ready for Pickup" },
        ];
        const menu = [];

        // View Current Orders
        function viewOrders() {
            const table = document.getElementById('order-table');
            const tableBody = document.getElementById('order-table-body');
            tableBody.innerHTML = ''; // Clear previous rows
            orders.forEach(order => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${order.orderId}</td>
                    <td>${order.tokenId}</td>
                    <td>${order.status}</td>
                    <td><button onclick="updateOrderStatus('${order.orderId}')">Update Status</button></td>
                `;
                tableBody.appendChild(row);
            });
            table.style.display = 'table'; // Show table
        }

        // Update Order Status
        function updateOrderStatus(orderId) {
            const newStatus = prompt(`Enter new status for Order ID ${orderId}:`);
            if (newStatus) {
                const order = orders.find(o => o.orderId === orderId);
                if (order) {
                    order.status = newStatus;
                    alert(`Order ID ${orderId} status updated to ${newStatus}`);
                    viewOrders(); // Refresh table
                }
            }
        }

        // Add Menu Item
        function addMenuItem() {
            const item = document.getElementById('menu-item').value;
            const price = document.getElementById('menu-price').value;
            if (item && price) {
                menu.push({ name: item, price: parseFloat(price) });
                renderMenu();
                document.getElementById('menu-form').reset();
            } else {
                alert("Please enter item and price.");
            }
        }

        // Render Menu
        function renderMenu() {
            const tableBody = document.getElementById('menu-table-body');
            tableBody.innerHTML = ''; // Clear previous rows
            menu.forEach((menuItem, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${menuItem.name}</td>
                    <td>${menuItem.price.toFixed(2)}</td>
                    <td><button onclick="deleteMenuItem(${index})">Delete</button></td>
                `;
                tableBody.appendChild(row);
            });
        }

        // Delete Menu Item
        function deleteMenuItem(index) {
            menu.splice(index, 1);
            renderMenu(); // Refresh menu table
        }

        // Send Notifications
        function sendNotifications() {
            const notification = document.getElementById('notification-message');
            notification.style.display = 'block';
            setTimeout(() => {
                notification.style.display = 'none';
            }, 2000);
        }
    </script>
</body>
</html>
