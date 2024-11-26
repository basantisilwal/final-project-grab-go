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
        <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Food Table</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f9f9f9;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    /* Main Layout: Sidebar and Content */
    .main-layout {
            display: flex;
            height: 100vh; /* Full viewport height */
        }

        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background-color: #000; /* Black background */
            color: #fff;
            height: 100%;
            display: flex;
            flex-direction: column;
            padding: 20px 15px;
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

    .container {
      text-align: center;
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
      width: 80%;
      max-width: 600px;
    }

    h1 {
      margin-bottom: 20px;
      color: #333;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    th, td {
      border: 1px solid #ddd;
      padding: 10px;
      text-align: left;
    }

    th {
      background-color: #f4a261;
      color: #fff;
    }

    tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    tr:hover {
      background-color: #f1e3cc;
    }

    button {
      padding: 10px 20px;
      background-color: #2a9d8f;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
    }

    button:hover {
      background-color: #21867a;
    }
  </style>
</head>
<body>
<aside class="sidebar">
    <h2>Restaurant Dashboard</h2>
    <a href="das.php">Dashboard</a>
    <a href="myproject.php">My Project</a>
    <a href="addfood.php">Add Food</a>
    <a href="viewfood.php">View food</a>
    <a href="managepayment.php">View payment</a>
    <a href="account.php">Account</a>
    <a href="updateprofile.php">Profile</a>
    <a href="#">Logout</a>
    </aside>
  <div class="container">
    <h1>Food Menu</h1>
    <table id="foodTable">
      <thead>
        <tr>
          <th>Food Item</th>
          <th>Category</th>
          <th>Price</th>
        </tr>
      </thead>
      <tbody id="tableBody">
        <!-- Rows will be added dynamically -->
      </tbody>
    </table>
    <button id="addFoodBtn">Add Food</button>
  </div>
  <script>
    const foodTableBody = document.getElementById('tableBody');
    const addFoodButton = document.getElementById('addFoodBtn');

    // Sample data
    const foodItems = [
      { name: 'Pizza', category: 'Fast Food', price: '$8.99' },
      { name: 'Burger', category: 'Fast Food', price: '$5.99' },
      { name: 'Pasta', category: 'Italian', price: '$7.50' },
    ];

    // Function to render the table
    function renderTable() {
      foodTableBody.innerHTML = ''; // Clear previous rows
      foodItems.forEach((food) => {
        const row = document.createElement('tr');
        row.innerHTML = `
          <td>${food.name}</td>
          <td>${food.category}</td>
          <td>${food.price}</td>
        `;
        foodTableBody.appendChild(row);
      });
    }

    // Add food item (demo functionality)
    addFoodButton.addEventListener('click', () => {
      const newFood = { name: 'Salad', category: 'Healthy', price: '$4.99' };
      foodItems.push(newFood);
      renderTable();
    });

    // Initial render
    renderTable();
  </script>
</body>
</html>
