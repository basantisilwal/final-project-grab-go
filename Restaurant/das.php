<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            background-color: #f8f9fa;
        }

        .sidebar {
            width: 250px;
            background-color: #000;
            color: #fff;
            height: 100vh;
            display: flex;
            flex-direction: column;
            padding: 20px 15px;
            position: fixed;
            top: 0;
            left: 0;
        }

        .sidebar h2 {
            font-size: 1.2rem;
            margin-bottom: 20px;
        }

        .sidebar a {
          color: #ff6700;
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

        .content-container {
        flex: 1;
        padding: 20px;
        background-color: #f8f9fa;
        display: flex;
        justify-content: center; /* Centers content horizontally */
        align-items: center;   /* Centers content vertically */
    }

    .content {
        background-color: #1a1a1a;
        border-radius: 5px;
        padding: 15px;
        color: #fff;
        width: 60%; /* Decrease the size */
        max-width: 600px; /* Limit the maximum size */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Add shadow for better aesthetics */
    }

    .content h3 {
        margin-bottom: 15px;
        font-size: 1.2rem; /* Adjust font size */
    }

    .content p {
        margin-bottom: 10px;
        font-size: 1rem; /* Adjust font size */
    }

    .content button {
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 8px 12px;
        cursor: pointer;
        font-size: 0.9rem; /* Adjust button size */
    }

    .content button:hover {
        background-color: #0056b3;
    }
    </style>
</head>
<body>
    <aside class="sidebar">
        <h2>Restaurant Dashboard</h2>
        <a href="das.php">Dashboard</a>
    <a href="addfood.php">Add Food</a>
    <a href="viewfood.php">View food</a>
    <a href="vieworder.php">View Order</a>
    <a href="managepayment.php">View payment</a>
    <a href="account.php">Account</a>
    <a href="updateprofile.php">Profile</a>
    <a href="#">Logout</a>
    </aside>

    <div class="content-container">
        <div class="content">
            <h3>Orders Today</h3>
            <p>Completed: <span id="orders-completed">50</span></p>
            <p>Pending: <span id="orders-pending">12</span></p>
            <button onclick="updateOrders()">Refresh</button>

            <h3 style="margin-top: 20px;">Reservations</h3>
            <p>Upcoming: <span id="reservations">24</span></p>
            <button onclick="refreshReservations()">View All</button>

            <h3 style="margin-top: 20px;">Revenue</h3>
            <p>Today: <span id="revenue">$1,245</span></p>
            <button onclick="refreshRevenue()">Update</button>
        </div>
    </div>

    <script>
        function updateOrders() {
            document.getElementById('orders-completed').innerText = Math.floor(Math.random() * 100);
            document.getElementById('orders-pending').innerText = Math.floor(Math.random() * 20);
            alert('Order data updated!');
        }

        function refreshReservations() {
            document.getElementById('reservations').innerText = Math.floor(Math.random() * 50);
            alert('Reservation data refreshed!');
        }

        function refreshRevenue() {
            document.getElementById('revenue').innerText = '$' + (Math.random() * 2000).toFixed(2);
            alert('Revenue updated!');
        }
    </script>
</body>
</html>
