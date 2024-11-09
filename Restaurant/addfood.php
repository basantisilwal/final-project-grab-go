<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add/Edit Food Panel</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      background-color: #f5f5f5;
    }
    .add-food-panel {
      background-color: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      max-width: 400px;
      width: 100%;
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
    .button-group .cancel-btn {
      background-color: #dc3545;
      color: white;
    }
  </style>
</head>
<body>

<div class="add-food-panel">
  <h2>Add/Edit Food Item</h2>
  <form id="food-form">
    <!-- Food Name -->
    <div class="form-group">
      <label for="food-name">Food Name:</label>
      <input type="text" id="food-name" name="food-name" placeholder="Enter food name" required>
    </div>
    
    <!-- Price -->
    <div class="form-group">
      <label for="price">Price:</label>
      <input type="number" id="price" name="price" placeholder="Enter price" required>
    </div>

    <!-- Category -->
    <div class="form-group">
      <label for="category">Category:</label>
      <select id="category" name="category" required>
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
      <textarea id="description" name="description" rows="3" placeholder="Enter food description" required></textarea>
    </div>

    <!-- Image Upload -->
    <div class="form-group">
      <label for="image">Upload Image:</label>
      <input type="file" id="image" name="image" accept="image/*" required>
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

</body>
</html>
