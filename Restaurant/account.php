
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
{
    font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      display: flex;
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
        .container {
      text-align: center;
      max-width: 600px;
      width: 100%;
      padding: 20px;
      background-color: #ffffff;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      border-radius: 12px;
    }

    /* Title Styling */
    .container h1 {
      font-size: 24px;
      color: #333;
      margin-bottom: 10px;
    }

    /* Icon Separator */
    .separator {
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 15px 0;
    }

    .separator::before,
    .separator::after {
      content: "";
      flex: 1;
      height: 1px;
      background: #ccc;
      margin: 0 10px;
    }

    .separator img {
      height: 20px;
    }

    /* Profile Image */
    .profile-image {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #ddd;
      margin-top: 20px;
    }

    /* User Info */
    .user-info {
      margin-top: 20px;
      font-size: 16px;
      color: #555;
    }

    .user-info p {
      margin: 5px 0;
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
    <a href="logout.php">Logout</a>
    </aside>




<div class="container">
  <h1>Registered User's</h1>
  
  <div class="separator">
    <img src="https://cdn-icons-png.flaticon.com/512/869/869869.png" alt="icon" />
  </div>

  <img src="../images/buff momo image.jpg" alt="User Photo" class="profile-image">
  
  <div class="user-info">
    <p><strong>User ID:</strong> TA1ICk3GFt1Bilg2sS64</p>
    <p><strong>User Name:</strong> Diamon</p>
    <p><strong>User Email:</strong> kahdaueaa@gmail.com</p>
  </div>
</div>

</body>
</html>
