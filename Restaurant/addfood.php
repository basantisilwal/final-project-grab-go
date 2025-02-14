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
    padding: 20px 15px;
    position: fixed;
    top: 0;
    left: 0;
    box-shadow: 4px 0 10px rgba(0, 0, 0, 0.2); /* Soft shadow for depth */
}

.sidebar h2 {
    font-size: 1.5rem;
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
            max-width: 600px; /* Limit the width of the content */
            margin: auto; /* Center the content */
            padding: 15px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow-y: auto; /* Scroll if content overflows */
        }

        h1 {
            text-align: center;
            color: #333;
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
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 0.9rem;
        }

        textarea {
            resize: none;
        }

        .form-group #imagePreview {
            margin-top: 10px;
            max-height: 100px;
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

        <!-- Content -->
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
                <a href="#" id="addCategoryLink">+ Add New Category</a>
                </div>
                <div class="form-group" id="newCategoryGroup" style="display: none;">
                    <label for="newCategory">New Category Name</label>
                    <input type="text" id="newCategory" placeholder="Enter new category name">
                    <button type="button" id="saveCategoryButton">Save Category</button>
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
