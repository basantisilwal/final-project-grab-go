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
  <div class="container">
    <h1>Add Food Item</h1>
    
    <?php
    include ('../conn/conn.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $foodName = $_POST['foodName'];
        $category = $_POST['category'];
        $description = $_POST['description'];

        // Handle file upload
        $imageURL = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imageTmpPath = $_FILES['image']['tmp_name'];
            $imageName = basename($_FILES['image']['name']);
            $uploadDir = "uploads/";
            $uploadFilePath = $uploadDir . $imageName;

            // Create uploads directory if it doesn't exist
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            if (move_uploaded_file($imageTmpPath, $uploadFilePath)) {
                $imageURL = $uploadFilePath;
            } else {
                echo "<p style='color: red;'>Error uploading file.</p>";
            }
        }

        $price = 0; // Placeholder for price functionality

        // Insert data into the database
        $sql = "INSERT INTO tbl_addfood (food_name, description, price, category, image) 
        VALUES (:food_name, :description, :price, :category, :image)";

try {
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':food_name', $foodName);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':category', $category);
    $stmt->bindParam(':image', $imageURL);

    if ($stmt->execute()) {
        echo "<p style='color: green;'></p>";
    } else {
        echo "<p style='color: red;'>Error adding food item.</p>";
    }
} catch (PDOException $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
}

    // Close the connection
    $conn = null;
    ?>

    <form id="addFoodForm" action="" method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="foodName">Food Name</label>
        <input type="text" id="foodName" name="foodName" placeholder="Enter food name" required>
      </div>
      <div class="form-group">
        <label for="category">Category</label>
        <select id="category" name="category" required>
          <option value="" disabled selected>Select category</option>
          <option value="appetizer">Appetizer</option>
          <option value="main-course">Main Course</option>
          <option value="dessert">Dessert</option>
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
  </script>
</body>
</html>
