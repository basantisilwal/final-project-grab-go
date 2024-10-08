<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Search</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="logo">
            <span class="menu-icon">&#9776;</span>
            <span class="brand">yummy.</span>
        </div>
        <nav>
            <ul>
                <li><a href="#">Find Food</a></li>
                <li><a href="#">Categories</a></li>
                <li><a href="#">Restaurant</a></li>
                <li><a href="#">About Us</a></li>
            </ul>
        </nav>
        <div class="contact">
            <a href="tel:98765434210">98765434210</a>
        </div>
    </header>

    <section class="hero">
        <h1>Discover Restaurants that deliver near you</h1>
        <div class="search-bar">
            <input type="text" placeholder="Enter delivery address">
            <button>Ok</button>
        </div>
    </section>

    <section class="categories">
        <div class="category">
            <img src="food.jpg" alt="Food">
            <a href="#">Food</a>
        </div>
        <div class="category">
            <img src="pizza.jpg" alt="Pizza">
            <a href="#">Pizza</a>
        </div>
        <div class="category">
            <img src="healthy.jpg" alt="Healthy">
            <a href="#">Healthy</a>
        </div>
    </section>

    <section class="images">
        <img src="burger.jpg" alt="Burger">
        <img src="pasta.jpg" alt="Pasta">
        <img src="tacos.jpg" alt="Tacos">
    </section>

    <footer>
        <div class="account">
            <a href="#">Account</a>
            <a href="#" class="confirm-order">Confirm Order</a>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>