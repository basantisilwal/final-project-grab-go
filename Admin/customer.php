<?php 
include('../conn/conn.php'); 
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
        body {
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            font-family: Arial, sans-serif;
            background-color: #FFE0B2;
        }
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
        .content {
            flex-grow: 1;
            padding: 40px;
            background-color: #FFE0B2;
            margin-left: 220px;
            max-width: 900px;
        }
        table {
            width: 100%;
            font-size: 0.9rem;
            border-collapse: collapse;
        }
        table th, table td {
            padding: 10px;
            text-align: center;
            border: 1px solid #000;
        }
        table th {
            background-color: rgb(1, 7, 13);
            color: #000;
        }
        .btn-sm {
            font-size: 0.75rem;
            padding: 3px 6px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
    <div class="logo-container">
            <img src="logo.png" alt="Admin Logo"> <!-- Replace with actual logo -->
        </div>
        <h2>Admin Panel</h2>
        <a href="admindashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a href="manage.php"><i class="bi bi-shop"></i> Manage Restaurants</a>
            <a href="customer.php"><i class="bi bi-people"></i> View Customers</a>
            <a href="setting.php"><i class="bi bi-gear"></i> Settings</a>
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
                        $sn = 1; // Serial Number Counter
                        
                        foreach ($users as $user) { ?>
                            <tr>
                                <td><?= $sn++; ?></td> <!-- Sequential Serial Number -->
                                <td><?= htmlspecialchars($user['first_name']); ?></td>
                                <td><?= htmlspecialchars($user['last_name']); ?></td>
                                <td><?= htmlspecialchars($user['contact_number']); ?></td>
                                <td><?= htmlspecialchars($user['email']); ?></td>
                                <td><?= htmlspecialchars($user['username']); ?></td>
                                <td>
                                    <button onclick="deleteUser(<?= $user['tbl_user_id']; ?>)" class="btn btn-danger btn-sm">Delete</button>
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
    
    <script>
        function deleteUser(id) {
            if (confirm('Are you sure you want to delete this user?')) {
                window.location.href = `delete_user.php?id=${id}`;
            }
        }
    </script>
</body>
</html>
