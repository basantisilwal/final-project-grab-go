<?php include('../conn/conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $foodName = $_POST['foodName'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Handle image upload
    $targetDir = "uploads/"; // Directory to store uploaded images
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true); // Create the directory if it doesn't exist
    }
    $imageName = basename($_FILES["image"]["name"]);
    $targetFilePath = $targetDir . $imageName;
    $imageType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    // Allowed file types
    $allowedTypes = array("jpg", "jpeg", "png", "gif");

    if (in_array($imageType, $allowedTypes)) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
            // Prepare SQL statement to insert into the database
            $sql = "INSERT INTO tbl_addfood (food_name, category, description, price, image) 
                    VALUES (:foodName, :category, :description, :price, :imageName)";
            $stmt = $conn->prepare($sql);
            
            // Bind parameters
            $stmt->bindParam(':foodName', $foodName);
            $stmt->bindParam(':category', $category);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':imageName', $imageName);

            // Execute the statement
            if ($stmt->execute()) {
                echo "<script>alert('Food item added successfully!');</script>";
            } else {
                echo "<script>alert('Error: Could not add the food item.');</script>";
            }
        } else {
            echo "<script>alert('Error uploading the image.');</script>";
        }
    } else {
        echo "<script>alert('Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.');</script>";
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
    header {
            background-color: #555;
            color: white;
            text-align: center;
            padding: 20px;
        }

        /* Main Layout: Sidebar and Content */
        .main-layout {
            display: flex;
            height: 100vh; /* Full viewport height */
        }

        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background-color: #000; /* Black background */
            color: #fff;
            height: 100%;
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
        .container {
          max-width: 1100px;
    position: relative;
    top: -10px; /* Move the form upward by 20px */
    padding: 70px;
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
    .add-category-link {
      margin-top: 10px;
      color: #007bff;
      cursor: pointer;
      font-size: 14px;
      text-align: right;
    }
    .add-category-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
<div class="main-layout">
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
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="foodName">Food Name</label>
                <input type="text" id="foodName" name="foodName" placeholder="Enter food name" required>
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <select id="category" name="category" required>
                    <option value="" disabled selected>Select category</option>
                    <option value="starter">Starter</option>
                    <option value="main-course">Main Course</option>
                    <option value="dessert">Dessert</option>
                    <option value="beverage">Beverage</option>
                </select>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" step="0.01" id="price" name="price" placeholder="Enter price" required>
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
    const addCategoryLink = document.getElementById("addCategoryLink");
    const newCategoryGroup = document.getElementById("newCategoryGroup");
    const saveCategoryButton = document.getElementById("saveCategoryButton");
    const categorySelect = document.getElementById("category");
    const newCategoryInput = document.getElementById("newCategory");

    // Show the "Add New Category" input
    addCategoryLink.addEventListener("click", function () {
      newCategoryGroup.style.display = "block";
    });

    // Save the new category
    saveCategoryButton.addEventListener("click", function () {
      const newCategory = newCategoryInput.value.trim();
      if (newCategory) {
        const option = document.createElement("option");
        option.value = newCategory.toLowerCase().replace(/\s+/g, "-");
        option.textContent = newCategory;
        categorySelect.appendChild(option);
        categorySelect.value = option.value; // Automatically select the new category
        newCategoryGroup.style.display = "none";
        newCategoryInput.value = "";
        alert("New category added!");
      } else {
        alert("Please enter a valid category name.");
      }
    });

    // Preview uploaded image
    imageInput.addEventListener("change", function () {
      const file = this.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
          imagePreview.innerHTML = `<img src="${e.target.result}" alt="Food Image">`;
        };
        reader.readAsDataURL(file);
      } else {
        imagePreview.innerHTML = "";
      }
    });

    // Form submission (placeholder functionality)
    document.getElementById("addFoodForm").addEventListener("submit", function (e) {
      e.preventDefault();
      alert("Food item added successfully!");
      this.reset();
      imagePreview.innerHTML = "";
    });
  </script>
</body>
</html>
