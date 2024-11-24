<?php
include('../conn/conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['foodName'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $description = $_POST['description'];

    $imageName = $_FILES['image']['name'];
    $imageTmpName = $_FILES['image']['tmp_name'];
    $imagePath = "../uploads/" . $imageName;

    if (move_uploaded_file($imageTmpName, $imagePath)) {
        $stmt = $conn->prepare("INSERT INTO tbl_food (name, price, description, category, image) VALUES (:name, :price, :description, :category, :image)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':image', $imageName);

        if ($stmt->execute()) {
            echo "Food item added successfully!";
        } else {
            echo "Failed to add food item.";
        }
    } else {
        echo "Failed to upload image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Food Item</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f9f9f9;
      color: #333;
    }

    /* Sidebar Styles */
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

    /* Main Content */
    .main-content {
      flex-grow: 1;
      padding: 20px;
      background-color: #f8f8f8;
    }

    .container {
      max-width: 500px;
      margin: 50px auto;
      padding: 20px;
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    h1 {
      text-align: center;
      color: #333;
    }
    form {
      display: flex;
      flex-direction: column;
    }
    .form-group {
      margin-bottom: 15px;
    }
    .form-group label {
      font-weight: bold;
      margin-bottom: 5px;
      display: block;
    }
    .form-group input, .form-group select, .form-group textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    textarea {
      resize: none;
    }
    .form-group #imagePreview {
      margin-top: 10px;
      max-height: 150px;
      border: 1px dashed #ccc;
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
      background: #28a745;
      color: #fff;
      padding: 10px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
      transition: background 0.3s;
    }
    button:hover {
      background: #218838;
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <aside class="sidebar">
    <h2>Restaurant Dashboard</h2>
    <a href="das.php">Dashboard</a>
    <a href="myproject.php">My Project</a>
    <a href="addfood.php">Add Food</a>
    <a href="viewfood.php">View food</a>
    <a href="managepayment.php">View payment</a>
    <a href="account.php">Account</a>
    <a href="updateprofile.php">Profile</a>
    <a href="#">Logout</a>
    </aside>

  <div class="container">
    <h1>Add Food Item</h1>
    <form id="addFoodForm">
      <div class="form-group">
        <label for="foodName">Food Name</label>
        <input type="text" id="foodName" name="foodName" placeholder="Enter food name" required>
      </div>
      <div class="form-group">
        <label for="price">Price</label>
        <input type="number" id="price" name="price" placeholder="Enter price" required>
      </div>
      <div class="form-group">
        <label for="category">Category</label>
        <select id="category" name="category" required>
          <option value="">Select category</option>
          <option value="appetizer">Dinner</option>
          <option value="main-course">Breakfast</option>
          <option value="dessert">Dessert</option>
          <option value="beverage">lunch</option>
        </select>
      </div>
      <div class="form-group">
        <label for="description">Description</label>
        <textarea id="description" name="description" rows="3" placeholder="Enter description" required></textarea>
      </div>
      <div class="form-group">
        <label for="image">Upload Image</label>
        <input type="file" id="image" name="image" accept="image/*" required>
        <div id="imagePreview"></div>
      </div>
      <button type="submit">Add Food</button>
    </form>
  </div>
  <script>
    const imageInput = document.getElementById("image");
    const imagePreview = document.getElementById("imagePreview");
    const addFoodForm = document.getElementById("addFoodForm");

    imageInput.addEventListener("change", function () {
      const file = this.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
          imagePreview.innerHTML = <img src="${e.target.result}" alt="Food Image">;
        };
        reader.readAsDataURL(file);
      } else {
        imagePreview.innerHTML = "";
      }
    });

    addFoodForm.addEventListener("submit", function (e) {
      e.preventDefault();
      alert("Food item added successfully!");
      addFoodForm.reset();
      imagePreview.innerHTML = "";
    });
  </script>
</body>
</html>