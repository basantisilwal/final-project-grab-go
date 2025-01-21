<?php include('../conn/conn.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grab & Go</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #f7e4a3;
            padding: 10px 20px;
        }

        .logo {
            font-size: 1.5em;
            font-weight: bold;
            color: #ff5722;
        }

        .location {
            font-size: 1em;
            color: #333;
        }

        .search input {
            padding: 5px;
            font-size: 1em;
            width: 250px;
        }

        .search button {
            padding: 5px 10px;
            font-size: 1em;
        }

        section.restaurants {
            padding: 20px;
            text-align: center;
        }

        .restaurant-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .restaurant {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            margin: 10px;
            padding: 15px;
            width: 200px;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .restaurant:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .circle-img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            display: block;
            margin: 0 auto 10px;
        }

        .restaurant-info h3 {
            margin: 10px 0 5px;
            font-size: 1.2em;
        }

        .restaurant-info p {
            margin: 0;
            font-size: 0.9em;
            color: #555;
        }

        .restaurant-info .price {
            color: #ff5722;
            font-weight: bold;
        }

       

        footer {
            text-align: center;
            padding: 10px 0;
            background-color: #f7e4a3;
        }
    </style>
</head>
<body>
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
<?php
include('../conn/conn.php'); // Database connection
?>

<section class="restaurants">
    <h2>Order Food Online Near You</h2>
    <div class="restaurant-list">
        <?php
        include('../conn/conn.php');
        $query = "SELECT * FROM tbl_addfood ORDER BY f_id DESC";
        $stmt = $conn->prepare($query);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $imagePath = "uploads/" . htmlspecialchars($row['image']);
                if (!file_exists($imagePath) || empty($row['image'])) {
                    $imagePath = "https://via.placeholder.com/150";
                }
                ?>
                <div class="restaurant" data-toggle="modal" data-target="#foodModal" 
                     data-name="<?php echo htmlspecialchars($row['food_name']); ?>" 
                     data-category="<?php echo htmlspecialchars($row['category']); ?>" 
                     data-description="<?php echo htmlspecialchars($row['description']); ?>" 
                     data-price="RS <?php echo htmlspecialchars($row['price']); ?>" 
                     data-image="<?php echo $imagePath; ?>">
                    <img src="<?php echo $imagePath; ?>" alt="<?php echo htmlspecialchars($row['food_name']); ?>" class="circle-img">
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

<!-- Food Details Modal -->
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="openOrderForm">Order</button>
            </div>
        </div>
    </div>
</div>


<footer>
    <p>&copy; 2024 Grab & Go</p>
</footer>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const modal = document.getElementById('foodModal');
        $('#foodModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget);
            document.getElementById('modalFoodName').textContent = button.data('name');
            document.getElementById('modalFoodCategory').textContent = button.data('category');
            document.getElementById('modalFoodDescription').textContent = button.data('description');
            document.getElementById('modalFoodPrice').textContent = button.data('price');
            document.getElementById('modalFoodImage').src = button.data('image');
        });

        document.getElementById('orderType').addEventListener('change', function () {
            const addressGroup = document.getElementById('addressGroup');
            addressGroup.style.display = this.value === 'delivery' ? 'block' : 'none';
        });

        document.getElementById('orderForm').addEventListener('submit', function (e) {
            const name = document.getElementById('name').value.trim();
            const phone = document.getElementById('phone').value.trim();

            if (!name || !phone) {
                alert('Please fill in all required fields.');
                e.preventDefault();
            }
        });
        document.addEventListener("DOMContentLoaded", function () {
            const paymentMethod = document.getElementById("paymentMethod");
            const qrCodeContainer = document.getElementById("qrCodeContainer");

            paymentMethod.addEventListener("change", function () {
                if (paymentMethod.value === "online") {
                    qrCodeContainer.style.display = "block"; // Show QR Code
                } else {
                    qrCodeContainer.style.display = "none"; // Hide QR Code
                }
            });

        });
        const openOrderFormButton = document.getElementById('openOrderForm');

        // Add click event listener
        openOrderFormButton.addEventListener('click', () => {
            // Hide the current modal (#foodModal)
            $('#foodModal').modal('hide');

            // Wait for the current modal to close, then show the order modal (#orderModal)
            $('#foodModal').on('hidden.bs.modal', () => {
                $('#orderModal').modal('show');
            });
        });
    });
</script>
</body>
</html>
