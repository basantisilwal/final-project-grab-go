<?php
session_start();
include('../conn/conn.php'); // Make sure this file has a MySQLi connection, e.g.:
// $conn = mysqli_connect("localhost", "root", "", "grab&go");
// if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

// -----------------------------
// 1. Handle Logo Upload
// -----------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['site_logo'])) {
    $target_dir = "uploads/logo/";
    // Create the directory if it doesn't exist
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Generate a unique file name to avoid conflicts
    $file_name = uniqid() . '_' . basename($_FILES['site_logo']['name']);
    $target_file = $target_dir . $file_name;
    $uploadOk = 1;
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
            // Use mysqli_real_escape_string for safety
            $logo_name = mysqli_real_escape_string($conn, $_FILES['site_logo']['name']);
            $logo_path = mysqli_real_escape_string($conn, $target_file);

            // Check if a logo record already exists
            $check_existing = "SELECT u_id FROM tbl_logo LIMIT 1";
            $existing_result = mysqli_query($conn, $check_existing);

            if (mysqli_num_rows($existing_result) > 0) {
                // Update existing logo record
                $update_query = "UPDATE tbl_logo 
                                 SET logo_name = '$logo_name', logo_path = '$logo_path'
                                 WHERE u_id = (SELECT u_id FROM tbl_logo LIMIT 1)";
                $result = mysqli_query($conn, $update_query);
            } else {
                // Insert a new record
                $insert_query = "INSERT INTO tbl_logo (logo_name, logo_path)
                                 VALUES ('$logo_name', '$logo_path')";
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

// -----------------------------
// 2. Fetch Current Logo
// -----------------------------
$current_logo = "logo.png"; // fallback if none in DB
$logoQuery = "SELECT logo_name, logo_path FROM tbl_logo LIMIT 1";
$logoResult = mysqli_query($conn, $logoQuery);

if ($row = mysqli_fetch_assoc($logoResult)) {
    // If a logo exists in DB, use that
    $current_logo = $row['logo_path'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logo Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Optionally include icons if needed -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, #f7b733, #fc4a1a);
            color: #fff;
            height: 100vh;
            display: flex;
            flex-direction: column;
            padding: 20px 15px;
            position: fixed;
            top: 0;
            left: 0;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.2);
        }
        .sidebar .logo-container img {
            width: 80px;
            border-radius: 50%;
            border: 2px solid black;
        }
        .sidebar h2 {
            font-size: 1.2rem;
            margin-bottom: 20px;
            color: #000;
            text-align: center;
        }
        .sidebar a {
            color: #000;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 10px;
            display: block;
            transition: background 0.3s;
            font-size: 1rem;
        }
        .sidebar a:hover {
            background-color: #000;
            color: #fff;
        }
        /* Main Container for page content */
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
    </style>
</head>
<body>

<!-- Sidebar -->
<aside class="sidebar">
    <div class="logo-container text-center mb-4">
        <!-- Display current logo from DB (or fallback if none) -->
        <img src="<?php echo htmlspecialchars($current_logo); ?>" alt="Admin Logo">
    </div>
    <h2>Admin Dashboard</h2>
    <a href="admindashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="manage.php"><i class="bi bi-shop"></i> Manage Restaurants</a>
    <a href="customer.php"><i class="bi bi-people"></i> View Customers</a>
    <a href="setting.php"><i class="bi bi-gear"></i> Settings</a>
    <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
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
                            <div id="logoPreviewContainer" class="mt-3 d-none">
                                <img id="logoPreview" src="" alt="Logo Preview" class="logo-preview">
                            </div>
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
</div>

<!-- Live Preview Script (Optional) -->
<script>
    document.getElementById('siteLogo').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const previewContainer = document.getElementById('logoPreviewContainer');
        const previewImage = document.getElementById('logoPreview');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.classList.remove('d-none');
            }
            reader.readAsDataURL(file);
        } else {
            previewContainer.classList.add('d-none');
        }
    });
</script>

</body>
</html>
