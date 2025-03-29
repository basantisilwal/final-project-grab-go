<?php
// Include database connection
include('../conn/conn.php');

// Function to generate a random password (visible, not hashed)
function generatePassword($length = 8) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    return substr(str_shuffle($characters), 0, $length);
}

// Function to generate a unique username
function generateUsername($name) {
    return strtolower(str_replace(' ', '_', $name)) . rand(100, 999);
}

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $address = trim($_POST['address']);
    $date = $_POST['date'];
    $time = $_POST['time'];
    $email = trim($_POST['email']);
    $contact = trim($_POST['contact']);

    // Validate phone number (must start with 98 and have exactly 10 digits)
    if (!preg_match('/^98\d{8}$/', $contact)) {
        echo "<script>alert('Invalid contact number! It must start with 98 and be 10 digits long.');</script>";
    } else {
        if (!empty($_POST['id'])) {
            // Update existing owner
            $id = intval($_POST['id']);
            $stmt = $conn->prepare("UPDATE tbl_restaurantname SET name=?, address=?, date=?, time=?, email=?, contact_number=? WHERE r_id=?");
            $stmt->execute([$name, $address, $date, $time, $email, $contact, $id]);
            
            // Check if password was provided for update
            if (!empty($_POST['password'])) {
                $password = trim($_POST['password']);
                $stmt = $conn->prepare("UPDATE tbl_restaurant SET password=? WHERE id=?");
                $stmt->execute([$password, $id]);
            }
        } else {
            // Insert new owner into tbl_restaurantname
            $stmt = $conn->prepare("INSERT INTO tbl_restaurantname (name, address, date, time, email, contact_number) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $address, $date, $time, $email, $contact]);
            
            // Get the last inserted ID
            $last_id = $conn->lastInsertId();
            
            // Generate credentials for the new owner
            $username = generateUsername($name);
            $password = generatePassword();
            
            // Insert into tbl_restaurant with matching ID
            $stmt = $conn->prepare("INSERT INTO tbl_restaurant (id, username, password) VALUES (?, ?, ?)");
            $stmt->execute([$last_id, $username, $password]);
        }
        header("Location: manage.php");
        exit;
    }
}

// Handle Delete Request
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    
    // Delete from both tables
    $stmt = $conn->prepare("DELETE FROM tbl_restaurantname WHERE r_id=?");
    $stmt->execute([$id]);
    
    $stmt = $conn->prepare("DELETE FROM tbl_restaurant WHERE id=?");
    $stmt->execute([$id]);
    
    header("Location: manage.php");
    exit;
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
        .main-content {
            margin-left: 240px;
            padding: 20px;
            width: calc(100% - 240px);
        }
    </style>
</head>
<body>
    <div class="main-container d-flex">
        <!-- Sidebar -->
        <aside class="sidebar">

            <h2>Admin Dashboard</h2>
            <a href="admindashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a href="manage.php"><i class="bi bi-shop"></i> Manage Owner</a>
            <a href="customer.php"><i class="bi bi-people"></i> View Users</a>
            <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <h2>Add Owner</h2>
            <form method="POST">
                <?php
                $restaurant = null;
                $credentials = null;
                if (isset($_GET['edit_id'])) {
                    $id = intval($_GET['edit_id']);
                    $stmt = $conn->prepare("SELECT * FROM tbl_restaurantname WHERE r_id=?");
                    $stmt->execute([$id]);
                    $restaurant = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    $stmt = $conn->prepare("SELECT * FROM tbl_restaurant WHERE id=?");
                    $stmt->execute([$id]);
                    $credentials = $stmt->fetch(PDO::FETCH_ASSOC);
                }
                ?>
                <input type="hidden" name="id" value="<?php echo $restaurant['r_id'] ?? ''; ?>">
                <div class="mb-3">
                    <input type="text" class="form-control" name="name" placeholder="Owner Name" value="<?php echo $restaurant['name'] ?? ''; ?>" required>
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
                <?php if (isset($credentials)): ?>
                <div class="mb-3">
                    <label>Username:</label>
                    <input type="text" class="form-control" value="<?php echo $credentials['username'] ?? ''; ?>" readonly>
                </div>
                <div class="mb-3">
                    <label>Password:</label>
                    <input type="text" class="form-control" name="password" placeholder="Leave blank to keep current" value="">
                </div>
                <?php endif; ?>
                <button type="submit" class="btn btn-primary">
                    <?php echo isset($restaurant) ? 'Update' : 'Add'; ?> Owner
                </button>
            </form>

            <h3 class="mt-4">Owner List</h3>
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
                        <th>Username</th>
                        <th>Password</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $conn->query("SELECT r.*, u.username, u.password 
                                          FROM tbl_restaurantname r
                                          LEFT JOIN tbl_restaurant u ON r.r_id = u.id
                                          ORDER BY r.r_id DESC");
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
                              <td>{$restaurant['username']}</td>
                              <td>{$restaurant['password']}</td>
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