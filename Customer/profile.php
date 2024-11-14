<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $country = $_POST['country'];
    $userName = $_POST['userNameData'];
    $profilePicData = $_POST['profilePicData'];

    // Save user data (this is a simple example, you may need to use a database)
    $profilePicPath = 'uploads/profile_pic.png';

    if ($profilePicData) {
        list($type, $data) = explode(';', $profilePicData);
        list(, $data) = explode(',', $data);
        $data = base64_decode($data);
        file_put_contents($profilePicPath, $data);
    }

    echo "Profile updated successfully!<br>";
    echo "Name: $userName<br>";
    echo "First Name: $firstName<br>";
    echo "Last Name: $lastName<br>";
    echo "Country: $country<br>";
    echo "<br><a href=\"javascript:history.go(-1)\">Go back</a>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Profile</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f5f5f5;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .container {
      width: 400px;
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .back-button {
      margin-bottom: 10px;
    }
    .back-button button {
      background: none;
      border: none;
      font-size: 16px;
      color: #007BFF;
      cursor: pointer;
    }
    .profile-section {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
    }
    .profile-pic-container {
      position: relative;
      width: 80px;
      height: 80px;
    }
    .profile-pic-container img {
      width: 100%;
      height: 100%;
      border-radius: 50%;
      object-fit: cover;
    }
    .camera-icon {
      position: absolute;
      bottom: 0;
      right: 0;
      cursor: pointer;
    }
    .camera-icon input {
      display: none;
    }
    .name-section {
      margin-left: 15px;
    }
    .name-section h2 {
      margin: 0;
      font-size: 20px;
    }
    .form-group {
      margin-bottom: 15px;
    }
    .form-group label {
      display: block;
      margin-bottom: 5px;
    }
    .form-group input, .form-group select {
      width: 100%;
      padding: 8px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }
    .save-button {
      width: 100%;
      padding: 10px;
      background-color: #007BFF;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .save-button:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="back-button">
    <button onclick="window.history.back()">← Back</button>
  </div>

  <div class="profile-section">
    <div class="profile-pic-container">
      <img id="profilePicPreview" src="default-profile.png" alt="Profile Picture">
      <label for="profilePicInput" class="camera-icon">
        <input type="file" id="profilePicInput" accept="image/*">
        <img src="camera-icon.png" alt="Edit Icon">
      </label>
    </div>
    <div class="name-section">
      <h2 id="userName" contenteditable="true">Jill Student</h2>
      <p><a href="#" id="gradeLevel">Set your grade level</a></p>
    </div>
  </div>

  <form id="updateProfileForm" method="POST" enctype="multipart/form-data">
    <div class="form-group">
      <label for="firstName">First Name</label>
      <input type="text" id="firstName" name="firstName" value="Jill" required>
    </div>
    <div class="form-group">
      <label for="lastName">Last Name</label>
      <input type="text" id="lastName" name="lastName" value="Student" required>
    </div>
    <div class="form-group">
      <label for="country">Country</label>
      <select id="country" name="country">
        <option value="United States">United States</option>
        <option value="Canada">Canada</option>
        <option value="United Kingdom">United Kingdom</option>
      </select>
    </div>
    <input type="hidden" id="profilePicData" name="profilePicData">
    <input type="hidden" id="userNameData" name="userNameData">
    <button type="submit" class="save-button">Save</button>
  </form>
</div>

<script>
  const profilePicInput = document.getElementById('profilePicInput');
  const profilePicPreview = document.getElementById('profilePicPreview');
  const userName = document.getElementById('userName');
  const userNameData = document.getElementById('userNameData');
  const profilePicData = document.getElementById('profilePicData');

  profilePicInput.addEventListener('change', function () {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        profilePicPreview.src = e.target.result;
        profilePicData.value = e.target.result; // Save base64 data
      };
      reader.readAsDataURL(file);
    }
  });

  userName.addEventListener('blur', () => {
    userNameData.value = userName.textContent;
  });
</script>

</body>
</html>
