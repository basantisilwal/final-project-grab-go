<?php
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

// Fetch all food items
$sql = "SELECT `f_id`, `food_name`, `description`, `price`, `category`, `image` FROM `tbl_addfood`";
$stmt = $conn->prepare($sql);
$stmt->execute();
$foodItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Food Items</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
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

/* Optional: Add icons next to menu items */
.sidebar a i {
    margin-right: 10px;
    font-size: 1.2rem;
}

        /* Content Styles */
        .container {
            flex-grow: 1;
            margin-left: 250px; /* Offset for fixed sidebar */
            max-width: 800px; /* Limit the width of the content */
            margin: auto; /* Center the content */
            padding: 15px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow-y: auto; /* Scroll if content overflows */
        }

        h1 {
            text-align: center;
            color: #000;
            font-size: 1.5rem;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        .form-group {
            margin-bottom: 10px;
        }

        .form-group label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
            font-size: 0.9rem;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #000;
            border-radius: 4px;
            font-size: 0.9rem;
        }

        textarea {
            resize: none;
        }

        .form-group #imagePreview {
            margin-top: 10px;
            max-height: 100px;
            border: 1px dashed #000;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .form-group #imagePreview img {
            max-height: 100%;
        }

        button {
            background: #000;
            color: #fff;
            padding: 8px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: background 0.3s;
        }

        button:hover {
            background: #000;
        }
    </style>
</head>
<body>
    <div class="main-layout">
        <!-- Sidebar -->
        <aside class="sidebar">
    <h2>Restaurant Dashboard</h2>
    <a href="das.php"><i class="fas fa-home"></i> Dashboard</a>
<a href="addfood.php"><i class="fas fa-utensils"></i> Add Food</a>
<a href="viewfood.php"><i class="fas fa-list"></i> View Food</a>
<a href="vieworder.php"><i class="fas fa-shopping-cart"></i> View Order</a>
<a href="managepayment.php"><i class="fas fa-money-bill"></i> View Payment</a>
<a href="account.php"><i class="fas fa-user"></i> Account</a>
<a href="updateprofile.php"><i class="fas fa-cog"></i> Profile</a>
<a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</aside>

<body>
    <div class="container mt-4">
        <h1 class="mb-4">Food Items</h1>
        
        <?php if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])): ?>
            <?php
            $foodId = $_GET['id'];
            $sql = "SELECT * FROM `tbl_addfood` WHERE `f_id` = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':id' => $foodId]);
            $foodItem = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>
            <form method="POST" enctype="multipart/form-data" class="mb-4">
                <input type="hidden" name="food_id" value="<?= htmlspecialchars($foodItem['f_id']) ?>">
                <input type="hidden" name="current_image" value="<?= htmlspecialchars($foodItem['image']) ?>">
                <div class="mb-3">
                    <label for="food_name" class="form-label">Food Name</label>
                    <input type="text" name="food_name" id="food_name" value="<?= htmlspecialchars($foodItem['food_name']) ?>" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" required><?= htmlspecialchars($foodItem['description']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" name="price" id="price" value="<?= htmlspecialchars($foodItem['price']) ?>" class="form-control" step="0.01" required>
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <input type="text" name="category" id="category" value="<?= htmlspecialchars($foodItem['category']) ?>" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label><br>
                    <img src="uploads/<?= htmlspecialchars($foodItem['image']) ?>" alt="Food Image" width="100" class="mb-2"><br>
                    <input type="file" name="image" id="image" class="form-control">
                </div>
                <button type="submit" name="update_food" class="btn btn-primary">Update Food</button>
                <a href="viewfood.php" class="btn btn-secondary">Cancel</a>
            </form>
        <?php else: ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Food Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($foodItems as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['f_id']) ?></td>
                            <td><?= htmlspecialchars($item['food_name']) ?></td>
                            <td><?= htmlspecialchars($item['description']) ?></td>
                            <td><?= htmlspecialchars($item['price']) ?></td>
                            <td><?= htmlspecialchars($item['category']) ?></td>
                            <td><img src="uploads/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['food_name']) ?>" width="100"></td>
                            <td>
                                <a href="viewfood.php?action=edit&id=<?= $item['f_id'] ?>" class="btn btn-success btn-sm">Edit</a>
                                <a href="viewfood.php?action=delete&id=<?= $item['f_id'] ?>" onclick="return confirm('Are you sure you want to delete this item?')" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
