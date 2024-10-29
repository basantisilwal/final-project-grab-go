<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add New Food</title>
<style>
    body {
        font-family: Arial, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        background-color: #f9f5e7;
    }

    .container {
        width: 300px;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .container h2 {
        margin-bottom: 20px;
    }

    .input-group {
        margin-bottom: 15px;
        text-align: left;
    }

    .input-group label {
        display: block;
        margin-bottom: 5px;
        font-size: 14px;
    }

    .input-group input {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .photo-preview {
        width: 100%;
        height: 100px;
        background-color: #e0e0e0;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #666;
        margin-bottom: 15px;
        border-radius: 4px;
        font-size: 14px;
    }

    .button-group {
        display: flex;
        justify-content: space-between;
    }

    .button-group button {
        width: 80px;
        padding: 10px;
        background-color: #4ca3dd;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .button-group button:hover {
        background-color: #3682b8;
    }
</style>
</head>
<body>

<div class="container">
    <h2>Add New Food</h2>

    <div class="input-group">
        <label for="foodName">Name</label>
        <input type="text" id="foodName" placeholder="Enter food name">
    </div>

    <div class="input-group">
        <label for="foodType">Food Type</label>
        <input type="text" id="foodType" placeholder="Enter food type">
    </div>

    <div class="input-group">
        <label for="foodPrice">Price</label>
        <input type="number" id="foodPrice" placeholder="Enter price">
    </div>

    <div class="input-group">
        <label for="foodPhoto">Add Photo</label>
        <input type="file" id="foodPhoto" accept="image/*" onchange="previewPhoto(event)">
    </div>

    <div class="photo-preview" id="photoPreview">
        <p>Photo Preview</p>
    </div>

    <div class="button-group">
        <button onclick="goBack()">Back</button>
        <button onclick="addFood()">Add</button>
        <button onclick="deleteFood()">Delete</button>
    </div>
</div>

<script>
    function previewPhoto(event) {
        const photoPreview = document.getElementById('photoPreview');
        const file = event.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                photoPreview.style.backgroundImage = `url(${e.target.result})`;
                photoPreview.style.backgroundSize = 'cover';
                photoPreview.textContent = '';
            }
            reader.readAsDataURL(file);
        } else {
            photoPreview.style.backgroundImage = '';
            photoPreview.textContent = 'Photo Preview';
        }
    }

    function goBack() {
        alert('Back button clicked!');
    }

    function addFood() {
        const foodName = document.getElementById('foodName').value;
        const foodType = document.getElementById('foodType').value;
        const foodPrice = document.getElementById('foodPrice').value;
        
        if(foodName && foodType && foodPrice) {
            alert(`Food added:\nName: ${foodName}\nType: ${foodType}\nPrice: $${foodPrice}`);
        } else {
            alert('Please fill all fields!');
        }
    }

    function deleteFood() {
        document.getElementById('foodName').value = '';
        document.getElementById('foodType').value = '';
        document.getElementById('foodPrice').value = '';
        document.getElementById('foodPhoto').value = '';
        const photoPreview = document.getElementById('photoPreview');
        photoPreview.style.backgroundImage = '';
        photoPreview.textContent = 'Photo Preview';
        alert('Food deleted!');
    }
</script>

</body>
</html>