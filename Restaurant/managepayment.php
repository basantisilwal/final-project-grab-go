<?php include('../conn/conn.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="rstyle.css">
    <title>Restaurant Payment Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
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

        .container {
            max-width: 900px;
            margin: 30px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .payment-history {
            margin-top: 30px;
        }

        .payment-history h2 {
            color: #444;
            border-bottom: 3px solid #007bff;
            padding-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 14px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
            padding: 10px;
            text-align: left;
        }

        td {
            padding: 10px;
            text-align: center;
        }

        .action-buttons button {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
        }

        .confirm-btn {
            background-color: #28a745;
            color: white;
        }

        .confirm-btn:hover {
            background-color: #218838;
        }

        .cancel-btn {
            background-color: #dc3545;
            color: white;
        }

        .cancel-btn:hover {
            background-color: #c82333;
        }

        .status {
            font-weight: bold;
        }

        .status.confirmed {
            color: green;
        }

        .status.cancelled {
            color: red;
        }
    </style>
</head>
<body>
<aside class="sidebar">
    <h2>Restaurant Dashboard</h2>
    <a href="das.php">Dashboard</a>
    <a href="addfood.php">Add Food</a>
    <a href="viewfood.php">View food</a>
    <a href="#">View Order</a>
    <a href="managepayment.php">View payment</a>
    <a href="account.php">Account</a>
    <a href="updateprofile.php">Profile</a>
    <a href="logout.php">Logout</a>
</aside>
    <div class="container">
        <header>
            <h1>Restaurant Payment Management</h1>
        </header>
        <main>
            <div class="payment-history">
                <h2>Order Payments</h2>
                <table id="paymentTable">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer Name</th>
                            <th>Payment Method</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Sample orders -->
                        <tr>
                            <td>#1001</td>
                            <td>John Doe</td>
                            <td>Credit Card</td>
                            <td>$50.00</td>
                            <td class="status">Pending</td>
                            <td class="action-buttons">
                                <button class="confirm-btn" onclick="updateStatus(this, 'Confirmed')">Confirm</button>
                                <button class="cancel-btn" onclick="updateStatus(this, 'Cancelled')">Cancel</button>
                            </td>
                        </tr>
                        <tr>
                            <td>#1002</td>
                            <td>Jane Smith</td>
                            <td>Cash</td>
                            <td>$30.00</td>
                            <td class="status">Pending</td>
                            <td class="action-buttons">
                                <button class="confirm-btn" onclick="updateStatus(this, 'Confirmed')">Confirm</button>
                                <button class="cancel-btn" onclick="updateStatus(this, 'Cancelled')">Cancel</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
        </div>
    <script>
        function updateStatus(button, status) {
            // Locate the row of the clicked button
            const row = button.closest('tr');

            // Update the status column
            const statusCell = row.querySelector('.status');
            statusCell.textContent = status;
            statusCell.className = `status ${status.toLowerCase()}`;

            // Disable action buttons after the order is updated
            const actionButtons = row.querySelectorAll('button');
            actionButtons.forEach(btn => btn.disabled = true);
        }
    </script>
</body>
</html>
