<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="astyle.css">
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
<div class="main-container">
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
    </div>

    <!-- Main content -->
    <main class="main-content">
        <h1 class="h4 mb-3">Dashboard</h1>

        <!-- Logo Upload Section -->
        <div class="logo">
            <form action="upload_logo.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3 text-center">
                    <img id="logoPreview" src="https://via.placeholder.com/150.png?text=Logo" alt="Logo">
                </div>
                <div class="mb-3">
                    <label for="logoUpload" class="form-label"><strong>Change Logo:</strong></label>
                    <input type="file" class="form-control" id="logoUpload" name="logo" accept="image/*">
                </div>
                <button type="submit" class="btn btn-primary w-100">Upload Logo</button>
            </form>
        </div>
    </main>
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

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
