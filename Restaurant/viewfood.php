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
        
        /* Base styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex; /* Enables side-by-side layout */
            height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background-color: #000; /* Black background */
            color: #fff;
            height: 100vh;
            display: flex;
            flex-direction: column;
            padding: 20px 15px;
            box-sizing: border-box;
            position: fixed; /* Keeps it fixed on the left side */
            top: 0;
            left: 0;
        }

        .sidebar h2 {
            font-size: 1.2rem;
            margin-bottom: 20px;
        }

        .sidebar a {
            color: #ff6700; /* Orange text */
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 10px;
            display: block;
            transition: background 0.3s;
        }

        .sidebar a:hover {
            background-color: #ff6700;
            color: #fff;
        }

        /* Main Content Styles */
        .main-content {
            margin-left: 250px; /* Push content to the right by the sidebar's width */
            flex-grow: 1; /* Allows the content to fill the remaining space */
            padding: 20px;
            overflow-y: auto; /* Scrollable content */
            background-color: #f8f9fa; /* Light background for better contrast */
        }

        .main-content h1 {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        table th {
            background-color: #007bff;
            color: #fff;
        }

        table img {
            max-width: 100px;
            max-height: 80px;
            object-fit: cover;
        }

        .action-buttons a {
            margin: 0 5px;
            text-decoration: none;
        }

        .btn-edit {
            color: #fff;
            background-color: #28a745;
            padding: 5px 10px;
            border-radius: 5px;
            display: inline-block;
        }

        .btn-delete {
            color: #fff;
            background-color: #dc3545;
            padding: 5px 10px;
            border-radius: 5px;
            display: inline-block;
        }

        .btn-update {
            color: #fff;
            background-color: #007bff;
            padding: 5px 10px;
            border-radius: 5px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <h2>Restaurant Dashboard</h2>
        <a href="das.php">Dashboard</a>
        <a href="myproject.php">My Project</a>
        <a href="addfood.php">Add Food</a>
        <a href="viewfood.php">View Food</a>
        <a href="managepayment.php">View Payment</a>
        <a href="account.php">Account</a>
        <a href="updateprofile.php">Profile</a>
        <a href="#">Logout</a>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <h1>Food Items</h1>
        <?php
        // Include database connection file
        include('../conn/conn.php'); // Adjust the path based on your directory structure

        try {
            // Fetch all records from the database
            $sql = "SELECT `f_id`, `food_name`, `description`, `price`, `category`, `image` FROM `tbl_addfood`";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            // Start the HTML table
            echo "<table border='1' cellspacing='0' cellpadding='10' style='width:100%; border-collapse:collapse; text-align:center;'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Food Name</th>";
            echo "<th>Description</th>";
            echo "<th>Price</th>";
            echo "<th>Category</th>";
            echo "<th>Image</th>";
            echo "<th>Actions</th>"; // Add Actions column
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            // Loop through each row and display it in the table
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['f_id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['food_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                echo "<td>" . htmlspecialchars($row['price']) . "</td>";
                echo "<td>" . htmlspecialchars($row['category']) . "</td>";
                echo "<td><img src='" . htmlspecialchars($row['image']) . "' alt='" . htmlspecialchars($row['food_name']) . "' style='width:100px; height:80px; object-fit:cover;'></td>";
                echo "<td class='action-buttons'>";
                echo "<a href='edit_food.php?id=" . $row['f_id'] . "' class='btn-edit'>Edit</a>";
                echo "<a href='delete_food.php?id=" . $row['f_id'] . "' class='btn-delete'>Delete</a>";
                echo "<a href='update_food.php?id=" . $row['f_id'] . "' class='btn-update'>Update</a>";
                echo "</td>";
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        $conn = null; // Close the database connection
        ?>
    </div>
</body>
</html>
