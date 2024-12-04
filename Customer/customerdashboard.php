<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grab & Go</title>
    <link rel="stylesheet" href="cstyle.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<?php
include('../conn/conn.php'); // Database connection
?>
<header>
    <div class="logo">GRAB & GO</div>
    <div class="location">Damauli, Tanahun</div>
    <div class="search">
        <form method="GET" action="search.php">
            <input type="text" name="search" placeholder="Search for restaurant, cuisine or dish" id="searchBar">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>
</header>

<section class="inspiration">
    <h2>Inspiration for Your First Order</h2>
    <div class="categories">
        <!-- Static Categories -->
        <div class="category">
            <img src="../images/pizza.jpg" alt="Pizza" class="circle-img">
            <p>Pizza</p>
        </div>
        <div class="category">
            <img src="../images/burger.webp" alt="Burger" class="circle-img">
            <p>Burger</p>
        </div>
        <div class="category">
            <img src="../images/hole chicken.jpg" alt="Chicken" class="circle-img">
            <p>Chicken</p>
        </div>
        <div class="category">
            <img src="../images/image.png" alt="Mutton" class="circle-img">
            <p>Mutton</p>
        </div>
    </div>
</section>

<section class="restaurants">
    <h2>Order Food Online Near You</h2>
    <div class="restaurant-list">
        <?php
        // Query to fetch food items from the database
        $query = "SELECT * FROM tbl_addfood ORDER BY f_id DESC";
        $stmt = $conn->prepare($query);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <div class="restaurant" data-toggle="modal" data-target="#foodModal" 
                     data-name="<?php echo htmlspecialchars($row['food_name']); ?>" 
                     data-category="<?php echo htmlspecialchars($row['category']); ?>" 
                     data-description="<?php echo htmlspecialchars($row['description']); ?>" 
                     data-price="RS <?php echo htmlspecialchars($row['price']); ?>" 
                     data-image="uploads/<?php echo htmlspecialchars($row['image']); ?>">
                    <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['food_name']); ?>" class="circle-img">
                    <div class="restaurant-info">
                        <h3><?php echo htmlspecialchars($row['food_name']); ?></h3>
                        <p>Category: <?php echo htmlspecialchars($row['category']); ?></p>
                        <p class="description"><?php echo htmlspecialchars($row['description']); ?></p>
                        <p class="price">Price: RS <?php echo htmlspecialchars($row['price']); ?></p>
                    </div>
                </div>
                <?php
            }
        } else {
            echo '<p>No food items available at the moment. Please check back later!</p>';
        }
        ?>
    </div>
</section>

<!-- Modal for Food Details -->
<div class="modal fade" id="foodModal" tabindex="-1" role="dialog" aria-labelledby="foodModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="foodModalLabel">Food Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img id="modalFoodImage" src="" alt="Food Image" class="img-fluid mb-3">
                <p><strong>Name:</strong> <span id="modalFoodName"></span></p>
                <p><strong>Category:</strong> <span id="modalFoodCategory"></span></p>
                <p><strong>Description:</strong> <span id="modalFoodDescription"></span></p>
                <p><strong>Price:</strong> <span id="modalFoodPrice"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<footer>
    <p>&copy; 2024 Grab & Go</p>
</footer>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script>
    // Script to handle modal population
    document.addEventListener("DOMContentLoaded", () => {
        const modal = document.getElementById('foodModal');
        const modalFoodName = document.getElementById('modalFoodName');
        const modalFoodCategory = document.getElementById('modalFoodCategory');
        const modalFoodDescription = document.getElementById('modalFoodDescription');
        const modalFoodPrice = document.getElementById('modalFoodPrice');
        const modalFoodImage = document.getElementById('modalFoodImage');

        $('#foodModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget);
            modalFoodName.textContent = button.data('name');
            modalFoodCategory.textContent = button.data('category');
            modalFoodDescription.textContent = button.data('description');
            modalFoodPrice.textContent = button.data('price');
            modalFoodImage.src = button.data('image');
        });
    });
</script>
</body>
</html>
