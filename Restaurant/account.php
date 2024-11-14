
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
<div class="main-container">
        <!-- Sidebar -->
        <aside class="sidebar">
        <div class="sidebar">
    <div class="logo">
      <img src="../images/logo.png" alt="Grab & Go">
    </div>
    <div class="profile">
      <img src="../images/buff momo image.jpg" alt="Profile Picture">
      <h2>Diamon Restro</h2>
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
