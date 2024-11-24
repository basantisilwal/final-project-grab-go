<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="rstyle.css">
  <title>Restaurant Management System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    body {
      font-size: 0.9rem;
    }

    /* Sidebar styles */
    .main-container {
      display: flex;
      overflow-x: hidden;
    }
    .sidebar {
      height: 100vh;
      background-color: #555;
      padding-top: 20px;
      width: 250px;
      transition: transform 0.3s ease-in-out;
      transform: translateX(0);
    }
    .sidebar .nav-link {
      color: #333;
      padding: 0.5rem 1rem;
    }
    .sidebar .nav-link:hover {
      background-color:#0d6efd ;
    }
    .sidebar .nav-link.active {
      background-color: #0d6efd;
      color: white;
    }
    .sidebar.collapsed {
      transform: translateX(-100%);
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
  <!-- Toggle Button -->
  <button class="toggle-button" id="toggleSidebar">☰</button>

  <div class="main-container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="sidebar-header">
        <h2>Restaurant Dashboard</h2>
      </div>
      <ul class="sidebar-menu">
        <a href="restaurantdashboard.php" class="nav-link active">Dashboard</a>
        <a href="addfood.php" class="nav-link">Add Food</a>
        <a href="updateprofile.php" class="nav-link">Update Profile</a>
        <a href="viewfood.php" class="nav-link">View Food</a>
        <a href="account.php" class="nav-link">Accounts</a>
        <a href="index.php" class="nav-link">Logout</a>
      </ul>
    </aside>

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
    /* Reset and Basic Styles */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      padding: 20px;
    }

    .update-profile-container {
      background-color: white;
      max-width: 500px;
      width: 100%;
      border-radius: 10px;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
      padding: 20px;
    }

    .profile-pic-container {
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-bottom: 20px;
    }

    .profile-pic {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      overflow: hidden;
      border: 3px solid #ff6699;
      display: flex;
      justify-content: center;
      align-items: center;
      margin-bottom: 15px;
    }

    .profile-pic img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .update-profile-container h2 {
      text-align: center;
      color: #333;
      margin-bottom: 20px;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      font-weight: bold;
      margin-bottom: 5px;
      display: block;
      color: #555;
    }

    .form-group input {
      width: 100%;
      padding: 10px;
      font-size: 14px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .form-group input[type="file"] {
      padding: 5px;
    }

    .update-button {
      width: 100%;
      background-color: #ff6699;
      color: white;
      padding: 10px;
      font-size: 16px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      margin-top: 10px;
      transition: background-color 0.3s;
    }

    .update-button:hover {
      background-color: #ff4d80;
    }

    .message {
      text-align: center;
      margin-top: 10px;
      color: green;
      display: none;
    }
  </style>
  <script>
    const toggleButton = document.getElementById('toggleSidebar');
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.querySelector('.main-content');

    toggleButton.addEventListener('click', () => {
      sidebar.classList.toggle('collapsed');
      mainContent.classList.toggle('expanded');
    });
  </script>
</body>
</html>
