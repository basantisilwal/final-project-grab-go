<?php
// Include the database connection
include('../conn/conn.php');

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Add or Update Restaurant
    $name = $_POST['name'];
    $address = $_POST['address'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];

    if (isset($_POST['id']) && !empty($_POST['id'])) {
        // Update Restaurant
        $id = intval($_POST['id']);
        $stmt = $conn->prepare("UPDATE tbl_restaurantname SET name=?, address=?, date=?, time=?, email=?, contact_number=? WHERE r_id=?");
        $stmt->execute([$name, $address, $date, $time, $email, $contact, $id]);
    } else {
        // Add New Restaurant
        $stmt = $conn->prepare("INSERT INTO tbl_restaurantname (name, address, date, time, email, contact_number) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $address, $date, $time, $email, $contact]);
    }
    header("Location: manage.php");
    exit;
}

// Handle Delete Request
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM tbl_restaurantname WHERE r_id=?");
    $stmt->execute([$id]);
    header("Location: manage.php");
    exit;
}

// Fetch logo details (Fixed PDO query)
$current_logo = "logo.png"; // fallback if none in DB
$logoQuery = $conn->prepare("SELECT logo_name, logo_path FROM tbl_logo LIMIT 1");
$logoQuery->execute();
$row = $logoQuery->fetch(PDO::FETCH_ASSOC);

if ($row) {
    $current_logo = $row['logo_path'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <title>Restaurant Management</title>
    <style>
        body {
            font-size: 0.9rem;
            background-color: #FFE0B2;
        }
        .container {
            padding: 8px;
            margin: auto;
            max-width: 720px;
        }
        .form-control {
            border: 2px solid black !important;
            padding: 5px;
            font-size: 14px;
        }
        .btn-primary {
            background-color: black !important;
            border: 2px solid black !important;
            color: white;
        }
        .table {
            border: 2px solid black !important;
        }
        .table th, .table td {
            border: 2px solid black !important;
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
    </style>
</head>
<body>
    <div class="main-container d-flex">
        <!-- Sidebar -->
        <aside class="sidebar">
    <div class="logo-container">
        <img src="<?php echo htmlspecialchars($current_logo); ?>" alt="Admin Logo">
    </div>
    <h2>Admin Dashboard</h2>
    <a href="admindashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="manage.php"><i class="bi bi-shop"></i> Manage Restaurants</a>
    <a href="customer.php"><i class="bi bi-people"></i> View Customers</a>
    <a href="setting.php"><i class="bi bi-gear"></i> Settings</a>
    <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
</aside>


        <!-- Main Content -->
        <div class="main-content container mt-4">
            <h2>Add / Edit Restaurant</h2>
            <form method="POST">
                <?php
                $restaurant = null;
                if (isset($_GET['edit_id'])) {
                    $id = intval($_GET['edit_id']);
                    $stmt = $conn->prepare("SELECT * FROM tbl_restaurantname WHERE r_id=?");
                    $stmt->execute([$id]);
                    $restaurant = $stmt->fetch(PDO::FETCH_ASSOC);
                }
                ?>
                <input type="hidden" name="id" value="<?php echo $restaurant['r_id'] ?? ''; ?>">
                <div class="mb-3">
                    <input type="text" class="form-control" name="name" placeholder="Restaurant Name" value="<?php echo $restaurant['name'] ?? ''; ?>" required>
                </div>
                <div class="mb-3">
                    <textarea class="form-control" name="address" placeholder="Address" required><?php echo $restaurant['address'] ?? ''; ?></textarea>
                </div>
                <div class="mb-3">
                    <input type="date" class="form-control" name="date" value="<?php echo $restaurant['date'] ?? ''; ?>" required>
                </div>
                <div class="mb-3">
                    <input type="time" class="form-control" name="time" value="<?php echo $restaurant['time'] ?? ''; ?>" required>
                </div>
                <div class="mb-3">
                    <input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo $restaurant['email'] ?? ''; ?>" required>
                </div>
                <div class="mb-3">
                    <input type="tel" class="form-control" name="contact" placeholder="Contact Number" value="<?php echo $restaurant['contact_number'] ?? ''; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">
                    <?php echo isset($restaurant) ? 'Update' : 'Add'; ?> Restaurant
                </button>
            </form>

            <h3 class="mt-4">Restaurant List</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $stmt = $conn->query("SELECT * FROM tbl_restaurantname");
                $restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $sn = 1;
                foreach ($restaurants as $restaurant) {
                    echo "<tr>
                            <td>{$sn}</td>
                            <td>{$restaurant['name']}</td>
                            <td>{$restaurant['address']}</td>
                            <td>{$restaurant['date']}</td>
                            <td>{$restaurant['time']}</td>
                            <td>{$restaurant['email']}</td>
                            <td>{$restaurant['contact_number']}</td>
                            <td>
                                <a href='?edit_id={$restaurant['r_id']}' class='btn btn-warning btn-sm'><i class='bi bi-pencil'></i></a>
                                <a href='?delete_id={$restaurant['r_id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'><i class='bi bi-trash'></i></a>
                            </td>
                          </tr>";
                    $sn++;
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
