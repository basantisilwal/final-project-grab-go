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
        .main-layout {
            display: flex;
            height: 100vh;
        }
        .sidebar {
            width: 250px;
            background-color: #000;
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
            color: #ff6700;
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
            padding: 70px;
            margin: auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
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
            max-width: 100%;
        }
        button {
            background: #28a745;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background: #218838;
        }
        .add-category-link {
            margin-top: 10px;
            color: #007bff;
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
        <aside class="sidebar">
            <h2>Restaurant Dashboard</h2>
            <a href="das.php">Dashboard</a>
            <a href="myproject.php">My Project</a>
            <a href="addfood.php">Add Food</a>
            <a href="viewfood.php">View Food</a>
            <a href="managepayment.php">View Payment</a>
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
                    <select id="category" name="category">
                        <option value="" disabled selected>Select category</option>
                        <?php
                        // Populate categories from the database
                        $categoryQuery = "SELECT DISTINCT category FROM tbl_addfood";
                        $categoryStmt = $conn->prepare($categoryQuery);
                        $categoryStmt->execute();
                        while ($categoryRow = $categoryStmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . htmlspecialchars($categoryRow['category']) . "'>" . htmlspecialchars($categoryRow['category']) . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <a class="add-category-link" id="addCategoryLink">Add New Category</a>
                    <div id="newCategoryGroup" style="display:none;">
                        <input type="text" id="newCategory" name="newCategory" placeholder="Enter new category name">
                    </div>
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
                    <div id="imagePreview">No image selected</div>
                </div>
                <button type="submit">Add Food</button>
            </form>
        </div>
    </div>

    <script>
        const imageInput = document.getElementById("image");
        const imagePreview = document.getElementById("imagePreview");
        const addCategoryLink = document.getElementById("addCategoryLink");
        const newCategoryGroup = document.getElementById("newCategoryGroup");

        addCategoryLink.addEventListener("click", function () {
            newCategoryGroup.style.display = "block";
        });

        imageInput.addEventListener("change", function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    imagePreview.innerHTML = `<img src="${e.target.result}" alt="Image Preview">`;
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.textContent = "No image selected";
            }
        });
    </script>
</body>
</html>
