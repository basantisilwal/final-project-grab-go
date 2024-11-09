<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="rstyle.css">
</head>
<body>
  <div class="sidebar">
    <div class="logo">
      <img src="../images/logo.png" alt="Grab & Go">
    </div>
    <div class="profile">
      <img src="../images/buff momo image.jpg" alt="Profile Picture">
      <h2>Diamon Restro</h2>
    </div>
    <ul class="menu">
      <li><a href="#">Dashboard</a></li>
      <li><a href="#">Add Products</a></li>
      <li><a href="#">View Products</a></li>
      <li><a href="#">Accounts</a></li>
      <li><a href="#">Logout</a></li>
    </ul>
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
        <button onclick="showMessages()">Add new Products</button>
      </div>
      <div class="card">
        <h2>0</h2>
        <p>Total Active Products</p>
        <button onclick="showMessages()">See Products</button>
      </div>
      <div class="card">
        <h2>0</h2>
        <p>Total Deactive Products</p>
        <button onclick="showMessages()">See Products</button>
      </div>
      <div class="card">
        <h2>0</h2>
        <p>User Account</p>
        <button onclick="showMessages()">See Users</button>
      </div>
      <div class="card">
        <h2>0</h2>
        <p>Admin Account</p>
        <button onclick="showMessages()">See Admin</button>
      </div>
      <div class="card">
        <h2>0</h2>
        <p>Total canceled orders</p>
        <button onclick="showMessages()">Canceled Orders</button>
      </div>
     
      <div class="card">
        <h2>0</h2>
        <p>Total Confirm Orders</p>
        <button onclick="showMessages()">Confirm orders</button>
      </div>
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
