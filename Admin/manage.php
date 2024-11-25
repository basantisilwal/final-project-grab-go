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
        if ($stmt->execute([$name, $address, $date, $time, $email, $contact, $id])) {
            header("Location: manage.php");
            exit;
        } else {
            error_log("Failed to update restaurant with ID: $id");
        }
    } else {
        // Add New Restaurant
        $stmt = $conn->prepare("INSERT INTO tbl_restaurantname (name, address, date, time, email, contact_number) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$name, $address, $date, $time, $email, $contact])) {
            header("Location: manage.php");
            exit;
        } else {
            error_log("Failed to add restaurant: " . implode(" ", $stmt->errorInfo()));
        }
    }
}

// Handle Delete Request
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']); // Convert delete_id to an integer
    if ($id > 0) {
        $stmt = $conn->prepare("DELETE FROM tbl_restaurantname WHERE r_id=?");
        if ($stmt->execute([$id])) {
            header("Location: manage.php");
            exit;
        } else {
            error_log("Failed to delete restaurant with ID: $id");
        }
    } else {
        error_log("Invalid delete_id: $id");
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
    <title>Restaurant Management</title>
    <style>
        body {
            font-size: 0.9rem;
        }
        .sidebar {
      width: 250px;
      background-color: #000; /* Black background */
      color: #fff;
      height: 100vh;
      display: flex;
      flex-direction: column;
      padding: 20px 15px;
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
        .main-content {
            padding: 15px;
        }
    </style>
</head>
<body>
    <div class="main-container d-flex">
        <!-- Sidebar -->
         <!-- Sidebar -->
    <aside class="sidebar">
    <h2>Admin Dashboard</h2>
    <a href="admindashboard.php">Dashboard</a>
    <a href="manage.php">Manage Restaurants</a>
    <a href="customer.php">View Customers</a>
    <a href="setting.php">Settings</a>
    <a href="logout.php">Logout</a>
    </aside>

        <!-- Main Content -->
        <div class="container mt-4">
            <h2>Add / Edit Restaurant</h2>
            <form method="POST" id="restaurantForm">
                <?php
                $restaurant = null;
                if (isset($_GET['edit_id'])) {
                    $id = intval($_GET['edit_id']);
                    $stmt = $conn->prepare("SELECT * FROM tbl_restaurantname WHERE r_id=?");
                    $stmt->execute([$id]);
                    $restaurant = $stmt->fetch();
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
                try {
                    $stmt = $conn->query("SELECT * FROM tbl_restaurantname");
                    $restaurants = $stmt->fetchAll();
                    if ($restaurants) {
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
                                    <a href='?edit_id={$restaurant['r_id']}' class='btn btn-warning btn-sm'>
                                        <i class='bi bi-pencil'></i> 
                                    </a>
                                    <a href='?delete_id={$restaurant['r_id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>
                                        <i class='bi bi-trash'></i> 
                                    </a>
                                </td>
                              </tr>";
                            $sn++;
                        }
                    } else {
                        echo "<tr><td colspan='8'>No restaurants found</td></tr>";
                    }
                } catch (PDOException $e) {
                    echo "<tr><td colspan='8'>Error: " . $e->getMessage() . "</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
