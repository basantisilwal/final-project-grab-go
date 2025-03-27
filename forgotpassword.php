<?php
include('./conn/conn.php');

// Initialize variables
$error = '';
$success = '';
$showResetModal = false;
$verifiedUser = null;

// Check if form is submitted for username/email verification
if (isset($_POST['verify_user'])) {
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    // Check if username and email belong to the same user
    $query = "SELECT * FROM `tbl_otp` WHERE `username` = ? AND `email` = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$username, $email]);
    $verifiedUser = $stmt->fetch();

    if ($verifiedUser) {
        $showResetModal = true;
    } else {
        $error = "No account found with that username and email combination.";
    }
}


// Check if form is submitted for password reset
if (isset($_POST['reset_password'])) {
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];
    $username = $_POST['username'];
    $email = $_POST['email'];

    // Validate passwords match
    if ($newPassword !== $confirmPassword) {
        $error = "Passwords do not match.";
    } else {
        // Verify the user again for security
        $query = "SELECT * FROM `tbl_otp` WHERE `username` = ? AND `email` = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$username, $email]);
        $user = $stmt->fetch();

        if ($user) {
            // Update password (without hashing - NOT RECOMMENDED)
            $updateQuery = "UPDATE `tbl_otp` SET `password` = ? WHERE `username` = ? AND `email` = ?";
            $updateStmt = $conn->prepare($updateQuery);
            
            if ($updateStmt->execute([$newPassword, $username, $email])) {
                $success = "Password updated successfully! You can now login with your new password.";
                $showResetModal = false;
            } else {
                $error = "Failed to update password. Please try again.";
            }
        } else {
            $error = "User verification failed. Please start the password reset process again.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Grab&Go</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f7e4a3; 
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            height: 100vh;
        }
        
        .forgot-password-container {
            backdrop-filter: blur(100px);
            color: rgb(7, 0, 0);
            padding: 40px;
            width: 500px;
            border: 2px solid;
            border-radius: 10px;
        }
        
        .btn-primary {
            background-color: black !important;
            color: white !important;
            border: none;
            padding: 10px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }
        
        .btn-primary:hover {
            background-color: #333 !important;
        }
        
        .back-to-login {
            text-decoration: underline;
            cursor: pointer;
            color: rgb(1, 1, 11);
            display: block;
            text-align: center;
            margin-top: 15px;
        }
        
        .modal-content {
            background-color: #f7e4a3;
            border: 2px solid black;
        }
    </style>
</head>
<body>
    <div class="forgot-password-container">
        <h2 class="text-center">Forgot Password</h2>
        <p class="text-center">Please enter your username and email to reset your password</p>
        
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
            <a href="register.php" class="btn btn-primary form-control mt-3">Back to Login</a>
        <?php else: ?>
            <form method="POST" action="forgotpassword.php">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" required
                        value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required
                        value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                </div>
                <button type="submit" name="verify_user" class="btn btn-primary form-control">Verify Account</button>
                <a href="register.php" class="back-to-login">Back to Login</a>
            </form>
        <?php endif; ?>
    </div>

    <!-- Reset Password Modal -->
    <?php if ($showResetModal && $verifiedUser): ?>
    <div class="modal fade show" id="resetPasswordModal" tabindex="-1" role="dialog" aria-labelledby="resetPasswordModalLabel" style="display: block; padding-right: 15px;" aria-modal="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resetPasswordModalLabel">Reset Your Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="forgotpassword.php">
                        <input type="hidden" name="username" value="<?php echo htmlspecialchars($verifiedUser['username']); ?>">
                        <input type="hidden" name="email" value="<?php echo htmlspecialchars($verifiedUser['email']); ?>">
                        <div class="form-group">
                            <label for="new_password">New Password:</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password:</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        <button type="submit" name="reset_password" class="btn btn-primary form-control">Reset Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show"></div>
    <?php endif; ?>

    <!-- Bootstrap Js -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    
    <script>
        function closeModal() {
            document.getElementById('resetPasswordModal').style.display = 'none';
            document.querySelector('.modal-backdrop').style.display = 'none';
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target === document.querySelector('.modal-backdrop')) {
                closeModal();
            }
        }
    </script>
</body>
</html>