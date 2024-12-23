<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="rstyle.css">
    <title>Restaurant Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      display: flex;
    }
       body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f9f9f9;
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

.main-content {
    flex: 1;
    display: flex;
    justify-content: flex-end; /* Align the panel to the right */
    padding: 1px; /* Add padding for spacing */
}


    .dashboard-buttons {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
    }

    .dashboard-buttons button {
      padding: 15px 20px;
      font-size: 1rem;
      color: #fff;
      background-color: #000;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .dashboard-buttons button:hover {
      background-color: #ff6700;
    }

    /* Footer Settings */
    .footer {
      margin-top: 20px;
      text-align: center;
      font-size: 0.9rem;
      color: #555;
    }
  </style>
</head>
<body>
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
    <a href="index.php">Logout</a>
    </aside>

  <!-- Main Content -->
  <div class="container">
    <div class="card">
        <h3>Orders Today</h3>
        <p>Completed: <span id="orders-completed">50</span></p>
        <p>Pending: <span id="orders-pending">12</span></p>
        <button onclick="updateOrders()">Refresh</button>
    </div>
    <div class="card">
        <h3>Reservations</h3>
        <p>Upcoming: <span id="reservations">24</span></p>
        <button onclick="refreshReservations()">View All</button>
    </div>
    <div class="card">
        <h3>Revenue</h3>
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
