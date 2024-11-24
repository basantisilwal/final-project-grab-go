<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Food Orders</title>
    <style>
        body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      display: flex;
    }

    /* Sidebar Styles */
    .sidebar {
      width: 250px;
      background-color: #000; /* Black background */
      color: #fff;
      height: 100vh;
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
