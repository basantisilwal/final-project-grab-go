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
        .main-content {
            padding: 15px;
        }

.gallery {
    display: flex;
    gap: 20px;
    margin: 20px;
}

.card {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    overflow: hidden;
    width: 200px;
    text-align: center;
}

.product-image {
    width: 100%;
    height: auto;
    border-bottom: 1px solid #ddd;
}

h3 {
    margin: 15px 0;
    font-size: 1.1em;
    color: #333;
}

.buttons {
    display: flex;
    gap: 10px;
    padding: 10px;
    justify-content: center;
}

button {
    padding: 8px 16px;
    font-size: 0.9em;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    opacity: 0.8;
}

button:nth-child(1) {
    background-color: #ff6699;
    color: #fff;
}

button:nth-child(2) {
    background-color: #ff6699;
    color: #fff;
}

button:nth-child(3) {
    background-color; #ff6699;
    color: #fff;
}
</style>
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

    <div class="gallery">
        <!-- Card 1 -->
        <div class="card">
            <img src="../images/jhol momo.jpg" alt="Jhol-momo" class="product-image">
            <h3>Jhol MOMO</h3>
            <div class="buttons">
                <button onclick="editPost()">Edit</button>
                <button onclick="deletePost()">Delete</button>
                <button onclick="viewPost()">View Post</button>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="card">
            <img src="../images/fry fish.jpg" alt="Fry fish" class="product-image">
            <h3>Fry Fish</h3>
            <div class="buttons">
                <button onclick="editPost()">Edit</button>
                <button onclick="deletePost()">Delete</button>
                <button onclick="viewPost()">View Post</button>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="card">
            <img src="chicken chaumin.jpg" alt="chiken chaumin" class="product-image">
            <h3>$100/-</h3>
            <div class="buttons">
                <button onclick="editPost()">Edit</button>
                <button onclick="deletePost()">Delete</button>
                <button onclick="viewPost()">View Post</button>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
<style>
function editPost() {
    alert("Edit function triggered!");
}

function deletePost() {
    alert("Delete function triggered!");
}

function viewPost() {
    alert("View Post function triggered!");
}
</style>
</html>
