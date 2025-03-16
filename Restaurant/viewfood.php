<?php
session_start();
include('../conn/conn.php'); // Include database connection

// Handle Delete Action
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $foodId = $_GET['id'];
    $deleteSql = "DELETE FROM `tbl_addfood` WHERE `f_id` = :id";
    $stmt = $conn->prepare($deleteSql);
    $stmt->execute([':id' => $foodId]);
    echo "<script>alert('Food item deleted successfully!'); window.location.href='viewfood.php';</script>";
}

// Handle Update Action
if (isset($_POST['update_food'])) {
    $foodId = $_POST['food_id'];
    $foodName = $_POST['food_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $image = $_POST['current_image'];

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $image = time() . "_" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/$image");
    }

    $updateSql = "UPDATE `tbl_addfood` SET 
        `food_name` = :food_name,
        `description` = :description,
        `price` = :price,
        `category` = :category,
        `image` = :image
        WHERE `f_id` = :id";
    $stmt = $conn->prepare($updateSql);
    $stmt->execute([
        ':food_name' => $foodName,
        ':description' => $description,
        ':price' => $price,
        ':category' => $category,
        ':image' => $image,
        ':id' => $foodId
    ]);

    echo "<script>alert('Food item updated successfully!'); window.location.href='viewfood.php';</script>";
}

// Handle Stock Update
if (isset($_POST['update_stock'])) {
    $foodId = $_POST['food_id'];
    $availability = $_POST['availability'];

    $updateStockSql = "UPDATE `tbl_addfood` SET `availability` = :availability WHERE `f_id` = :id";
    $stmt = $conn->prepare($updateStockSql);
    $stmt->execute([
        ':availability' => $availability,
        ':id' => $foodId
    ]);

    echo "<script>alert('Availability updated successfully!'); window.location.href='viewfood.php';</script>";
}

// Fetch all food items
$sql = "SELECT `f_id`, `food_name`, `description`, `price`, `category`, `image`, `availability` FROM `tbl_addfood`";
$stmt = $conn->prepare($sql);
$stmt->execute();
$foodItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch Logo
$current_logo = "logo.png"; // fallback if none in DB
$logoQuery    = "SELECT name, path FROM tbl_owlogo LIMIT 1";
$logoStmt     = $conn->prepare($logoQuery);
$logoStmt->execute();

if ($row = $logoStmt->fetch(PDO::FETCH_ASSOC)) {
    $current_logo = $row['path'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Food Items</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #FFE0B2;
            color: #333;
        }

        header {
            background-color: #555;
            color: white;
            text-align: center;
            padding: 20px;
        }

        /* Main Layout: Sidebar and Content */
        .main-layout {
            display: flex; /* Horizontal layout */
            height: 100vh; /* Full viewport height */
        }

        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, #f7b733, #fc4a1a); /* Gradient Background */
            color: #fff;
            height: 100vh;
            display: flex;
            flex-direction: column;
            padding: 20px;
            position: fixed;
            top: 0;
            left: 0;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.2); /* Soft shadow for depth */
        }

        .sidebar h2 {
            font-size: 1.4rem;
            font-weight: bold;
            margin-bottom: 20px;
            text-transform: uppercase;
            text-align: center;
            letter-spacing: 1px;
        }

        .sidebar a {
            color: #000;
            text-decoration: none;
            padding: 12px 15px;
            border-radius: 5px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            font-size: 1.1rem;
            transition: all 0.3s ease-in-out;
            font-weight: 500;
        }

        .sidebar a:hover {
            background: #000; /* Semi-transparent hover effect */
            color: #fff;
            transform: translateX(5px); /* Subtle movement effect */
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

        /* Content Styles */
        .container {
            flex-grow: 1;
            margin-left: 300px; /* Offset for fixed sidebar */
            max-width: 700px; /* Limit the width of the content */
            margin: auto; /* Center the content */
            padding: 5px;
            background-color: #FFE0B2;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow-y: auto; /* Scroll if content overflows */
        }

        h1 {
            text-align: center;
            color: #000;
            font-size: 1.5rem;
            border: 1px solid #000;
        }

        table td, table th {
            vertical-align: middle;
            border: 1px solid #000;
        }

        .food-item-img {
            width: 50px; /* Reduce width */
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
            border: 1px solid #000;
        }

        .btn-sm {
            font-size: 10px;
            padding: 2px 7px;
        }

    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="main-layout">
        <aside class="sidebar">
            <div class="logo-container">
                <img src="<?php echo htmlspecialchars($current_logo); ?>" alt="Logo">
            </div>
            <h2>Dashboard</h2>
            <a href="das.php"><i class="fas fa-home"></i> Dashboard</a>
            <a href="addfood.php"><i class="fas fa-utensils"></i> Add Food</a>
            <a href="viewfood.php"><i class="fas fa-list"></i> View Food</a>
            <a href="vieworder.php"><i class="fas fa-shopping-cart"></i> View Order</a>
            <a href="setting.php"><i class="bi bi-gear"></i> Settings</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </aside>

        <!-- Main Content -->
        <div class="container mt-4">
            <h1>Food Items</h1>
            <?php if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])): 
                $foodId = $_GET['id'];
                $sql = "SELECT * FROM `tbl_addfood` WHERE `f_id` = :id";
                $stmt = $conn->prepare($sql);
                $stmt->execute([':id' => $foodId]);
                $foodItem = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="food_id" value="<?= htmlspecialchars($foodItem['f_id']) ?>">
                <input type="hidden" name="current_image" value="<?= htmlspecialchars($foodItem['image']) ?>">
                <input type="text" name="food_name" value="<?= htmlspecialchars($foodItem['food_name']) ?>" required>
                <textarea name="description" required><?= htmlspecialchars($foodItem['description']) ?></textarea>
                <input type="number" name="price" value="<?= htmlspecialchars($foodItem['price']) ?>" step="0.01" required>
                <input type="text" name="category" value="<?= htmlspecialchars($foodItem['category']) ?>" required>
                <input type="file" name="image">
                <button type="submit" name="update_food">Update Food</button>
            </form>
            <?php endif; ?>

            <table class="table">
                <thead>
                    <tr>
                        <th>Serial No</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Image</th>
                        <th>Actions</th>
                        <th>Availability</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($foodItems as $index => $item): ?>
                    <tr>
                        <td><?= $index + 1 ?></td> <!-- Displaying serial number -->
                        <td><?= htmlspecialchars($item['food_name']) ?></td>
                        <td><?= htmlspecialchars($item['description']) ?></td>
                        <td><?= htmlspecialchars($item['price']) ?></td>
                        <td><?= htmlspecialchars($item['category']) ?></td>
                        <td><img src="uploads/<?= htmlspecialchars($item['image']) ?>" width="50"></td>
                        <td>
                            <a href="viewfood.php?action=edit&id=<?= $item['f_id'] ?>" class="btn btn-success btn-sm"><i class="fas fa-edit"></i></a>
                            <a href="viewfood.php?action=delete&id=<?= $item['f_id'] ?>" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                        </td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="food_id" value="<?= $item['f_id'] ?>">
                                <select name="availability" onchange="this.form.submit()">
                                    <option value="available" <?= $item['availability']=='available'?'selected':'' ?>>Available</option>
                                    <option value="unavailable" <?= $item['availability']=='unavailable'?'selected':'' ?>>Unavailable</option>
                                </select>
                                <input type="hidden" name="update_stock" value="1">
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
