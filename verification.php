<?php
// Include the database connection
include('./conn/conn.php');

// Start session
session_start();

// Retrieve user verification ID from session if available
$userVerificationID = isset($_SESSION['user_verification_id']) ? $_SESSION['user_verification_id'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['verify'])) {
        // Get the user input
        $verificationID = $_POST['user_verification_id'];
        $verificationCode = $_POST['verification_code'];

        // Validate input
        if (!empty($verificationID) && !empty($verificationCode)) {
            try {
                // Query to verify OTP
                $query = "SELECT * FROM tbl_otp WHERE user_verification_id = :verificationID AND otp = :verificationCode";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':verificationID', $verificationID);
                $stmt->bindParam(':verificationCode', $verificationCode);

                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    // OTP verification successful
                    $_SESSION['verified'] = true; // Set session for successful verification
                    echo "<script>alert('Verification Successful. Redirecting to Dashboard...');</script>";
                    header("Location: ./dashboard.php"); // Redirect to dashboard
                    exit();
                } else {
                    // OTP mismatch
                    $error = "Invalid OTP. Please try again.";
                }
            } catch (PDOException $e) {
                // Handle database errors
                $error = "Error: " . $e->getMessage();
            }
        } else {
            // Missing inputs
            $error = "Please provide all required information.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification System</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: beige;
            height: 100vh;
        }

        .verification-form {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            width: 100%;
            max-width: 400px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .verification-form h2 {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <div class="verification-form">
        <h2>Email Verification</h2>
        <p class="text-center">Please check your email for the verification code.</p>

        <!-- Display Error Message -->
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger text-center">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <input type="text" name="user_verification_id" value="<?= htmlspecialchars($userVerificationID) ?>" hidden>
            <div class="form-group">
                <input type="number" class="form-control text-center" id="verificationCode" name="verification_code" placeholder="Enter OTP" required>
            </div>
            <button type="submit" class="btn btn-secondary form-control" name="verify">Verify</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

</body>
</html>
