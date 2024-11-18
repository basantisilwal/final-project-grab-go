<?php
// Include the database connection
include ('../conn/conn.php');

// Form Submission Handler
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // For Adding New Restaurant
    if (!isset($_POST['id'])) {
        // Retrieve POST data
        $name = $_POST['name'];
        $address = $_POST['address'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $email = $_POST['email'];
        $contact = $_POST['contact'];

        try {
            // Prepare an SQL statement to insert data
            $stmt = $conn->prepare("INSERT INTO tbl_restaurantname (name, address, date, time, email, contact_number) VALUES (?, ?, ?, ?, ?, ?)");

            // Execute the statement with provided values
            if ($stmt->execute([$name, $address, $date, $time, $email, $contact])) {
                echo "<script>alert('New restaurant added successfully');</script>";
            } else {
                echo "<script>alert('Failed to add restaurant. Please try again.');</script>";
            }

        } catch (PDOException $e) {
            echo "<script>alert('Database Error: " . $e->getMessage() . "');</script>";
        }
    } elseif (isset($_POST['id'])) {
        // For Editing Existing Restaurant
        $id = $_POST['id'];
        $name = $_POST['name'];
        $address = $_POST['address'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $email = $_POST['email'];
        $contact = $_POST['contact'];

        $stmt = $conn->prepare("UPDATE tbl_restaurantname SET name=?, address=?, date=?, time=?, email=?, contact_number=? WHERE r_id=?");
        if ($stmt->execute([$name, $address, $date, $time, $email, $contact, $id])) {
            echo "<script>alert('Restaurant updated successfully'); window.location.href='manage.php';</script>";
        } else {
            echo "<script>alert('Failed to update restaurant');</script>";
        }
    }
}

// Delete restaurant
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $stmt = $conn->prepare("DELETE FROM tbl_restaurantname WHERE r_id=?");
    if ($stmt->execute([$id])) {
        echo "<script>alert('Restaurant deleted'); window.location.href='manage.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Restaurant Management System</title>
</head>
<body>
    <div class="container mt-4">
        <h2>Add / Edit Restaurant</h2>
        <form method="POST" id="restaurantForm">
            <?php if (isset($_GET['edit_id'])):
                $id = $_GET['edit_id'];
                $stmt = $conn->prepare("SELECT * FROM tbl_restaurantname WHERE r_id=?");
                $stmt->execute([$id]);
                $restaurant = $stmt->fetch();
            ?>
            <input type="hidden" name="id" value="<?php echo $restaurant['r_id']; ?>">
            <?php endif; ?>
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
                                <a href='?edit_id={$restaurant['r_id']}' class='btn btn-warning btn-sm'>Edit</a>
                                <a href='?delete_id={$restaurant['r_id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>Delete</a>
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
</body>
</html>
