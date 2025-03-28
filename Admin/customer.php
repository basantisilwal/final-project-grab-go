<?php  
include('../conn/conn.php');  

// Fetch Logo
$current_logo = "logo.png"; // fallback if none in DB
$logoQuery    = "SELECT name, path FROM tbl_logo LIMIT 1";
$logoStmt     = $conn->prepare($logoQuery);
$logoStmt->execute();

if ($row = $logoStmt->fetch(PDO::FETCH_ASSOC)) {
    $current_logo = $row['path'];
}

// Handle user deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];
    try {
        $stmt = $conn->prepare("DELETE FROM tbl_otp WHERE tbl_user_id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            echo "<script>alert('User deleted successfully!'); window.location.href='customer.php';</script>";
            exit();
        } else {
            echo "<script>alert('Failed to delete user.');</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <title>Admin Panel</title>
    <style>
        body { display: flex; 
            height: 100vh;
             font-family: Arial, sans-serif; 
            background-color: #fff; }
        /* Sidebar Styles */
    .sidebar {
      width: 220px;
      background: linear-gradient(135deg, #f7b733, #fc4a1a);
      color: #fff;
      height: 100vh;
      display: flex;
      flex-direction: column;
      padding: 15px;
      position: fixed;
      top: 0;
      left: 0;
      box-shadow: 3px 0 8px rgba(0, 0, 0, 0.2);
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
    .sidebar a {
      color: black;
      text-decoration: none;
      padding: 10px;
      display: flex;
      align-items: center;
      transition: 0.3s;
      font-size: 1rem;
    }
    .sidebar h2 {
      font-size: 1.1rem;
      margin-bottom: 15px;
      color: #000;
      font-weight: bold;
      text-align: center;
      padding-bottom: 10px;
      border-bottom: 2px solid #d4b870;
    }
    .sidebar a:hover {
      background-color: black;
      color: #fff;
    }
    .logo-container {
    width: 100px;  /* Set width */
    height: 100px; /* Set height */
    border-radius: 50%; /* Make it circular */
    overflow: hidden; /* Ensure the image stays within the boundary */
    margin: 10px auto; /* Center it */
    display: flex;
    align-items: center;
    justify-content: center;
    background: white; /* Optional: Adds contrast */
}

.logo-container img {
    width: 100%;  /* Make sure it fits the container */
    height: 100%; /* Make sure it fits the container */
    object-fit: cover; /* Ensure proper scaling */
    border-radius: 50%; /* Maintain circular shape */
}
        .content { 
            flex-grow: 1; 
            padding: 40px; 
            background-color: #fff; 
            margin-left: 220px;
             max-width: 900px; }
        table { 
            width: 100%; 
            font-size: 0.9rem;
             border-collapse: collapse; }
        table th, table td { 
            padding: 10px; 
            text-align: center; 
            border: 1px solid #000; }
        table th { 
            background-color: rgb(1, 7, 13); 
            color: #000; }
        .btn-sm {
             font-size: 0.75rem; 
             padding: 3px 6px; }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="main-container d-flex">
        <aside class="sidebar">
        <div class="logo-container">
                <img src="<?php echo htmlspecialchars($current_logo); ?>" alt="Logo">
            </div>
            <h2>Admin Dashboard</h2>
            <a href="admindashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a href="manage.php"><i class="bi bi-shop"></i> Manage Owner</a>
            <a href="customer.php"><i class="bi bi-people"></i> View Users</a>
            <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </aside>

        <!-- Content -->
        <div class="content">
            <h4>Users List</h4>
            <hr>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Contact</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        try {
                            $stmt = $conn->prepare("SELECT * FROM tbl_otp ORDER BY tbl_user_id ASC");
                            $stmt->execute();
                            $users = $stmt->fetchAll();
                            $sn = 1;

                            foreach ($users as $user) { ?>
                                <tr>
                                    <td><?= $sn++; ?></td>
                                    <td><?= htmlspecialchars($user['first_name']); ?></td>
                                    <td><?= htmlspecialchars($user['last_name']); ?></td>
                                    <td><?= htmlspecialchars($user['contact_number']); ?></td>
                                    <td><?= htmlspecialchars($user['email']); ?></td>
                                    <td><?= htmlspecialchars($user['username']); ?></td>
                                    <td>
                                        <form method="POST" style="display:inline;">
                                            <input type="hidden" name="delete_id" value="<?= $user['tbl_user_id']; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php }
                        } catch (PDOException $e) {
                            echo "<tr><td colspan='7' class='text-danger'>Error: " . $e->getMessage() . "</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
