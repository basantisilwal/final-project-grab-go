<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Product Modal</title>
  <link rel="stylesheet" href="addstyles.css">
</head>
<body>
  <div class="sidebar">
    <!-- Sidebar content -->
    <ul class="menu">
      <li><a href="#" id="addProductBtn">Add Products</a></li>
      <!-- Other menu items -->
    </ul>
  </div>

  <!-- Add Product Modal -->
  <div id="addProductModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h2>Add Product</h2>
      <form id="addProductForm">
        <label for="productName">Product Name:</label>
        <input type="text" id="productName" name="productName" required>
        
        <label for="productPrice">Price:</label>
        <input type="number" id="productPrice" name="productPrice" required>
        
        <label for="productDescription">Description:</label>
        <textarea id="productDescription" name="productDescription" rows="4" required></textarea>
        
        <button type="submit">Add Product</button>
      </form>
    </div>
  </div>

  <script src="script.js"></script>
</body>
</html>

