<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Restaurant Management System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
      width: 220px;
      background: linear-gradient(135deg, #f7b733, #fc4a1a);
      color: #fff;
      height: 100vh;
      display: flex;
      flex-direction: column;
      padding: 15px;
      position: fixed;
      box-shadow: 3px 0 8px rgba(0, 0, 0, 0.2);
    }

    .sidebar h2 {
      font-size: 1.4rem;
      text-align: center;
      margin-bottom: 15px;
    }

    .sidebar a {
      color: #fff;
      text-decoration: none;
      padding: 10px;
      border-radius: 5px;
      margin-bottom: 8px;
      font-size: 1rem;
      transition: all 0.3s;
    }

    .sidebar a:hover {
      background: #000;
      color: #fff;
    }

    .main-content {
      margin-left: 240px;
      padding: 20px;
      flex: 1;
    }

    .container {
      background: white;
      padding: 15px;
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      max-width: 350px;
      margin: auto;
    }

    h1 {
      text-align: center;
      font-size: 20px;
      margin-bottom: 15px;
    }

    form input, form textarea, form button {
      width: 100%;
      margin-bottom: 10px;
      padding: 8px;
      border-radius: 4px;
      border: 1px solid #ccc;
    }

    button {
      background: #28a745;
      color: white;
      font-size: 14px;
      cursor: pointer;
      border: none;
    }

    button:hover {
      background: #218838;
    }
  </style>
</head>
<body>
  <aside class="sidebar">
    <h2>Dashboard</h2>
    <a href="das.php">Dashboard</a>
    <a href="addfood.php">Add Food</a>
    <a href="viewfood.php">View Food</a>
    <a href="vieworder.php">View Order</a>
    <a href="managepayment.php">View Payment</a>
    <a href="account.php">Account</a>
    <a href="updateprofile.php">Profile</a>
    <a href="logout.php">Logout</a>
  </aside>

  <div class="main-content">
    <div class="container">
      <h1>Update Profile</h1>
      <form id="updateProfileForm">
        <input type="text" id="restaurantName" placeholder="Restaurant Name" required>
        <input type="text" id="ownerName" placeholder="Owner's Name" required>
        <input type="tel" id="contactNumber" placeholder="Contact Number" required>
        <textarea id="address" rows="2" placeholder="Address" required></textarea>
        <button type="submit">Update Profile</button>
      </form>
      <div id="responseMessage" style="text-align:center; color:green; font-size:14px;"></div>
    </div>
  </div>

  <script>
    document.getElementById('updateProfileForm').addEventListener('submit', function(event) {
      event.preventDefault();
      document.getElementById('responseMessage').textContent = "Profile updated successfully!";
      this.reset();
    });
  </script>
</body>
</html>
