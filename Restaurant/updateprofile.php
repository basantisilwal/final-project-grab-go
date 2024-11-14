<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Profile</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    body {
      font-family: Arial, sans-serif;
      background-color: #f9f8f6;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    /* Profile Update Form */
    .profile-form {
      max-width: 600px;
      width: 100%;
      background-color: #ffffff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    .profile-pic {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      overflow: hidden;
      margin-bottom: 15px;
      border: 2px solid #ff6699;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .profile-pic img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    .profile-form h2 {
      font-size: 24px;
      color: #ff6699;
      margin-bottom: 20px;
    }
    .form-group {
      margin-bottom: 15px;
      width: 100%;
      display: flex;
      flex-direction: column;
    }
    .form-group label {
      font-weight: bold;
      color: #555;
      margin-bottom: 5px;
    }
    .form-group input {
      padding: 10px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    .form-group input[type="file"] {
      padding: 5px;
    }
    .update-button {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      color: white;
      background-color: #ff6699;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      margin-top: 10px;
      transition: background-color 0.3s;
    }
    .update-button:hover {
      background-color: #ff4d80;
    }
  </style>
</head>
<body>

<!-- Profile Update Form -->
<div class="profile-form" id="updateProfileForm">
  <div class="profile-pic" id="profilePicContainer">
    <img id="profilePicPreview" src="../image/loginpic logo.png" alt="Profile Picture">
  </div>
  <h2>Update Profile</h2>
  <div class="form-group">
    <label for="name">Your Name</label>
    <input type="text" id="name" name="name" value="shalu ansari" required>
  </div>
  <div class="form-group">
    <label for="email">Your Email</label>
    <input type="email" id="email" name="email" value="shalu@gmail.com" required>
  </div>
  <div class="form-group">
    <label for="image">Update Pic:</label>
    <input type="file" id="image" name="image" accept="image/*">
  </div>
  <div class="form-group">
    <label for="oldPassword">Old Password:</label>
    <input type="password" id="oldPassword" name="oldPassword" required>
  </div>
  <div class="form-group">
    <label for="newPassword">New Password:</label>
    <input type="password" id="newPassword" name="newPassword" placeholder="Enter your new password">
  </div>
  <div class="form-group">
    <label for="confirmPassword">Confirm Password:</label>
    <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm your new password">
  </div>
  <button type="button" class="update-button" onclick="updateProfile()">Update Now</button>
</div>

<script>
  // Image preview functionality
  const imageInput = document.getElementById('image');
  const profilePicPreview = document.getElementById('profilePicPreview');

  imageInput.addEventListener('change', function (event) {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        profilePicPreview.src = e.target.result;
      };
      reader.readAsDataURL(file);
    }
  });

  function updateProfile() {
    // Validate passwords
    const newPassword = document.getElementById('newPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;

    if (newPassword !== confirmPassword) {
      alert('New password and confirm password do not match');
      return;
    }

    // Here you would typically send the form data to the server
    alert('Profile updated successfully');

    // Reset the form after update
    document.getElementById('updateProfileForm').reset();
    // Reset profile picture preview to default
    profilePicPreview.src = "../image/loginpic logo.png";
  }
</script>

</body>
</html>
