<?php
session_start();

/***************************************************
 * 1. Database Connection (MySQLi)
 ***************************************************/
$host = "localhost";       // Adjust if different
$user = "root";            // Your DB username
$pass = "";                // Your DB password
$db   = "grab&go";         // Your DB name

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

/***************************************************
 * 2. Handle Logo Upload
 ***************************************************/
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['site_logo'])) {
    $target_dir = "uploads/logo/";
    // Create the directory if it doesn't exist
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Generate a unique file name to avoid conflicts
    $file_name   = uniqid() . '_' . basename($_FILES['site_logo']['name']);
    $target_file = $target_dir . $file_name;
    $uploadOk    = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Allowed file types
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (!in_array($imageFileType, $allowed_types)) {
        $_SESSION['error_message'] = "Only JPG, JPEG, PNG, GIF, and WEBP files are allowed.";
        $uploadOk = 0;
    }

    // Move file if valid
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES['site_logo']['tmp_name'], $target_file)) {
            // Escape data for safety
            $name = mysqli_real_escape_string($conn, $_FILES['site_logo']['name']);
            $path = mysqli_real_escape_string($conn, $target_file);

            // Check if a logo record already exists
            $check_existing = "SELECT o_id FROM tbl_owlogo LIMIT 1";
            $existing_result = mysqli_query($conn, $check_existing);

            if (mysqli_num_rows($existing_result) > 0) {
                // Update existing logo record
                $update_query = "UPDATE tbl_owlogo 
                                 SET name = '$name', path = '$path'
                                 WHERE o_id = (SELECT o_id FROM tbl_owlogo LIMIT 1)";
                $result = mysqli_query($conn, $update_query);
            } else {
                // Insert a new record
                $insert_query = "INSERT INTO tbl_owlogo (name, path)
                                 VALUES ('$name', '$path')";
                $result = mysqli_query($conn, $insert_query);
            }

            if ($result) {
                $_SESSION['success_message'] = "Logo uploaded successfully!";
            } else {
                $_SESSION['error_message'] = "Database error: " . mysqli_error($conn);
            }
        } else {
            $_SESSION['error_message'] = "Sorry, there was an error uploading your file.";
        }
    }
    // Refresh the page to show messages and updated logo
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Fetch Logo
$current_logo = "logo.png"; // fallback if none in DB
$logoQuery    = "SELECT name, path FROM tbl_logo LIMIT 1";
$logoStmt     = $conn->prepare($logoQuery);
$logoStmt->execute();

if ($row = $logoStmt->fetch(PDO::FETCH_ASSOC)) {
    $current_logo = $row['path'];
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
   <?php
include('../conn/conn.php');
$qr_path = "default_qr.png"; // Set default QR if none found

// Handle QR upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['qrcode'])) {
    $target_dir = "uploads/qr/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_name = uniqid() . '_' . basename($_FILES['qrcode']['name']);
    $target_file = $target_dir . $file_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $max_file_size = 5 * 1024 * 1024; // 5MB

    if (!in_array($imageFileType, $allowed_types)) {
        $_SESSION['error_message_qr'] = "Only JPG, JPEG, PNG, GIF, and WEBP files are allowed.";
    } elseif ($_FILES['qrcode']['size'] > $max_file_size) {
        $_SESSION['error_message_qr'] = "File size should not exceed 5MB.";
    } elseif (!move_uploaded_file($_FILES['qrcode']['tmp_name'], $target_file)) {
        $_SESSION['error_message_qr'] = "Failed to upload QR code.";
    } else {
        $qr_path = $target_file;

        $check_existing = $conn->query("SELECT q_id FROM tbl_qr LIMIT 1");
        $existing_result = $check_existing->fetch(PDO::FETCH_ASSOC);

        if ($existing_result) {
            $update_query = $conn->prepare("UPDATE tbl_qr SET qr_path = :qr_path WHERE q_id = :q_id");
            $update_query->execute(['qr_path' => $qr_path, 'q_id' => $existing_result['q_id']]);
        } else {
            $insert_query = $conn->prepare("INSERT INTO tbl_qr (qr_path) VALUES (:qr_path)");
            $insert_query->execute(['qr_path' => $qr_path]);
        }

        $_SESSION['success_message_qr'] = "QR code uploaded successfully!";
    }

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Fetch existing QR code if available
$qr_fetch = $conn->query("SELECT qr_path FROM tbl_qr LIMIT 1");
if ($row = $qr_fetch->fetch(PDO::FETCH_ASSOC)) {
    $qr_path = $row['qr_path'];
}
?>
<!-- Now safely output your HTML part -->
<div class="container mt-5">
    <div class="small-container">
        <div class="card">
            <div class="card-body text-center">
                <h5>QR Code Management</h5>
                <img id="qr-preview" src="<?php echo htmlspecialchars($qr_path); ?>" alt="QR Code" class="logo-preview mb-4" style="max-width: 200px;">
                <form method="POST" enctype="multipart/form-data">
                    <input type="file" name="qrcode" id="qrcode" class="form-control mb-3" required>
                    <button type="submit"  a href="setting.php" class="btn btn-success">Upload QR Code</button>
                </form>
                <!-- Success/Error Messages -->
                <?php if (isset($_SESSION['success_message_qr'])): ?>
                    <div class="alert alert-success mt-3"><?php echo $_SESSION['success_message_qr']; unset($_SESSION['success_message_qr']); ?></div>
                <?php endif; ?>
                <?php if (isset($_SESSION['error_message_qr'])): ?>
                    <div class="alert alert-danger mt-3"><?php echo $_SESSION['error_message_qr']; unset($_SESSION['error_message_qr']); ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>



<!-- Optional JS for Live Preview (if desired) -->
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
    document.getElementById('qrcode').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => document.getElementById('qr-preview').src = e.target.result;
            reader.readAsDataURL(file);
        }
    });
</script>

</body>
</html>