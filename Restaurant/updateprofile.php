<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="rstyle.css">
  <title>Restaurant Management System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
    }
    

        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background-color: #f7e4a3;
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
        .main-content h1 {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        table th {
            background-color: #007bff;
            color: #fff;
        }

        table img {
            max-width: 100px;
            max-height: 80px;
            object-fit: cover;
        }

        .action-buttons button {
            margin: 0 5px;
            padding: 5px 10px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            color: #fff;
        }

        .btn-edit {
            background-color: #28a745;
        }

        .btn-delete {
            background-color: #dc3545;
        }
  </style>
</head>
<body>
       <!-- Sidebar -->
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

    <!-- Main Content -->

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f9f9f9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); max-width: 400px; width: 100%; }
        h1 { text-align: center; font-size: 24px; margin-bottom: 20px; }
        form { display: flex; flex-direction: column; }
        label { margin-bottom: 5px; font-weight: bold; }
        input, textarea, button { margin-bottom: 15px; padding: 10px; border: 1px solid #ccc; border-radius: 4px; }
        button { background: #28a745; color: white; font-size: 16px; cursor: pointer; border: none; }
        button:hover { background: #218838; }
        #responseMessage { text-align: center; color: green; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Update Profile</h1>
        <form id="updateProfileForm">
            <label for="restaurantName">Restaurant Name:</label>
            <input type="text" id="restaurantName" required>
            <label for="ownerName">Owner's Name:</label>
            <input type="text" id="ownerName" required>
            <label for="contactNumber">Contact Number:</label>
            <input type="tel" id="contactNumber" required>
            <label for="address">Address:</label>
            <textarea id="address" rows="3" required></textarea>
            <button type="submit">Update Profile</button>
        </form>
        <div id="responseMessage"></div>
    </div>
    <script>
        document.getElementById('updateProfileForm').addEventListener('submit', function(event) {
            event.preventDefault();
            document.getElementById('responseMessage').textContent = "Profile updated successfully!";
            console.log("Form Data:", {
                restaurantName: document.getElementById('restaurantName').value,
                ownerName: document.getElementById('ownerName').value,
                contactNumber: document.getElementById('contactNumber').value,
                address: document.getElementById('address').value
            });
            this.reset();
        });
    </script>
</body>
</html>
