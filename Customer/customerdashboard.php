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
<header>
        <div class="logo">GRAB&GO</div>
        <div class="location">Damauli, Tanahun</div>
        <div class="search">
            <input type="text" placeholder="Search for restaurant, cuisine or dish" id="searchBar">
        </div>
    </header>

    <section class="inspiration">
        <h2>Inspiration for Your First Order</h2>
        <div class="categories">
            <div class="category"data-toggle="modal" data-target="#exampleModal">
                <img src="../images/pizza.jpg" alt="pizza" class="circle-img">
                <p>Pizza</p>
                
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
            </div>
            <div class="category">
            <img src="../images/burger.webp" alt="burger" class="circle-img">
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
            <div class="restaurant">
                <img src="../images/buff momo image.jpg" alt="Mayur Cafe" class="circle-img">
                <div class="restaurant-info">
                    <h3>Mayur Cafe</h3>
                    <p>Kalikamarga Vays-2</p>
                    <p class="rating">Rating: 5.3</p>
                    <p class="price">RS 120</p>
                </div>
            </div>
            <div class="restaurant">
                <img src="../images/chicken fry momo.jpg" alt="Diamond Restro" class="circle-img">
                <div class="restaurant-info">
                    <h3>Diamond Restro</h3>
                    <p>Safasadak Vays-2</p>
                    <p class="rating">Rating: 4.2</p>
                    <p class="price">RS 520</p>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 Grab & Go</p>
    </footer>

    <script src="script.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>