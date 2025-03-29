<?php
ob_start();
session_start();

/***************************************************
 * 1. Database Connection (MySQLi)
 ***************************************************/
$host = "localhost";       // Adjust if different
$user = "root";            // Your DB username
$pass = "";                // Your DB password
$db   = "grab&go";         // Your DB name

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/***************************************************
 * 2. Handle Logo Upload
 ***************************************************/
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['site_logo'])) {
    $target_dir = "uploads/logo/";
    if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);

    $file_name   = uniqid() . '_' . basename($_FILES['site_logo']['name']);
    $target_file = $target_dir . $file_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (!in_array($imageFileType, $allowed_types)) {
        $_SESSION['error_message'] = "Only JPG, JPEG, PNG, GIF, and WEBP files are allowed.";
    } elseif (move_uploaded_file($_FILES['site_logo']['tmp_name'], $target_file)) {
        $name = $conn->real_escape_string($_FILES['site_logo']['name']);
        $path = $conn->real_escape_string($target_file);

        $check_existing = "SELECT o_id FROM tbl_logo LIMIT 1";
        $existing_result = $conn->query($check_existing);

        if ($existing_result->num_rows > 0) {
            $conn->query("UPDATE tbl_logo SET name='$name', path='$path' WHERE o_id=(SELECT o_id FROM tbl_logo LIMIT 1)");
        } else {
            $conn->query("INSERT INTO tbl_logo (name, path) VALUES ('$name', '$path')");
        }

        $_SESSION['success_message'] = "Logo uploaded successfully!";
    } else {
        $_SESSION['error_message'] = "Error uploading the logo.";
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Fetch Logo
$current_logo = "default_logo.png"; // Default logo
$logoQuery = "SELECT path FROM tbl_logo LIMIT 1";
$logoResult = $conn->query($logoQuery);
if ($logoRow = $logoResult->fetch_assoc()) {
    $current_logo = $logoRow['path'];
}

/***************************************************
 * 3. Handle QR Code Upload
 ***************************************************/
$qr_path = "default_qr.png"; // Default QR Code

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['site_logo'])) {
    $target_dir = "uploads/logo/";
    if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);

    $file_name = uniqid() . '_' . basename($_FILES['site_logo']['name']);
    $target_file = $target_dir . $file_name; // Relative path
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (!in_array($imageFileType, $allowed_types)) {
        $_SESSION['error_message'] = "Only JPG, JPEG, PNG, GIF, and WEBP files are allowed.";
    } elseif (move_uploaded_file($_FILES['site_logo']['tmp_name'], "../" . $target_file)) { // Ensure correct path
        $name = $conn->real_escape_string($_FILES['site_logo']['name']);
        $path = $conn->real_escape_string($target_file); // Save relative path only

        $check_existing = "SELECT o_id FROM tbl_logo LIMIT 1";
        $existing_result = $conn->query($check_existing);

        if ($existing_result->num_rows > 0) {
            $conn->query("UPDATE tbl_logo SET name='$name', path='$path' WHERE o_id=(SELECT o_id FROM tbl_logo LIMIT 1)");
        } else {
            $conn->query("INSERT INTO tbl_logo (name, path) VALUES ('$name', '$path')");
        }

        $_SESSION['success_message'] = "Logo uploaded successfully!";
    } else {
        $_SESSION['error_message'] = "Error uploading the logo.";
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}


// Fetch QR Code
$qrQuery = "SELECT qr_path FROM tbl_qr LIMIT 1";
$qrResult = $conn->query($qrQuery);
if ($qrRow = $qrResult->fetch_assoc()) {
    $qr_path = $qrRow['qr_path'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            background-color: #FFE0B2;
        }

        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, #f7b733, #fc4a1a);
            color: #fff;
            height: 100vh;
            display: flex;
            flex-direction: column;
            padding: 20px;
            position: fixed;
            top: 0;
            left: 0;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.2);
        }

        .sidebar h2 {
            font-size: 1.4rem;
            font-weight: bold;
            margin-bottom: 20px;
            text-transform: uppercase;
            text-align: center;
            letter-spacing: 1px;
        }

        .sidebar a {
            color: #000;
            text-decoration: none;
            padding: 12px 15px;
            border-radius: 5px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            font-size: 1.1rem;
            transition: all 0.3s ease-in-out;
            font-weight: 500;
        }

        .sidebar a:hover {
            background: #000;
            color: #fff;
            transform: translateX(5px);
        }
        .logo-container {
      text-align: center;
      margin-bottom: 20px;
    }
    .logo-container img {
      width: 80px;
      border-radius: 50%;
      border: 2px solid black;
    }
    .main-container {
            margin-left: 250px; /* match sidebar width */
            width: calc(100% - 250px);
            padding: 20px;
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        /* Logo Preview */
        .logo-preview-container {
            width: 200px;
            height: 200px;
            border-radius: 1rem;
            overflow: hidden;
            margin: 0 auto;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        }
        .logo-preview {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .small-container {
    max-width: 350px; /* Adjust the width as needed */
    margin: auto;
}.qr-preview {
    width: 150px;  /* Adjust the size as needed */
    height: 150px;
    object-fit: contain; /* Ensures it maintains aspect ratio */
}



    </style>
</head>
<body>

<aside class="sidebar">
    <div class="logo-container text-center mb-4">
        <!-- Display current logo (fallback is 'logo.png') -->
        <img src="<?php echo htmlspecialchars($current_logo); ?>" alt="Logo">
    </div>
    <h2> Dashboard</h2>
    <a href="das.php"><i class="fas fa-home"></i> Dashboard</a>
    <a href="addfood.php"><i class="fas fa-utensils"></i> Add Food</a>
    <a href="viewfood.php"><i class="fas fa-list"></i> View Food</a>
    <a href="vieworder.php"><i class="fas fa-shopping-cart"></i> View Order</a>
    <a href="setting.php"><i class="bi bi-gear"></i> Settings</a>
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</aside>
<!-- Main content area -->
<div class="main-container">
    <div class="container mt-5">
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-header text-center">
                    <h5 class="mb-0">Logo Management</h5>
                </div>
                <div class="card-body text-center">
                    <!-- Show current DB logo preview -->
                    <div class="logo-preview-container mb-4">
                        <img src="<?php echo htmlspecialchars($current_logo); ?>" alt="Current Logo" class="logo-preview">
                    </div>

                    <!-- Upload Form -->
                    <form id="logoUploadForm" method="POST" enctype="multipart/form-data">
                        <div class="mb-4">
                            <input type="file" name="site_logo" id="siteLogo"
                                   accept="image/png,image/jpeg,image/gif,image/webp" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-cloud-upload"></i> Upload New Logo
                        </button>
                    </form>

                    <!-- Display Messages -->
                    <?php if (isset($_SESSION['success_message'])): ?>
                        <div class="alert alert-success mt-3">
                            <?php
                                echo $_SESSION['success_message'];
                                unset($_SESSION['success_message']);
                            ?>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['error_message'])): ?>
                        <div class="alert alert-danger mt-3">
                            <?php
                                echo $_SESSION['error_message'];
                                unset($_SESSION['error_message']);
                            ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
   <!-- QR code Upload -->
    <div class= "small-container">
   <div class="card-body">
   <img src="<?php echo htmlspecialchars($qr_path); ?>" alt="QR Code" class="qr-preview">

                <form method="POST" enctype="multipart/form-data">
                    <input type="file" name="qrcode" class="form-control mb-3" required>
                    <button type="submit" class="btn btn-success">Upload QR Code</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
     // If you want to preview the uploaded file before submission
     document.getElementById('siteLogo').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const previewImage = document.querySelector('.logo-preview');
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
    document.querySelector('[name="site_logo"]').addEventListener('change', function(event) {
        const reader = new FileReader();
        reader.onload = e => document.querySelector('.logo-preview').src = e.target.result;
        reader.readAsDataURL(event.target.files[0]);
    });
</script>

</body>
</html>