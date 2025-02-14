
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
      background-color:#FFE0B2;
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
    <a href="das.php"><i class="fas fa-home"></i> Dashboard</a>
<a href="addfood.php"><i class="fas fa-utensils"></i> Add Food</a>
<a href="viewfood.php"><i class="fas fa-list"></i> View Food</a>
<a href="vieworder.php"><i class="fas fa-shopping-cart"></i> View Order</a>
<a href="managepayment.php"><i class="fas fa-money-bill"></i> View Payment</a>
<a href="account.php"><i class="fas fa-user"></i> Account</a>
<a href="updateprofile.php"><i class="fas fa-cog"></i> Profile</a>
<a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
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
