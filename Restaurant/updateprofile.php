<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile Update</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .container {
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      max-width: 400px;
      width: 100%;
      text-align: center;
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
