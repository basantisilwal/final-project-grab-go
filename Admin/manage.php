<?php include ('../conn/conn.php');

// Form Submission Handler
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];

    // Insert Data into Database
    $stmt = $conn->prepare("INSERT INTO tbl_restaurantname (name, address, date, time, email, contact_number) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $address, $date, $time, $email, $contact]);
    if ($stmt->execute()) {
        echo "<script>alert('New restaurant added successfully');</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }
    $stmt->null();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <title>Restaurant Management System</title>
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
    </style>
</head>
<body>
    <div class="main-container d-flex">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Admin Dashboard</h2>
            </div>
            <ul class="list-unstyled">
                <a href="admindashboard.php" class="nav-link active">Dashboard</a>
                <a href="manage.php" class="nav-link">Manage Restaurants</a>
                <a href="customer.php" class="nav-link">View Customers</a>
                <a href="setting.php" class="nav-link">Setting</a>
                <a href="index.php" class="nav-link">Logout</a>
            </ul>
        </aside>

        <!-- Main Content -->
        <div class="container">
            <h2 class="mt-3">Add New Restaurant</h2>
            <form id="restaurantForm" method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Restaurant's Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control" id="address" name="address" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" class="form-control" id="date" name="date" required>
                </div>
                <div class="mb-3">
                    <label for="time" class="form-label">Time</label>
                    <input type="time" class="form-control" id="time" name="time" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email ID</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="contact" class="form-label">Contact_Number</label>
                    <input type="tel" class="form-control" id="contact" name="contact" required>
                </div>
                <button type="submit" class="btn btn-primary">Add Restaurant</button>
            </form>

            <h3 class="mt-4">Restaurant List</h3>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Restaurant's Name</th>
                        <th>Address</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Email</th>
                        <th>Contact_Number</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                // Fetch Data from Database
                $sql = "SELECT * FROM tbl_restaurantname";
                $result = $conn->query($sql);

                if ($result->rowCount() > 0) {
                    $sn = 1;
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>
                                <td>" . $sn++ . "</td>
                                <td>" . $row['name'] . "</td>
                                <td>" . $row['address'] . "</td>
                                <td>" . $row['date'] . "</td>
                                <td>" . $row['time'] . "</td>
                                <td>" . $row['email'] . "</td>
                                <td>" . $row['contact_number'] . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No data found</td></tr>";
                }
                // Close Connection
                $conn = null;
                ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
