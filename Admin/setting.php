<?php
// Database connection setup
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "restaurant_db"; // Change this to your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['logo'])) {
    $logo = $_FILES['logo'];
    $uploadDir = "uploads/"; // Folder to store uploaded logos
    $uploadFile = $uploadDir . basename($logo['name']);

    // Create the directory if it doesn't exist
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Check if the file is an image
    $check = getimagesize($logo['tmp_name']);
    if ($check !== false) {
        // Move the uploaded file
        if (move_uploaded_file($logo['tmp_name'], $uploadFile)) {
            $logoName = $logo['name'];
            $logoPath = $uploadFile;

            // Insert logo info into the database
            $stmt = $conn->prepare("INSERT INTO logos (logo_name, logo_path) VALUES (?, ?)");
            $stmt->bind_param("ss", $logoName, $logoPath);

            if ($stmt->execute()) {
                echo "<script>alert('Logo uploaded and saved to database successfully!');</script>";
            } else {
                echo "<script>alert('Database error: " . $stmt->error . "');</script>";
            }

            $stmt->close();
        } else {
            echo "<script>alert('Failed to upload the file.');</script>";
        }
    } else {
        echo "<script>alert('Uploaded file is not an image.');</script>";
    }
}

// Fetch the latest logo from the database
$logoPath = "https://via.placeholder.com/150.png?text=Logo"; // Default placeholder image
$result = $conn->query("SELECT * FROM logos ORDER BY uploaded_at DESC LIMIT 1");
if ($result && $row = $result->fetch_assoc()) {
    $logoPath = $row['logo_path'];
}
$conn->close();
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
      <a href="manage.php" class="nav-link"> Manage Restaurants</a>
      <a href="customer.php" class="nav-link">View Costumer </a>
      <a href="setting.php" class="nav-link"> Setting</a>
      <a href="index.php" class="nav-link">  Logout </a>
            </ul>
        </aside>

        <!-- Main Content -->
        <div class="main-content w-100">
            <div class="logo">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="mb-3 text-center">
                        <img id="logoPreview" src="<?= $logoPath ?>" alt="Logo">
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

    <!-- JavaScript -->
    <script>
        // JavaScript for logo preview
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
