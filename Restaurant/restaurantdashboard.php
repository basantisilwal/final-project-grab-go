<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blue Sky Summer Dashboard</title>
    <link rel="stylesheet" href="rstyle.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo">
                <img src="icecream-logo.png" alt="Blue Sky Summer Logo">
                <h2>Blue Sky <br> Summer</h2>
            </div>
            <div class="profile">
                <img src="profile.jpg" alt="Profile Picture" class="profile-pic">
                <h3>Selena Ansari</h3>
            </div>
            <nav class="menu">
                <a href="#">Dashboard</a>
                <a href="#">Add Products</a>
                <a href="#">View Products</a>
                <a href="#">Accounts</a>
                <a href="#">Logout</a>
            </nav>
            <div class="social-links">
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-linkedin"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-pinterest"></i></a>
            </div>
        </aside>

        <!-- Dashboard -->
        <main class="dashboard">
            <h1>Dashboard</h1>
            <div class="welcome">
                <h2>Welcome, Selena Ansari!</h2>
                <button onclick="updateProfile()">Update Profile</button>
            </div>
            <div class="stats">
                <div class="stat-card">
                    <p>Unread Messages</p>
                    <h3>1</h3>
                    <button onclick="seeMessages()">See Messages</button>
                </div>
                <div class="stat-card">
                    <p>Products Added</p>
                    <h3>8</h3>
                </div>
                <div class="stat-card">
                    <p>Total Active Products</p>
                    <h3>8</h3>
                </div>
            </div>
        </main>
    </div>
    <script src="script.js"></script>
</body>
</html>