<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="astyle.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Admin Dashboard</h2>
                <input type="text" placeholder="Search" class="search-bar">
            </div>
            <ul class="sidebar-menu">
                <li><a href="#">Dashboard</a></li>
                <li><a href="#">My Project</a></li>
                <li><a href="#">Data</a></li>
                <li><a href="#">Statistics</a></li>
                <li><a href="#">Team</a></li>
                <li><a href="#">Saved</a></li>
                <li><a href="#">Draft</a></li>
                <li><a href="#">Trash</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="content">
            <section class="content-header">
                <h1>Admin Dashboard</h1>
            </section>
            <section class="management-buttons">
                <button class="manage-btn">Manage Restaurant</button>
                <button class="manage-btn">Food Menu</button>
                <button class="manage-btn">Manage Payment</button>
            </section>
            <section class="images">
                <img src="phone-food.jpg" alt="Food Image">
            </section>
        </main>
    </div>

    <script src="script.js"></script>
</body>
</html>