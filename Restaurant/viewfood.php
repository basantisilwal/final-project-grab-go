<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* Base styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background-color: #000;
            color: #fff;
            height: 100vh;
            display: flex;
            flex-direction: column;
            padding: 20px 15px;
            position: fixed;
            top: 0;
            left: 0;
        }

        .sidebar h2 {
            font-size: 1.2rem;
            margin-bottom: 20px;
        }

        .sidebar a {
            color: #ff6700;
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
            margin-left: 250px;
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto;
            background-color: #f8f9fa;
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

        .action-buttons button {
            margin: 0 5px;
            padding: 5px 10px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            color: #fff;
        }

        .btn-edit {
            background-color: #28a745;
        }

        .btn-delete {
            background-color: #dc3545;
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
            echo "<table>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Food Name</th>";
            echo "<th>Description</th>";
            echo "<th>Price</th>";
            echo "<th>Category</th>";
            echo "<th>Image</th>";
            echo "<th>Actions</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            // Loop through each row and display it in the table
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Check if image column has a valid value
                $imagePath = !empty($row['image']) ? "uploads/" . htmlspecialchars($row['image']) : "default.png";

                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['f_id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['food_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                echo "<td>" . htmlspecialchars($row['price']) . "</td>";
                echo "<td>" . htmlspecialchars($row['category']) . "</td>";
                echo "<td><img src='$imagePath' alt='" . htmlspecialchars($row['food_name']) . "'></td>";
                echo "<td class='action-buttons'>";
                echo "<button onclick=\"updateFood(" . htmlspecialchars($row['f_id']) . ")\" class='btn-edit'>Edit</button>";
                echo "<button onclick=\"deleteFood(" . htmlspecialchars($row['f_id']) . ")\" class='btn-delete'>Delete</button>";
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

    <script>
        function updateFood(id) {
            // Navigate to the edit page with the ID
            window.location.href = `http://localhost/Grabandgo/final-project-grab-go/Restaurant/editfood.php?id=${id}`;
        }

        function deleteFood(id) {
            // Confirm before deleting
            if (confirm("Are you sure you want to delete this food item?")) {
                window.location.href = `http://localhost/Grabandgo/final-project-grab-go/Restaurant/deletefood.php?id=${id}`;
            }
        }
    </script>
</body>
</html>
