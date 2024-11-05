<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add New Food</title>
</head>
<body>
<div class="main-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Admin Dashboard</h2>
            </div>
            <ul class="sidebar-menu">
            <li><a href="pandingfoodorder.php">Panding</a></li>
                <li><a href="managefoodmenu.php">Menu</a></li>
                <li><a href="restaurantdashboard.php">Viewr</a></li>
                <li><a href="setting.php">Setting</a></li>
            </ul>
        </aside>
        
        <div class="main-content">
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