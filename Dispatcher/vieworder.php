<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dispatcher Dashboard</title>
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f3f4f6;
            color: #333;
        }
        header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
        }
        header h1 {
            font-size: 1.8rem;
        }
        .dashboard {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .dashboard h2 {
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: #007bff;
        }
        .order-list {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .order-list th, .order-list td {
            text-align: left;
            padding: 10px;
            border: 1px solid #ddd;
        }
        .order-list th {
            background-color: #007bff;
            color: white;
        }
        .order-list tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .order-actions {
            display: flex;
            gap: 10px;
        }
        .action-btn {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9rem;
        }
        .btn-assign {
            background-color: #28a745;
            color: white;
        }
        .btn-status {
            background-color: #ffc107;
            color: black;
        }
        .btn-assign:hover {
            background-color: #218838;
        }
        .btn-status:hover {
            background-color: #e0a800;
        }
    </style>
</head>
<body>
    <header>
        <h1>Dispatcher Dashboard</h1>
    </header>
    <div class="dashboard">
        <h2>Order Management</h2>
        <table class="order-list">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Token ID</th>
                    <th>Customer</th>
                    <th>Address</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="order-table-body">
                <!-- Orders will be dynamically loaded here -->
            </tbody>
        </table>
    </div>

    <!-- JavaScript for Interactivity -->
    <script>
        // Sample Order Data
        const orders = [
            {
                id: "1001",
                tokenId: "TOK101",
                customerName: "John Doe",
                address: "123 Elm Street",
                status: "Pending"
            },
            {
                id: "1002",
                tokenId: "TOK102",
                customerName: "Jane Smith",
                address: "456 Oak Avenue",
                status: "In Progress"
            },
            {
                id: "1003",
                tokenId: "TOK103",
                customerName: "Mike Johnson",
                address: "789 Pine Lane",
                status: "Delivered"
            }
        ];

        // Function to render the order table
        function renderOrders() {
            const tableBody = document.getElementById('order-table-body');
            tableBody.innerHTML = ""; // Clear table before re-rendering

            orders.forEach(order => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${order.id}</td>
                    <td>${order.tokenId}</td>
                    <td>${order.customerName}</td>
                    <td>${order.address}</td>
                    <td>${order.status}</td>
                    <td>
                        <div class="order-actions">
                            <button class="action-btn btn-assign" onclick="assignOrder('${order.id}')">Assign</button>
                            <button class="action-btn btn-status" onclick="updateStatus('${order.id}')">Update Status</button>
                        </div>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }

        // Function to handle Assign Order action
        function assignOrder(orderId) {
            alert(`Assigning order ID: ${orderId}`);
            // You can integrate API calls here to assign an order dynamically
        }

        // Function to handle Update Status action
        function updateStatus(orderId) {
            const newStatus = prompt("Enter new status for Order ID " + orderId + ":");
            if (newStatus) {
                const order = orders.find(o => o.id === orderId);
                if (order) {
                    order.status = newStatus;
                    renderOrders(); // Re-render orders to reflect changes
                    alert(`Order ID ${orderId} status updated to ${newStatus}`);
                }
            }
        }

        // Initial Render of Orders
        renderOrders();
    </script>
</body>
</html>
