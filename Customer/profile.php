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
$sql = "SELECT first_name, profile_pic FROM tbl_otp WHERE tbl_user_id = :customer_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Set profile picture or default
$profilePic = !empty($user['profile_pic']) ? "uploads/{$user['profile_pic']}" : "default_profile.png";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Redirect to dashboard
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
    </style>
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
        <button type="submit" class="btn btn-primary btn-block">Save Changes</button>
    </form>
</div>
</body>
</html>
