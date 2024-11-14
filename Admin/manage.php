<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="astyle.css">
    <title>Restaurant Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-size: 0.9rem;
        }
        .sidebar {
            height: 100vh;
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        .sidebar .nav-link {
            color: #333;
            padding: 0.5rem 1rem;
        }
        .sidebar .nav-link:hover {
            background-color: #e9ecef;
        }
        .sidebar .nav-link.active {
            background-color: #0d6efd;
            color: white;
        }
        .main-content {
            padding: 15px;
        }
    </style>
</head>
<body>
<div class="main-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Admin Dashboard</h2>
            </div>
            <ul class="sidebar-menu">
            <a href="admindashboard.php" class="nav-link active">Dashboard</a>
      <a href="manage.php" class="nav-link"> Manage Restaurants</a>
      <a href="customer.php" class="nav-link">View Costumer </a>
      <a href="setting.php" class="nav-link"> Setting</a>
      <a href="index.php" class="nav-link">  Logout </a>
            </ul>
        </aside>
    </div>


    <div class="container">
        <h2>Add New Restaurant</h2>
        <form id="restaurantForm" method="POST" action="">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" required>

            <label for="address">Address</label>
            <textarea id="address" name="address" required></textarea>

            <label for="date">Date</label>
            <input type="date" id="date" name="date" required>

            <label for="time">Time</label>
            <input type="time" id="time" name="time" required>

            <label for="email">Email ID</label>
            <input type="email" id="email" name="email" required>

            <label for="contact">Contact No</label>
            <input type="tel" id="contact" name="contact" required>

            <div class="buttons">
                <button type="button" onclick="goBack()">Back</button>
                <button type="button" onclick="addRestaurant()">Add</button>
                <button type="button" onclick="deleteRestaurant()">Delete</button>
                <button type="button" onclick="updateRestaurant()" id="updateButton" style="display:none;">Update</button>
            </div>
        </form>

        <table>
            <thead>
                <tr>
                    <th>SN</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Email</th>
                    <th>Contact No</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="restaurantTable">
                <!-- Restaurant rows will be added here dynamically -->
            </tbody>
        </table>
    </div>

    <script>
        let editIndex = -1;

        function addRestaurant() {
            const table = document.getElementById("restaurantTable");

            const name = document.getElementById("name").value;
            const address = document.getElementById("address").value;
            const email = document.getElementById("email").value;
            const contact = document.getElementById("contact").value;

            const row = table.insertRow();
            row.insertCell(0).textContent = table.rows.length;
            row.insertCell(1).textContent = name;
            row.insertCell(2).textContent = address;
            row.insertCell(3).textContent = email;
            row.insertCell(4).textContent = contact;

            // Add action buttons
            const actionsCell = row.insertCell(5);
            actionsCell.innerHTML = `<button onclick="editRestaurant(this)">Edit</button> <button onclick="deleteRow(this)">Delete</button>`;

            // Clear the form after adding the entry
            document.getElementById("restaurantForm").reset();
        }

        function editRestaurant(button) {
            // Get the row index and store it for updating
            editIndex = button.parentElement.parentElement.rowIndex - 1;

            const table = document.getElementById("restaurantTable");
            const row = table.rows[editIndex];

            // Populate form with row data
            document.getElementById("name").value = row.cells[1].textContent;
            document.getElementById("address").value = row.cells[2].textContent;
            document.getElementById("email").value = row.cells[3].textContent;
            document.getElementById("contact").value = row.cells[4].textContent;

            // Show update button and hide add button
            document.getElementById("updateButton").style.display = "inline";
        }

        function updateRestaurant() {
            const table = document.getElementById("restaurantTable");

            if (editIndex > -1) {
                const row = table.rows[editIndex];
                row.cells[1].textContent = document.getElementById("name").value;
                row.cells[2].textContent = document.getElementById("address").value;
                row.cells[3].textContent = document.getElementById("email").value;
                row.cells[4].textContent = document.getElementById("contact").value;

                // Clear form and reset edit index
                document.getElementById("restaurantForm").reset();
                editIndex = -1;

                // Hide update button and show add button
                document.getElementById("updateButton").style.display = "none";
            }
        }

        function deleteRow(button) {
            const row = button.parentElement.parentElement;
            row.remove();
        }

        function deleteRestaurant() {
            const table = document.getElementById("restaurantTable");
            if (table.rows.length > 0) {
                table.deleteRow(table.rows.length - 1);
            }
        }

        function goBack() {
            alert("Back button clicked");
        }
    </script>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "`grab&go`";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $name = $_POST['name'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $contact = $_POST['contact'];

        $sql = "INSERT INTO tbl_restaurantname (name, address, email, contact) VALUES ('$name', '$address', '$email', '$contact')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('New record created successfully');</script>";
        } else {
            echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "');</script>";
        }

        $conn->close();
    }
    ?>
</body>
</html>
