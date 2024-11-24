<?php
// Include database connection
include('../conn/conn.php');

// Initialize variables
$LogoPath = '';
$targetDir = "../logoimages/";

// Ensure the logo directory exists
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
}

// Fetch current logo
$sql = "SELECT * FROM tbl_logo WHERE u_id = 1 LIMIT 1"; // Replace 1 with dynamic user ID if needed
$stmt = $conn->prepare($sql);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    $LogoPath = $row['logo_path'];
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_FILES['logo']['name'])) {
        $newLogoName = basename($_FILES['logo']['name']);
        $newLogoPath = $targetDir . $newLogoName;

        // Upload file to server
        if (move_uploaded_file($_FILES['logo']['tmp_name'], $newLogoPath)) {
            $LogoPath = $newLogoName; // Update the logo path

            // Update or insert into the database
            if ($row) {
                $sql = "UPDATE tbl_logo SET logo_name = ?, logo_path = ? WHERE u_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(1, $newLogoName);
                $stmt->bindValue(2, $LogoPath);
                $stmt->bindValue(3, $row['u_id']);
            } else {
                $sql = "INSERT INTO tbl_logo (u_id, logo_name, logo_path) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(1, 1); // Static user ID (replace with dynamic ID if necessary)
                $stmt->bindValue(2, $newLogoName);
                $stmt->bindValue(3, $LogoPath);
            }

            if ($stmt->execute()) {
                echo "<script>alert('Logo updated successfully!');</script>";
                header("Refresh:0"); // Refresh the page to reflect changes
            } else {
                echo "<script>alert('Error updating the database.');</script>";
            }
        } else {
            echo "<script>alert('Error uploading the file.');</script>";
        }
    } else {
        echo "<script>alert('No file selected.');</script>";
    }
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
    <style>
        body {
            font-size: 0.9rem;
        }
        .sidebar {
            height: 100vh;
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        .sidebar-header h2 {
    font-size: 1.25rem; /* Smaller font size for the title */
    font-weight: bold;  /* Optional: Make it bold */
    margin-bottom: 20px; /* Optional: Adjust the space below the title */
}
        .sidebar .nav-link {
            color: #333;
            padding: 0.5rem 1rem;
        }
        .sidebar .nav-link:hover {
            background-color: #e9ecef;
        }
        .sidebar .nav-link.active {
            background-color: #0d6efd;
            color: white;
        }
        .main-content {
            padding: 15px;
        }
        .logo {
            max-width: 400px;
            margin: 50px auto;
            background: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .logo img {
            max-width: 150px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="main-container d-flex">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Admin Dashboard</h2>
            </div>
            <ul class="sidebar-menu">
                <a href="admindashboard.php" class="nav-link active">Dashboard</a>
                <a href="manage.php" class="nav-link">Manage Restaurants</a>
                <a href="customer.php" class="nav-link">View Customers</a>
                <a href="setting.php" class="nav-link">Settings</a>
                <a href="logout.php" class="nav-link">Logout</a>
            </ul>
        </aside>

        <!-- Main Content -->
        <div class="main-content w-100">
            <div class="logo">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="mb-3 text-center">
                        <?php if ($LogoPath): ?>
                            <img id="logoPreview" src="<?= "../logoimages/" . htmlspecialchars($LogoPath) ?>" alt="Logo">
                        <?php else: ?>
                            <p>No logo uploaded yet.</p>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="logoUpload" class="form-label"><strong>Change Logo:</strong></label>
                        <input type="file" class="form-control" id="logoUpload" name="logo" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Upload Logo</button>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript for logo preview -->
    <script>
        const logoUpload = document.getElementById('logoUpload');
        const logoPreview = document.getElementById('logoPreview');

        logoUpload.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = () => {
                    logoPreview.src = reader.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
