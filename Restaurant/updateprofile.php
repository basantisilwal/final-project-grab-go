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
      background-color: #f9f9f9;
      color: #333;
    }
    header {
            background-color: #555;
            color: white;
            text-align: center;
            padding: 20px;
        }

        /* Main Layout: Sidebar and Content */
        .main-layout {
            display: flex;
            height: 100vh; /* Full viewport height */
        }

        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background-color: #000; /* Black background */
            color: #fff;
            height: 100%;
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
    .container {
      max-width: 900px;
      margin: 50px auto;
      padding: 50px;
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .profile-pic {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      overflow: hidden;
      margin: 0 auto 15px;
      border: 3px solid #007bff;
    }
    .profile-pic img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    .form-group {
      margin-bottom: 15px;
      text-align: left;
    }
    .form-group label {
      display: block;
      font-weight: bold;
      margin-bottom: 5px;
    }
    .form-group input {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    .form-group input[type="file"] {
      padding: 0;
    }
    button {
      background: #007bff;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
    }
    button:hover {
      background: #0056b3;
    }
    .message {
      color: green;
      margin-top: 15px;
      display: none;
    }
  </style>
</head>
<body>
<div class="main-layout">
        <!-- Sidebar -->
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

  <div class="container">
    <div class="profile-pic">
      <img id="profilePicPreview" src="default-profile.png" alt="Profile Picture">
    </div>
    <form id="profileForm" enctype="multipart/form-data" method="POST">
      <div class="form-group">
        <label for="profilePicInput">Change Profile Picture</label>
        <input type="file" id="profilePicInput" name="profilePicture" accept="image/*">
      </div>
      <div class="form-group">
        <label for="name">Your Name</label>
        <input type="text" id="name" name="name" value="John Doe" required>
      </div>
      <div class="form-group">
        <label for="email">Your Email</label>
        <input type="email" id="email" name="email" value="johndoe@gmail.com" required>
      </div>
      <button type="submit">Update Profile</button>
    </form>
    <div class="message" id="successMessage">Profile updated successfully!</div>
  </div>

  <script>
    const profilePicInput = document.getElementById('profilePicInput');
    const profilePicPreview = document.getElementById('profilePicPreview');
    const successMessage = document.getElementById('successMessage');

    // Preview selected profile picture
    profilePicInput.addEventListener('change', () => {
      const file = profilePicInput.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
          profilePicPreview.src = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    });

    // Display success message on form submission
    document.getElementById('profileForm').onsubmit = () => {
      successMessage.style.display = 'block';
    };
  </script>

  <?php
  // PHP Backend
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDir = 'uploads/';
    $uploadFile = $uploadDir . basename($_FILES['profilePicture']['name']);

    // Ensure the uploads directory exists
    if (!is_dir($uploadDir)) {
      mkdir($uploadDir, 0755, true);
    }

    // Save uploaded file
    if (move_uploaded_file($_FILES['profilePicture']['tmp_name'], $uploadFile)) {
      // Here you would normally update the database
      echo "<script>document.getElementById('successMessage').innerText = 'Profile picture updated successfully!';</script>";
    } else {
      echo "<script>alert('Failed to upload profile picture');</script>";
    }
  }
  ?>
</body>
</html>
