<?php
// Include the database connection
include('../conn/conn.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    // Add Food Item
    if ($action === 'add') {
        $foodName = $_POST['food-name'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $description = $_POST['description'];
        $image = $_FILES['image'];

        // Handle image upload
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($image['name']);

        if (move_uploaded_file($image['tmp_name'], $targetFile)) {
            $imagePath = $targetFile;
        } else {
            die("Error uploading image.");
        }

        $sql = "INSERT INTO tbl_addfood (food_name, price, category, description, image) 
                VALUES (:food_name, :price, :category, :description, :image)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':food_name', $foodName);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image', $imagePath);

        if ($stmt->execute()) {
            echo "<script>alert('Food item added successfully.');</script>";
        } else {
            echo "<script>alert('Error adding food item.');</script>";
        }
    }

    // Edit Food Item
    if ($action === 'edit') {
        $foodId = $_POST['food_id'];
        $foodName = $_POST['food-name'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $description = $_POST['description'];
        $image = $_FILES['image'];

        $sqlUpdate = "UPDATE tbl_addfood 
                      SET food_name = :food_name, price = :price, category = :category, description = :description";

        if (!empty($image['name'])) {
            // Handle image upload
            $targetDir = "uploads/";
            $targetFile = $targetDir . basename($image['name']);

            if (move_uploaded_file($image['tmp_name'], $targetFile)) {
                $imagePath = $targetFile;
                $sqlUpdate .= ", image = :image";
            } else {
                die("Error uploading image.");
            }
        }

        $sqlUpdate .= " WHERE f_id = :food_id";
        $stmt = $conn->prepare($sqlUpdate);
        $stmt->bindParam(':food_name', $foodName);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':food_id', $foodId);

        if (!empty($image['name'])) {
            $stmt->bindParam(':image', $imagePath);
        }

        if ($stmt->execute()) {
            echo "<script>alert('Food item updated successfully.');</script>";
        } else {
            echo "<script>alert('Error updating food item.');</script>";
        }
    }
}

// Fetch Food Items
$foodItems = [];
$sql = "SELECT * FROM tbl_addfood";
$stmt = $conn->query($sql);

if ($stmt->rowCount() > 0) {
    $foodItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="rstyle.css">
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
        .main-container {
    display: flex;
}

.sidebar {
    flex: 0 0 250px; /* Sidebar width */
}

.main-content {
    flex: 1;
    display: flex;
    justify-content: flex-end; /* Align the panel to the right */
    padding: 1px; /* Add padding for spacing */
}

.add-food-panel {
  text-align: center;
      background-color: #ffffff;
      border-radius: 10px;
            padding: 310px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
    .add-food-panel h2 {
      margin-top: 0;
      font-size: 24px;
      color: #333;
      text-align: center;
    }
    .form-group {
      margin-bottom: 15px;
    }
    .form-group label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }
    .form-group input[type="text"],
    .form-group input[type="number"],
    .form-group select,
    .form-group textarea {
      width: 100%;
      padding: 8px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }
    .form-group textarea {
      resize: vertical;
    }
    .form-group input[type="file"] {
      font-size: 16px;
    }
    .button-group {
      display: flex;
      justify-content: space-between;
    }
    .button-group button {
      padding: 10px 15px;
      font-size: 16px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      width: 48%;
    }
    .button-group .save-btn {
      background-color: #ff6699;;
      color: white;
    }
    .button-group .edit-btn {
      background-color: #ff6699;
      color: white;
    }
  

    </style>
</head>
<body>
<div class="main-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Restaurant Dashboard</h2>
            </div>
            <ul class="sidebar-menu">
            <a href="restaurantdashboard.php" class="nav-link active">Dashboard</a>
      <a href="addfood.php" class="nav-link"> Add Food</a>
      <a href="updateprofile.php" class="nav-link">Update profile</a>
      <a href="viewfood.php" class="nav-link">View Food </a>
      <a href="account.php" class="nav-link"> Accounts</a>
      <a href="index.php" class="nav-link">  Logout </a>
            </ul>
        </aside>
    </div>
<div class="add-food-panel">
  <h2>Add/Edit Food Item</h2>
  <form id="food-form">
    <!-- Food Name -->
    <div class="form-group">
      <label for="food-name">Food Name:</label>
      <input type="text" id="food-name" name="food-name" class="form-control" required>
    </div>
    
    <!-- Price -->
    <div class="form-group">
      <label for="price">Price:</label>
      <input type="number" id="price" name="price" class="form-control" required>

    <!-- Category -->
    <div class="form-group">
      <label for="category">Category:</label>
      <select id="category" name="category" class="form-control" required>
        <option value="">Select a category</option>
        <option value="appetizer">Appetizer</option>
        <option value="main-course">Main Course</option>
        <option value="dessert">Dessert</option>
        <option value="beverage">Beverage</option>
      </select>
    </div>

    <!-- Description -->
    <div class="form-group">
      <label for="description">Description:</label>
      <textarea id="description" name="description" class="form-control" rows="3" required></textarea>
    </div>

    <!-- Image Upload -->
    <div class="form-group">
      <label for="image">Upload Image:</label>
      <input type="file" id="image" name="image" class="form-control" accept="image/*" required>
    </div>

    <!-- Buttons -->
    <div class="button-group">
      <button type="button" class="save-btn" id="save-btn" onclick="saveForm()">Save</button>
      <button type="button" class="edit-btn" id="edit-btn" onclick="toggleEditMode()" disabled>Edit</button>
    </div>
    
  </form>
</div>

<script>
  // Disable form fields for "view mode"
  function disableFormFields() {
    document.querySelectorAll('#food-form input, #food-form select, #food-form textarea').forEach(field => {
      field.disabled = true;
    });
  }

  // Enable form fields for "edit mode"
  function enableFormFields() {
    document.querySelectorAll('#food-form input, #food-form select, #food-form textarea').forEach(field => {
      field.disabled = false;
    });
  }

  // Save function
  function saveForm() {
    alert('Food item saved!');
    disableFormFields();
    document.getElementById('edit-btn').disabled = false;
    document.getElementById('save-btn').disabled = true;
  }

  // Toggle Edit Mode
  function toggleEditMode() {
    enableFormFields();
    document.getElementById('edit-btn').disabled = true;
    document.getElementById('save-btn').disabled = false;
  }

  // Reset form function
  function resetForm() {
    document.getElementById('food-form').reset();
    enableFormFields();
    document.getElementById('edit-btn').disabled = true;
    document.getElementById('save-btn').disabled = false;
  }

  // Initially disable fields to simulate "view mode"
  disableFormFields();
</script>
<!-- Display Food Items -->
<div class="card mt-4">
    <div class="card-header">
        <h3>Food Items</h3>
    </div>
    <div class="card-body">
        <?php if (count($foodItems) > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Food Name</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Image</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($foodItems as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['f_id']) ?></td>
                            <td><?= htmlspecialchars($item['food_name']) ?></td>
                            <td><?= htmlspecialchars($item['price']) ?></td>
                            <td><?= htmlspecialchars($item['category']) ?></td>
                            <td><?= htmlspecialchars($item['description']) ?></td>
                            <td><img src="<?= htmlspecialchars($item['image']) ?>" alt="Image" style="width: 100px; height: 100px;"></td>
                        </tr>
                        <?php
$servername = "localhost"; // or the IP of your database server
$username = "root"; // database username
$password = ""; // database password (empty for XAMPP by default)
$dbname = "your_database_name"; // name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($condition) {
  echo "Something";

}
?>

    </div>
</div>

</body>
</html>
