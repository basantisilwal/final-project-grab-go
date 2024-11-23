restrunt dashboard
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
            padding: 20px;
            margin: 20px auto;
            max-width:1200px;
            background-color: pink;
            padding: 110px;
            border-radius: 8px;
            width: 100%;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
         .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .header h2 {
            font-size: 1.5rem;
            color: #333;
        }
        .header button {
            background-color: #0d6efd;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9rem;
        }
        .header button:hover {
            background-color: #0056b3;
        }
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        .card {
            padding: 10px;
            background-color: #f1f1f1;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .card h2 {
            font-size: 2rem;
            color: #0d6efd;
            margin-bottom: 10px;
        }
        .card p {
            font-size: 1rem;
            color: #555;
            margin-bottom: 15px;
        }
        .card button {
            background-color: #0d6efd;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9rem;
        }
        .card button:hover {
            background-color: #0056b3;
        }
        .unread-messages {
          order: -1;
        }
    </style>
</head>
<body>


  <div class="main-content">
    <div class="header">
      <h1>Welcome, Diamon Restro</h1>
      <button onclick="updateProfile()">Update Profile</button>
    </div>
    <div class="dashboard-cards">
      <div class="card">
        <h2>0</h2>
        <p>Unread Messages</p>
        <button onclick="showMessages()">See Messages</button>
      </div><br>
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

  <script>
    function showMessages() {
        alert("Feature under construction!");
    }
    function updateProfile() {
        alert("Redirecting to Update Profile page!");
    }
  </script>
</body>
</html>
