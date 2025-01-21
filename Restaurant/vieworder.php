<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        .main-layout {
            display: flex;
            height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #000;
            color: #fff;
            display: flex;
            flex-direction: column;
            padding: 20px 15px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
        }

        .sidebar a {
            color: #ff6700;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 10px;
            display: block;
        }

        .sidebar a:hover {
            background-color: #ff6700;
            color: #fff;
        }

        .content {
            margin-left: 270px;
            padding: 20px;
            width: 100%;
        }

        .table-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="main-layout">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h2>Restaurant Dashboard</h2>
            <a href="das.php">Dashboard</a>
            <a href="addfood.php">Add Food</a>
            <a href="viewfood.php">View Food</a>
            <a href="vieworder.php">View Order</a>
            <a href="managepayment.php">View Payment</a>
            <a href="account.php">Account</a>
            <a href="updateprofile.php">Profile</a>
            <a href="#">Logout</a>
        </aside>

        <!-- Content -->
        <div class="content">
            <h1>View Orders</h1>
            <div class="table-container">
            <?php include('../conn/conn.php'); 

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Query to fetch orders
                $sql = "SELECT id, name, phone, food_description, quantity, order_type, address, preferred_time, payment_method, created_at 
                        FROM tbl_order";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo '<table class="table table-striped">';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th>ID</th>';
                    echo '<th>Name</th>';
                    echo '<th>Phone</th>';
                    echo '<th>Food Description</th>';
                    echo '<th>Quantity</th>';
                    echo '<th>Order Type</th>';
                    echo '<th>Address</th>';
                    echo '<th>Preferred Time</th>';
                    echo '<th>Payment Method</th>';
                    echo '<th>Order Date</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row["id"] . '</td>';
                        echo '<td>' . $row["name"] . '</td>';
                        echo '<td>' . $row["phone"] . '</td>';
                        echo '<td>' . $row["food_description"] . '</td>';
                        echo '<td>' . $row["quantity"] . '</td>';
                        echo '<td>' . $row["order_type"] . '</td>';
                        echo '<td>' . $row["address"] . '</td>';
                        echo '<td>' . $row["preferred_time"] . '</td>';
                        echo '<td>' . $row["payment_method"] . '</td>';
                        echo '<td>' . $row["created_at"] . '</td>';
                        echo '</tr>';
                    }
                    echo '</tbody>';
                    echo '</table>';
                } else {
                    echo "<p>No orders found.</p>";
                }

                // Close connection
                $conn->close();
                ?>
            </div>
        </div>
    </div>
</body>
</html>
