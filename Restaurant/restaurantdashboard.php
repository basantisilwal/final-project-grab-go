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
      <img src="logo.png" alt="Blue Sky Summer">
    </div>
    <div class="profile">
      <img src="profile.jpg" alt="Profile Picture">
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
      <h1>Welcome, Diamon Restro</h1>
      <button onclick="updateProfile()">Update Profile</button>
    </div>
    <div class="dashboard-cards">
      <div class="card">
        <h2>1</h2>
        <p>Unread Messages</p>
        <button onclick="showMessages()">See Messages</button>
      </div>
      <div class="card">
        <h2>8</h2>
        <p>Products Added</p>
      </div>
      <div class="card">
        <h2>8</h2>
        <p>Total Active Products</p>
      </div>
    </div>
  </div>

  <script src="script.js"></script>
</body>
</html>
