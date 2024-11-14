
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
            font-size: 0.9rem;
        }
        .sidebar {
            height: 100vh;
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        .sidebar .nav-link {
            color: #333;
            padding: 0.5rem 1rem;
        }
        .sidebar .nav-link:hover {
            background-color: #e9ecef;
        }
        .sidebar .nav-link.active {
            background-color: #0d6efd;
            color: white;
        }
        .main-content {
            padding: 15px;
        }
    </style>
</head>
<body>
<div class="main-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Restaurant Dashboard</h2>
            </div>
            <ul class="sidebar-menu">
            <a href="restaurantdashboard.php" class="nav-link active">Dashboard</a>
      <a href="addfood.php" class="nav-link"> Add Food</a>
      <a href="updateprofile.php" class="nav-link">Update profile</a>
      <a href="viewfood.php" class="nav-link">View Food </a>
      <a href="account.php" class="nav-link"> Accounts</a>
      <a href="index.php" class="nav-link">  Logout </a>
            </ul>
        </aside>
    </div>

  <div class="main-content">
    <div class="header">
      <h2>Welcome, Diamon Restro</h2>
      <button onclick="updateProfile()">Update Profile</button>
    </div>
    <div class="dashboard-cards">
      <div class="card">
        <h2>0</h2>
        <p>Unread Messages</p>
        <button onclick="showMessages()">See Messages</button>
      </div>
      <div class="card">
        <h2>0</h2>
        <p>Product Added</p>
        <button onclick="showMessages()">Add new Food</button>
      </div><br>
      <div class="card">
        <h2>0</h2>
        <p>Total Active Food</p>
        <button onclick="showMessages()">See Food</button>
      </div>
      <div class="card">
        <h2>0</h2>
        <p>Total Deactive Food</p>
        <button onclick="showMessages()">See Food</button>
      </div><br>
      <div class="card">
        <h2>0</h2>
        <p>User Account</p>
        <button onclick="showMessages()">See Users</button>
      </div>
      <div class="card">
        <h2>0</h2>
        <p>Admin Account</p>
        <button onclick="showMessages()">See Admin</button>
      </div><br>
      <div class="card">
        <h2>0</h2>
        <p>Total canceled orders</p>
        <button onclick="showMessages()">Canceled Orders</button>
      </div>
     
      <div class="card">
        <h2>0</h2>
        <p>Total Confirm Orders</p>
        <button onclick="showMessages()">Confirm orders</button>
      </div><br>
      <div class="card">
        <h2>0</h2>
        <p>Total Orders</p>
        <button onclick="showMessages()">All orders</button>
      </div>
      
    </div>
  </div>

  <script src="script.js"></script>
</body>
</html>
