<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            background-color: #FFE0B2;
        }

        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, #f7b733, #fc4a1a); /* Gradient Background */
            color: #fff;
            height: 100vh;
            display: flex;
            flex-direction: column;
            padding: 20px;
            position: fixed;
            top: 0;
            left: 0;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.2); /* Soft shadow for depth */
        }

        .sidebar h2 {
            font-size: 1.4rem;
            font-weight: bold;
            margin-bottom: 20px;
            text-transform: uppercase;
            text-align: center;
            letter-spacing: 1px;
        }

        .sidebar a {
            color: #000;
            text-decoration: none;
            padding: 12px 15px;
            border-radius: 5px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            font-size: 1.1rem;
            transition: all 0.3s ease-in-out;
            font-weight: 500;
        }

        .sidebar a:hover {
            background: #000; /* Semi-transparent hover effect */
            color: #fff;
            transform: translateX(5px); /* Subtle movement effect */
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
        background-color: #FFE0B2;
        border-radius: 5px;
        padding: 15px;
        color: #000;
        width: 100%; /* Decrease the size */
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
        background-color:rgb(0, 1, 3);
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 8px 12px;
        cursor: pointer;
        font-size: 0.9rem; /* Adjust button size */
    }

    .content button:hover {
        background-color:rgb(0, 5, 9);
    }
    </style>
</head>
<body>
    <aside class="sidebar">
        <h2>Restaurant Dashboard</h2>

        <a href="das.php"><i class="fas fa-home"></i> Dashboard</a>
            <a href="addfood.php"><i class="fas fa-utensils"></i> Add Food</a>
            <a href="viewfood.php"><i class="fas fa-list"></i> View Food</a>
            <a href="vieworder.php"><i class="fas fa-shopping-cart"></i> View Order</a>
            <a href="managepayment.php"><i class="fas fa-money-bill"></i> View Payment</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>

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
