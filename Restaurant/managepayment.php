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
            background-color:#FFE0B2;
            color: #333;
        }
        /* Sidebar Styles */
        .sidebar {
    width: 250px;
    background: linear-gradient(135deg, #f7b733, #fc4a1a); /* Gradient Background */
    color: #fff;
    height: 100vh;
    display: flex;
    flex-direction: column;
    padding: 20px 15px;
    position: fixed;
    top: 0;
    left: 0;
    box-shadow: 4px 0 10px rgba(0, 0, 0, 0.2); /* Soft shadow for depth */
}

.sidebar h2 {
    font-size: 1.5rem;
    font-weight: bold;
    margin-bottom: 20px;
    text-transform: uppercase;
    text-align: center;
    letter-spacing: 1px;
}

.sidebar a {
    color: #000;
    text-decoration: none;
    padding: 12px 15px;
    border-radius: 5px;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    font-size: 1.1rem;
    transition: all 0.3s ease-in-out;
    font-weight: 500;
}

.sidebar a:hover {
    background: #000; /* Semi-transparent hover effect */
    color: #fff;
    transform: translateX(5px); /* Subtle movement effect */
}

/* Optional: Add icons next to menu items */
.sidebar a i {
    margin-right: 10px;
    font-size: 1.2rem;
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
    <a href="das.php"><i class="fas fa-home"></i> Dashboard</a>
<a href="addfood.php"><i class="fas fa-utensils"></i> Add Food</a>
<a href="viewfood.php"><i class="fas fa-list"></i> View Food</a>
<a href="vieworder.php"><i class="fas fa-shopping-cart"></i> View Order</a>
<a href="managepayment.php"><i class="fas fa-money-bill"></i> View Payment</a>
<a href="account.php"><i class="fas fa-user"></i> Account</a>
<a href="updateprofile.php"><i class="fas fa-cog"></i> Profile</a>
<a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
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
