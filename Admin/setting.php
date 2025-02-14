
<?php
session_start();
include('../conn/conn.php');// Ensure this file connects to 'grab&go' database

// Handle Logo Upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['site_logo'])) {
    $target_dir = "uploads/logo/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_name = uniqid() . '_' . basename($_FILES['site_logo']['name']);
    $target_file = $target_dir . $file_name;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validate File Type
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (!in_array($imageFileType, $allowed_types)) {
        $_SESSION['error_message'] = "Only JPG, JPEG, PNG, GIF, and WEBP files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES['site_logo']['tmp_name'], $target_file)) {
            $logo_name = mysqli_real_escape_string($conn, $_FILES['site_logo']['name']);
            $logo_path = mysqli_real_escape_string($conn, $target_file);

            // Check if a logo already exists
            $check_existing = "SELECT u_id FROM tbl_logo LIMIT 1";
            $existing_result = mysqli_query($conn, $check_existing);

            if (mysqli_num_rows($existing_result) > 0) {
                $update_query = "UPDATE tbl_logo SET logo_name = '$logo_name', logo_path = '$logo_path' WHERE u_id = (SELECT u_id FROM tbl_logo LIMIT 1)";
                $result = mysqli_query($conn, $update_query);
            } else {
                $insert_query = "INSERT INTO tbl_logo (logo_name, logo_path) VALUES ('$logo_name', '$logo_path')";
                $result = mysqli_query($conn, $insert_query);
            }

            $_SESSION['success_message'] = $result ? "Logo uploaded successfully!" : "Database error: " . mysqli_error($conn);
        } else {
            $_SESSION['error_message'] = "Sorry, there was an error uploading your file.";
        }
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Fetch Current Logo
$current_logo = "";
$result = mysqli_query($conn, "SELECT logo_path FROM tbl_logo LIMIT 1");
if ($row = mysqli_fetch_assoc($result)) {
    $current_logo = $row['logo_path'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logo Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .sidebar {
            width: 250px;
    background: linear-gradient(135deg, #f7b733, #fc4a1a); /* Gradient Background */
    color: #fff;
    height: 100vh;
    display: flex;
    flex-direction: column;
    padding: 20px 15px;
    position: fixed;
    top: 0;
    left: 0;
    box-shadow: 4px 0 10px rgba(0, 0, 0, 0.2); /* Soft shadow for depth */
    }

    .sidebar h2 {
      font-size: 1.2rem;
      margin-bottom: 20px;
    }

    .sidebar a {
      color: #ff6700; /* Orange text */
      text-decoration: none;
      padding: 10px 15px;
      border-radius: 5px;
      margin-bottom: 10px;
      display: block;
      transition: background 0.3s;
    }

    .sidebar a:hover {
      background-color: #ff6700;
      color: #fff;
    }

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
<div class="main-container d-flex">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo-container">
            <img src="logo.png" alt="Admin Logo"> <!-- Replace with actual logo -->
        </div>

        <h2>Admin Dashboard</h2>

        <a href="admindashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
        <a href="manage.php"><i class="bi bi-shop"></i> Manage Restaurants</a>
        <a href="customer.php"><i class="bi bi-people"></i> View Customers</a>
        <a href="setting.php"><i class="bi bi-gear"></i> Settings</a>
        <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </aside>
<body class="bg-light">
    <div class="container mt-5">
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-header text-center">
                    <h5 class="mb-0">Logo Management</h5>
                </div>
                <div class="card-body text-center">
                    <?php if (!empty($current_logo)): ?>
                        <div class="logo-preview-container mb-4">
                            <img src="<?php echo htmlspecialchars($current_logo); ?>" alt="Current Logo" class="logo-preview">
                        </div>
                    <?php endif; ?>

                    <!-- Upload Form -->
                    <form id="logoUploadForm" method="POST" enctype="multipart/form-data">
                        <div class="mb-4">
                            <input type="file" name="site_logo" id="siteLogo" accept="image/png,image/jpeg,image/gif,image/webp" class="form-control" required>
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
                        <div class="alert alert-success mt-3"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['error_message'])): ?>
                        <div class="alert alert-danger mt-3"><?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Logo Preview Script -->
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
