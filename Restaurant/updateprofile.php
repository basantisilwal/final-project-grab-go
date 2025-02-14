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
            background-color:#FFE0B2;
    }
    

        /* Sidebar Styles */
        .sidebar {
    width: 250px;
    background: linear-gradient(135deg, #f7b733, #fc4a1a); /* Gradient Background */
    color: #fff;
    height: 100vh;
    display: flex;
    flex-direction: column;
    padding: 20px 15px;
    position: fixed;
    top: 0;
    left: 0;
    box-shadow: 4px 0 10px rgba(0, 0, 0, 0.2); /* Soft shadow for depth */
}

.sidebar h2 {
    font-size: 1.5rem;
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

/* Optional: Add icons next to menu items */
.sidebar a i {
    margin-right: 10px;
    font-size: 1.2rem;
}
        .main-content h1 {
            margin-bottom: 20px;
            background-color:#FFE0B2;
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
            background-color: #000;
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
    <a href="das.php"><i class="fas fa-home"></i> Dashboard</a>
<a href="addfood.php"><i class="fas fa-utensils"></i> Add Food</a>
<a href="viewfood.php"><i class="fas fa-list"></i> View Food</a>
<a href="vieworder.php"><i class="fas fa-shopping-cart"></i> View Order</a>
<a href="managepayment.php"><i class="fas fa-money-bill"></i> View Payment</a>
<a href="account.php"><i class="fas fa-user"></i> Account</a>
<a href="updateprofile.php"><i class="fas fa-cog"></i> Profile</a>
<a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
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
