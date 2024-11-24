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

  /* Sidebar Styles */
    .sidebar {
      width: 250px;
      background-color: #000; /* Black background */
      color: #fff;
      height: 100vh;
      display: flex;
      flex-direction: column;
      padding: 20px 15px;
    }

    .sidebar h2 {
      font-size: 1.2rem;
      margin-bottom: 20px;
    }

    .sidebar a {
      color: #ff6700; /* Orange text */
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
    .main-content {
      flex-grow: 1;
      padding: 15px;
      margin-left: 250px;
      transition: margin-left 0.3s ease-in-out;
    }
    .main-content.expanded {
      margin-left: 0;
    }

    /* Toggle button */
    .toggle-button {
      position: absolute;
      top: 20px;
      left: 10px;
      z-index: 1000;
      background-color: #0d6efd;
      color: white;
      border: none;
      padding: 8px 12px;
      border-radius: 5px;
      cursor: pointer;
    }
    .toggle-button:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>

  <aside class="sidebar">
    <h2>Restaurant Dashboard</h2>
    <a href="das.php">Dashboard</a>
    <a href="myproject.php">My Project</a>
    <a href="addfood.php">Add Food</a>
    <a href="viewfood.php">View food</a>
    <a href="managepayment.php">View payment</a>
    <a href="account.php">Account</a>
    <a href="updateprofile.php">Profile</a>
    <a href="#">Logout</a>
    </aside>
    <style>
  .main-content {
    flex-grow: 1;
    padding: 20px;
    background-color: #f8f8f8;
  }

  .main-content h1 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
  }

  .update-profile-container {
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    max-width: 600px;
    margin: 0 auto;
  }

  .profile-pic-container {
    text-align: center;
    margin-bottom: 20px;
  }

  .profile-pic {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    overflow: hidden;
    margin: 0 auto;
    border: 2px solid #ddd;
  }

  .profile-pic img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .btn {
    margin-top: 10px;
    padding: 8px 15px;
  }

  h2 {
    text-align: center;
    color: #555;
    margin-bottom: 20px;
  }

  form {
    display: flex;
    flex-direction: column;
    gap: 15px;
  }

  .form-group {
    display: flex;
    flex-direction: column;
  }

  .form-group label {
    margin-bottom: 5px;
    color: #666;
  }

  .form-group input {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
  }

  .form-group input:focus {
    outline: none;
    border-color: #ff6700;
  }

  .update-button {
    background-color: #ff6700;
    color: #fff;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    text-align: center;
  }

  .update-button:hover {
    background-color: #e65c00;
  }

  .message {
    text-align: center;
    margin-top: 15px;
    font-size: 16px;
    color: green;
    display: none;
  }
</style>

    <!-- Main Content -->
    <div class="main-content">
      <h1>Welcome to the Dashboard</h1>
      <div class="update-profile-container">
    <div class="profile-pic-container">
      <div class="profile-pic" id="profilePicPreviewContainer">
        <img id="profilePicPreview" src="default-profile.png" alt="Profile Picture">
      </div>
      <input type="file" id="profilePicInput" accept="image/*" style="display: none;">
      <button class="btn btn-secondary" onclick="document.getElementById('profilePicInput').click()">Change Picture</button>
    </div>
    <h2>Update Profile</h2>
    <form id="updateProfileForm">
      <div class="form-group">
        <label for="name">Your Name</label>
        <input type="text" id="name" name="name" placeholder="Enter your name" value="John Doe" required>
      </div>
      <div class="form-group">
        <label for="email">Your Email</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" value="johndoe@gmail.com" required>
      </div>
      <div class="form-group">
        <label for="oldPassword">Old Password</label>
        <input type="password" id="oldPassword" name="oldPassword" placeholder="Enter old password" required>
      </div>
      <div class="form-group">
        <label for="newPassword">New Password</label>
        <input type="password" id="newPassword" name="newPassword" placeholder="Enter new password">
      </div>
      <div class="form-group">
        <label for="confirmPassword">Confirm New Password</label>
        <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm new password">
      </div>
      <button type="button" class="update-button" onclick="updateProfile()">Update Profile</button>
    </form>
    <div class="message" id="successMessage">Profile updated successfully!</div>
  </div>
  
 </div>
  </div>
  <style>
   