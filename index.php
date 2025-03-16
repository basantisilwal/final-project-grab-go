<?php
session_start();
include('./conn/conn.php'); // Include the database connection

// Fetch logo from the database
$stmt = $conn->prepare("SELECT logo_path FROM tbl_logo WHERE u_id = 1");
$stmt->execute();
$logo = $stmt->fetch(PDO::FETCH_ASSOC);
$logoPath = $logo['logo_path'] ?? '';

// Fallback to a default logo if none found
if (empty($logoPath)) {
    $logoPath = "\final-project-grab-go\uploads\logo\Unicafe.png"; // Adjust this path if needed
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>UNICAFE</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background: #f7f3f1;
            padding: 20px;
        }

        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .logo-title-container {
            display: flex;
            align-items: center;
        }

        .logo-container {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            border: 2px solid black;
        }

        .logo-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .title {
            font-size: 30px;
            font-weight: bold;
            color: red;
        }

        .nav-links {
            list-style: none;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .nav-links li a {
            text-decoration: none;
            color: black;
            font-weight: 500;
        }

        .hero-section {
            text-align: center;
            margin-top: 50px;
        }

        .hero-section h1 {
            margin-bottom: 20px;
            font-size: 32px;
        }

        .search-bar {
            display: inline-flex;
            border: 2px solid #ccc;
            border-radius: 25px;
            overflow: hidden;
        }

        .search-bar input {
            border: none;
            padding: 10px;
            width: 300px;
            outline: none;
        }

        .search-bar button {
            background: red;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }

        .categories {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 40px 0;
        }

        .category-card {
            width: 200px;
            text-align: center;
        }

        .category-card img {
            width: 100%;
            height: 140px;
            object-fit: cover;
            border-radius: 10px;
        }

        .category-card p {
            margin-top: 10px;
            font-weight: bold;
        }

        .circle-images {
            position: relative;
            height: 400px;
            margin: 20px 0;
        }

        .circle {
            position: absolute;
            border-radius: 50%;
            object-fit: cover;
        }

        .large {
            width: 250px;
            height: 250px;
            top: 30px;
            left: 50%;
            transform: translateX(-50%);
        }

        .small {
            width: 120px;
            height: 120px;
        }

        .medium {
            width: 200px;
            height: 200px;
        }

        .top-right {
            top: 0;
            right: 10%;
        }

        .bottom-left {
            bottom: 10%;
            left: 15%;
        }

        .bottom-right {
            bottom: 0;
            right: 20%;
        }

        #about, #menu, #reviews {
            padding: 80px 0;
        }

        #contact {
            background-color: #FFDD57;
            padding: 60px 0;
            color: black;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
    <div class="logo-title-container">
        <div class="logo-container">
            <img src="<?php echo htmlspecialchars($logoPath); ?>" alt="Logo">
        </div>
        <div class="title">UNICAFE.</div>
    </div>
    <ul class="nav-links">
        <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#about">About Us</a></li>
        <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
        <li class="nav-item"><a class="nav-link" href="register.php">Login</a></li>
    </ul>
</nav>

<!-- Hero Section -->
<header class="hero-section">
    <h1>yamm yamm food</h1>
    <div class="search-bar">
        <input type="text" placeholder="foody">
        <button>Ok</button>
    </div>
</header>

<!-- Categories Section -->
<section class="categories">
    <div class="category-card">
        <img src="/Grabandgo/final-project-grab-go/images/food.jpg" alt="Food">
        <p>Food</p>
    </div>
    <div class="category-card">
        <img src="/Grabandgo/final-project-grab-go/images/pizza.jpg" alt="Pizza">
        <p>Pizza</p>
    </div>
    <div class="category-card">
        <img src="/Grabandgo/final-project-grab-go/images/healthy.jpg" alt="Healthy">
        <p>Healthy</p>
    </div>
</section>

<!-- Circle Images Section -->
<section class="circle-images">
    <img src="/Grabandgo/final-project-grab-go/images/foods.jpg" class="circle large" alt="Food">
    <img src="/Grabandgo/final-project-grab-go/images/french.jpg" class="circle small top-right" alt="French">
    <img src="/Grabandgo/final-project-grab-go/images/pasta.jpg" class="circle small bottom-left" alt="Pasta">
    <img src="/Grabandgo/final-project-grab-go/images/burger.jpg" class="circle medium bottom-right" alt="Burger">
</section>

<!-- About Section -->
<section id="about">
    <div class="container text-center">
        <h2>About Us</h2>
        <p>UniCafe is your trusted partner for fast, reliable, and delicious food. Enjoy diverse cuisines!</p>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="text-center">
    <h2>Contact Us</h2>
    <p>+9779748213635, +9779816141807</p>
</section>

</body>
</html>
