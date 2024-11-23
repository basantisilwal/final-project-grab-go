<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dispatcher Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        header {
            background-color: #007bff;
            color: white;
            padding: 1rem;
            text-align: center;
        }
        main {
            padding: 20px;
        }
        .card {
            background: white;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .card h2 {
            margin-top: 0;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        select, button {
            padding: 10px;
            width: 100%;
            font-size: 16px;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .success, .error {
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <header>
        <h1>Dispatcher Panel</h1>
    </header>
    <main>
        <div class="card">
            <h2>Order Details</h2>
            <p><strong>Order ID:</strong> <span id="order-id">12345</span></p>
            <p><strong>Token ID:</strong> <span id="token-id">TOK123</span></p>
            <p><strong>Customer Name:</strong> <span id="customer-name">Krishna</span></p>
            <p><strong>Address:</strong> <span id="address">vyas:2 damauli</span></p>
            <p><strong>Status:</strong> <span id="order-status">Pending</span></p>
        </div>

        <div class="card">
            <h2>Update Order Status</h2>
            <div class="form-group">
                <label for="status">Select Status:</label>
                <select id="status">
                    <option value="Pending">Pending</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Delivered">Delivered</option>
                    <option value="Cancelled">Cancelled</option>
                </select>
            </div>
            <button onclick="updateStatus()">Update Status</button>
            <div id="status-message" class="success" style="display: none;"></div>
        </div>

        <div class="card">
            <h2>Assign Order</h2>
            <div class="form-group">
                <label for="delivery-person">Assign to Delivery Person:</label>
                <select id="delivery-person">
                    <option value="1">Ankit</option>
                    <option value="2">Ashim</option>
                </select>
            </div>
            <button onclick="assignOrder()">Assign Order</button>
            <div id="assign-message" class="success" style="display: none;"></div>
        </div>
    </main>

    <script>
        // Mock data for the example
        const orderData = {
            tokenId: "TOK123",
            status: "Pending",
            customerName: "krishna",
            address: "vyas:2 damauli",
        };

        // Mock APIs for interactivity
        async function updateStatus() {
            const status = document.getElementById("status").value;
            // Simulate an API call
            const response = await new Promise((resolve) =>
                setTimeout(() => resolve({ success: true, status }), 1000)
            );

            if (response.success) {
                document.getElementById("order-status").textContent = response.status;
                const messageBox = document.getElementById("status-message");
                messageBox.textContent = "Order status updated successfully!";
                messageBox.style.display = "block";
            }
        }

        async function assignOrder() {
            const deliveryPersonId = document.getElementById("delivery-person").value;
            const deliveryPersonName = document.querySelector(`#delivery-person option[value="${deliveryPersonId}"]`).textContent;

            // Simulate an API call
            const response = await new Promise((resolve) =>
                setTimeout(() => resolve({ success: true, deliveryPersonName }), 1000)
            );

            if (response.success) {
                const messageBox = document.getElementById("assign-message");
                messageBox.textContent = `Order assigned to ${response.deliveryPersonName}.`;
                messageBox.style.display = "block";
            }
        }
        const response = await fetch('/api/update-status', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ tokenId: orderData.tokenId, status })
});
const result = await response.json();

    </script>
</body>
</html>
