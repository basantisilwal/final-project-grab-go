<?php
session_start();
include('../conn/conn.php');

// Check if customer is logged in
$customer_id = $_SESSION['customer_id'] ?? null;

if (!$customer_id) {
    header("Location: http://localhost/Grabandgo/final-project-grab-go/Customer/customerdashboard.php");
    exit();
}

// Initialize message variables
$profile_message = '';
$password_message = '';
$error = '';

// Fetch user info
$sql = "SELECT first_name,last_name, profile_pic, password FROM tbl_otp WHERE tbl_user_id = :customer_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Set profile picture or default
$profilePic = !empty($user['profile_pic']) ? "uploads/{$user['profile_pic']}" : "default_profile.png";

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle Profile Update
    if (isset($_POST['update_profile'])) {
        $first_name = htmlspecialchars(trim($_POST['first_name']));
        $last_name = htmlspecialchars(trim($_POST['last_name']));
        $profile_pic = $_FILES['profile_pic'];

        try {
            $conn->beginTransaction();

            // Upload new profile pic if provided
            if ($profile_pic['error'] === UPLOAD_ERR_OK) {
                // Delete old profile picture if it exists
                if (!empty($user['profile_pic'])) {
                    $old_file_path = "uploads/" . $user['profile_pic'];
                    if (file_exists($old_file_path)) {
                        unlink($old_file_path);
                    }
                }

                // Generate unique filename and save
                $newFileName = uniqid() . '_' . basename($profile_pic['name']);
                $file_path = "uploads/" . $newFileName;

                if (move_uploaded_file($profile_pic['tmp_name'], $file_path)) {
                    $updatePic = $conn->prepare("UPDATE tbl_otp SET profile_pic = :pic WHERE tbl_user_id = :id");
                    $updatePic->execute([':pic' => $newFileName, ':id' => $customer_id]);
                    $profilePic = "uploads/" . $newFileName;
                    $profile_message = "Profile picture updated successfully! ";
                } else {
                    throw new Exception("Failed to upload profile picture.");
                }
            }

            // Update first name if changed
            if ($first_name !== $user['first_name']) {
                $updateName = $conn->prepare("UPDATE tbl_otp SET first_name = :fname WHERE tbl_user_id = :id");
                $updateName->execute([':fname' => $first_name, ':id' => $customer_id]);
                $profile_message .= "Name updated successfully! ";
            }

            $conn->commit();
        } catch (Exception $e) {
            $conn->rollBack();
            $error = $e->getMessage();
        }
    }


    // Handle Password Change
    if (isset($_POST['change_password'])) {
        $current_password = trim($_POST['current_password']);
        $new_password = trim($_POST['new_password']);
        $confirm_password = trim($_POST['confirm_password']);

        try {
            // Check if current password matches (plain text comparison)
            if ($current_password !== $user['password']) {
                throw new Exception("Current password is incorrect!");
            }

            if ($new_password !== $confirm_password) {
                throw new Exception("New passwords do not match!");
            }

            if (strlen($new_password) < 8) {
                throw new Exception("Password must be at least 8 characters long!");
            }

            // Update password (store in plain text)
            $updatePassword = $conn->prepare("UPDATE tbl_otp SET password = :password WHERE tbl_user_id = :id");
            $updatePassword->execute([':password' => $new_password, ':id' => $customer_id]);
            $password_message = "Password updated successfully!";

            $_SESSION['password_updated'] = true;
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }

    // If no errors, redirect with success message
    if (empty($error)) {
        $_SESSION['profile_update_message'] = $profile_message;
        $_SESSION['password_update_message'] = $password_message;
        header("Location: http://localhost/Grabandgo/final-project-grab-go/Customer/customerdashboard.php");
        exit();
    }
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
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
            border: 3px solid #f7e4a3;
        }
        .close-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 24px;
            text-decoration: none;
            color: #333;
        }
        .container-box {
            position: relative;
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            background-color: white;
        }
        .password-reset-form {
            margin-top: 20px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .btn-change-password {
            background-color: #f7e4a3;
            color: #000;
            border: none;
        }
        .btn-change-password:hover {
            background-color: #e6d393;
        }
        .alert {
            margin-bottom: 20px;
        }
        .file-upload {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }
        .file-upload-btn {
            background-color: #f7e4a3;
            color: #000;
            padding: 8px 20px;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
        }
        .file-upload input[type="file"] {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
        }
        .form-section {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        .form-section:last-child {
            border-bottom: none;
        }
    </style>
    <script>
        function previewProfilePic(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profile-pic-preview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</head>
<body>
<div class="container container-box">
    <!-- Close button -->
    <a href="http://localhost/Grabandgo/final-project-grab-go/Customer/customerdashboard.php" class="close-btn" title="Go Back">&times;</a>

    <h4 class="text-center mb-4">Update Profile</h4>
    
    <!-- Display messages -->
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <?php if (!empty($profile_message)): ?>
        <div class="alert alert-success"><?php echo $profile_message; ?></div>
    <?php endif; ?>
    <?php if (!empty($password_message)): ?>
        <div class="alert alert-success"><?php echo $password_message; ?></div>
    <?php endif; ?>

    <!-- Profile Update Form -->
    <form method="POST" enctype="multipart/form-data">
        <div class="form-section">
            <h5>Profile Information</h5>
            <div class="text-center">
                <img id="profile-pic-preview" src="<?php echo $profilePic; ?>" alt="Profile" class="profile-pic">
                <div class="file-upload mt-2">
                    <label class="file-upload-btn">
                        Choose New Photo
                        <input type="file" name="profile_pic" accept="image/*" onchange="previewProfilePic(this)">
                    </label>
                </div>
            </div>
            
            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="first_name" class="form-control" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
            </div>

            <button type="submit" name="update_profile" class="btn btn-primary btn-block">Save Profile Changes</button>
        </div>
    </form>

    <!-- Password Change Form -->
    <form method="POST">
        <div class="form-section password-reset-form">
            <h5>Change Password</h5>
            <div class="form-group">
                <label>Current Password</label>
                <input type="password" name="current_password" class="form-control" placeholder="Enter current password" required>
            </div>
            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="new_password" class="form-control" placeholder="Enter new password (min 8 characters)" required>
            </div>
            <div class="form-group">
                <label>Confirm New Password</label>
                <input type="password" name="confirm_password" class="form-control" placeholder="Confirm new password" required>
            </div>
            <button type="submit" name="change_password" class="btn btn-primary btn-block">Change Password</button>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</body>
</html>