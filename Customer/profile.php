<?php
session_start();
include('../conn/conn.php');

// Check if customer is logged in
$customer_id = $_SESSION['customer_id'] ?? null;

if (!$customer_id) {
    header("Location: http://localhost/Grabandgo/final-project-grab-go/Customer/customerdashboard.php");
    exit();
}

// Fetch user info
$sql = "SELECT first_name, profile_pic, password FROM tbl_otp WHERE tbl_user_id = :customer_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Set profile picture or default
$profilePic = !empty($user['profile_pic']) ? "uploads/{$user['profile_pic']}" : "default_profile.png";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update Profile Info
    if (isset($_POST['first_name'])) {
        $first_name = htmlspecialchars($_POST['first_name']);
        $profile_pic = $_FILES['profile_pic'];

        // Upload new profile pic if provided
        if ($profile_pic['error'] === UPLOAD_ERR_OK) {
            $upload_dir = __DIR__ . '/uploads/';
            if (!file_exists($upload_dir)) mkdir($upload_dir, 0777, true);

            $newFileName = uniqid() . '_' . basename($profile_pic['name']);
            $file_path = $upload_dir . $newFileName;

            if (move_uploaded_file($profile_pic['tmp_name'], $file_path)) {
                $updatePic = $conn->prepare("UPDATE tbl_otp SET profile_pic = :pic WHERE tbl_user_id = :id");
                $updatePic->execute([':pic' => $newFileName, ':id' => $customer_id]);
            }
        }

        // Update first name
        $updateName = $conn->prepare("UPDATE tbl_otp SET first_name = :fname WHERE tbl_user_id = :id");
        $updateName->execute([':fname' => $first_name, ':id' => $customer_id]);
    }

    // Reset Password Logic
    if (isset($_POST['current_password']) && isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        // Check if current password matches
        if (password_verify($current_password, $user['password'])) {
            // Check if new password and confirm password match
            if ($new_password === $confirm_password) {
                // Update password
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $updatePassword = $conn->prepare("UPDATE tbl_otp SET password = :password WHERE tbl_user_id = :id");
                $updatePassword->execute([':password' => $hashed_password, ':id' => $customer_id]);
                echo "Password updated successfully!";
            } else {
                echo "New passwords do not match!";
            }
        } else {
            echo "Current password is incorrect!";
        }
    }

    // Redirect to dashboard after profile update or password change
    header("Location: http://localhost/Grabandgo/final-project-grab-go/Customer/customerdashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .profile-pic {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }
        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            text-decoration: none;
            color: #333;
        }
        .container-box {
            position: relative;
            max-width: 400px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-top: 50px;
        }
        .password-reset-form {
            display: none;
            margin-top: 20px;
        }
    </style>
    <script>
        // JavaScript to toggle password reset form visibility
        function togglePasswordReset() {
            var form = document.getElementById('password-reset-form');
            form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
        }
    </script>
</head>
<body>
<div class="container container-box">
    <!-- Close button -->
    <a href="http://localhost/Grabandgo/final-project-grab-go/Customer/customerdashboard.php" class="close-btn" title="Go Back">&times;</a>

    <h4 class="text-center mb-4">Update Profile</h4>
    <form method="POST" enctype="multipart/form-data">
        <div class="text-center">
            <img src="<?php echo $profilePic; ?>" alt="Profile" class="profile-pic">
        </div>
        <div class="form-group">
            <label>First Name</label>
            <input type="text" name="first_name" class="form-control" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
        </div>
        <div class="form-group">
            <label>Change Profile Picture</label>
            <input type="file" name="profile_pic" class="form-control-file" accept="image/*">
        </div>

        <button type="button" class="btn btn-info btn-block" onclick="togglePasswordReset()">Change Password</button>

        <!-- Password Reset Form (Initially Hidden) -->
        <div id="password-reset-form" class="password-reset-form">
            <h5>Change Password</h5>
            <div class="form-group">
                <label>Current Password</label>
                <input type="password" name="current_password" class="form-control" required>
            </div>
            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="new_password" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Confirm New Password</label>
                <input type="password" name="confirm_password" class="form-control" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Save Changes</button>
    </form>
</div>
</body>
</html>
