<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registered User's Profile</title>
  <style>
    /* General Reset */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: #f9f8f6;
    }

    /* Main Container */
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
