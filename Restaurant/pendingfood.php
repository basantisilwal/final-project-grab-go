<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Food Orders</title>
    <style>
        /* General styles */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        body { background-color: #f4f4f9; color: #333; line-height: 1.6; }
        .container { max-width: 900px; margin: 20px auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
        header { text-align: center; margin-bottom: 20px; }
        header h1 { font-size: 2.5rem; color: #444; }
        .order-section { margin-bottom: 20px; }
        .order-section h2 { font-size: 1.8rem; margin-bottom: 10px; }
        ul { list-style: none; padding: 0; }
        ul li { background: #f8f9fa; padding: 15px; margin-bottom: 15px; border-radius: 8px; border: 1px solid #ddd; }
        ul li strong { display: block; font-size: 1.1rem; margin-bottom: 5px; }
        ul li .details { font-size: 0.9rem; margin: 5px 0; color: #555; }
        ul li button { margin: 5px; padding: 8px 12px; font-size: 0.9rem; border: none; border-radius: 4px; cursor: pointer; }
        ul li .complete { background-color: #28a745; color: white; }
        ul li .cancel { background-color: #dc3545; color: white; }
        ul li button:hover { opacity: 0.9; }
        .add-order { padding: 15px; background: #f4f9ff; border: 1px solid #ddd; border-radius: 8px; margin-top: 20px; }
        .add-order input, .add-order button { width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px; }
        .add-order button { background: #007bff; color: white; border: none; cursor: pointer; }
        .add-order button:hover { background: #0056b3; }
        footer { text-align: center; margin-top: 20px; font-size: 0.9rem; color: #888; }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Pending Food Orders</h1>
        </header>

        <div class="order-section">
            <h2>Current Orders</h2>
            <ul id="orders">
                <!-- Orders will be dynamically added here -->
            </ul>
        </div>

        <div class="add-order">
            <h2>Add New Order</h2>
            <input type="text" id="foodName" placeholder="Food Name" />
            <input type="text" id="customerName" placeholder="Customer Name" />
            <input type="text" id="address" placeholder="Delivery Address" />
            <button id="addOrderBtn">Add Order</button>
        </div>

        <footer>
            <p>© 2024 Online Food Delivery System</p>
        </footer>
    </div>

    <script>
        const ordersList = document.getElementById('orders');
        const addOrderBtn = document.getElementById('addOrderBtn');
        const foodNameInput = document.getElementById('foodName');
        const customerNameInput = document.getElementById('customerName');
        const addressInput = document.getElementById('address');

        // Store orders
        const orders = [];

        // Function to render the order list
        const renderOrders = () => {
            ordersList.innerHTML = '';
            if (orders.length === 0) {
                ordersList.innerHTML = '<li style="text-align: center; background: #eef;">No pending orders!</li>';
                return;
            }

            orders.forEach((order) => {
                const li = document.createElement('li');
                li.innerHTML = `
                    <strong>${order.food} - ${order.customer}</strong>
                    <p class="details">Delivery Address: ${order.address}</p>
                    <p class="details">Added at: ${order.timestamp}</p>
                    <button class="complete" onclick="completeOrder(${order.id})">Complete</button>
                    <button class="cancel" onclick="cancelOrder(${order.id})">Cancel</button>
                `;
                ordersList.appendChild(li);
            });
        };

        // Add order
        addOrderBtn.addEventListener('click', () => {
            const foodName = foodNameInput.value.trim();
            const customerName = customerNameInput.value.trim();
            const address = addressInput.value.trim();

            if (!foodName || !customerName || !address) {
                alert('Please fill out all fields.');
                return;
            }

            const newOrder = {
                id: Date.now(),
                food: foodName,
                customer: customerName,
                address,
                timestamp: new Date().toLocaleTimeString(),
            };

            orders.push(newOrder);
            foodNameInput.value = '';
            customerNameInput.value = '';
            addressInput.value = '';
            renderOrders();
        });

        // Complete order
        const completeOrder = (id) => {
            const index = orders.findIndex((order) => order.id === id);
            if (index !== -1) {
                alert(`Order for ${orders[index].customer} completed.`);
                orders.splice(index, 1);
                renderOrders();
            }
        };

        // Cancel order
        const cancelOrder = (id) => {
            const index = orders.findIndex((order) => order.id === id);
            if (index !== -1) {
                alert(`Order for ${orders[index].customer} canceled.`);
                orders.splice(index, 1);
                renderOrders();
            }
        };

        // Initial render
        renderOrders();
    </script>
</body>
</html>
