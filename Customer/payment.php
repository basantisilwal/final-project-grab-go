<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Payment Management</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
        }

        .container {
            max-width: 1000px;
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

        .payment-form, .payment-history {
            margin-top: 30px;
        }

        .payment-form h2, .payment-history h2 {
            color: #444;
            border-bottom: 3px solid #007bff;
            padding-bottom: 5px;
        }

        form label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        form input, form select, form textarea, form button {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        form button {
            background: #28a745;
            color: #fff;
            font-size: 16px;
            margin-top: 20px;
            cursor: pointer;
            border: none;
        }

        form button:hover {
            background: #218838;
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
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Restaurant Payment Management</h1>
        </header>
        <main>
            <div class="payment-form">
                <h2>Record Customer Payment</h2>
                <form id="paymentForm">
                    <label for="customerName">Customer Name:</label>
                    <input type="text" id="customerName" placeholder="Enter customer's name" required>

                    <label for="paymentMethod">Payment Method:</label>
                    <select id="paymentMethod" required>
                        <option value="" disabled selected>Select a payment method</option>
                        <option value="Cash">Cash</option>
                        <option value="Credit Card">Credit Card</option>
                        <option value="Digital Wallet">Digital Wallet</option>
                    </select>

                    <label for="amount">Amount:</label>
                    <input type="number" id="amount" placeholder="Enter total amount" required>

                    <label for="orderDetails">Order Details:</label>
                    <textarea id="orderDetails" rows="4" placeholder="Enter items ordered (optional)"></textarea>

                    <label for="date">Payment Date:</label>
                    <input type="date" id="date" required>

                    <button type="submit">Add Payment</button>
                </form>
            </div>
            <div class="payment-history">
                <h2>Payment History</h2>
                <table id="paymentTable">
                    <thead>
                        <tr>
                            <th>Customer Name</th>
                            <th>Payment Method</th>
                            <th>Amount</th>
                            <th>Order Details</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Payment history entries will appear here -->
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    <script>
        document.getElementById('paymentForm').addEventListener('submit', function (event) {
            event.preventDefault();

            // Get input values
            const customerName = document.getElementById('customerName').value;
            const paymentMethod = document.getElementById('paymentMethod').value;
            const amount = parseFloat(document.getElementById('amount').value).toFixed(2);
            const orderDetails = document.getElementById('orderDetails').value || 'N/A';
            const date = document.getElementById('date').value;

            // Validate input
            if (!customerName || !paymentMethod || !amount || !date) {
                alert('Please fill out all required fields.');
                return;
            }

            // Add new payment to the table
            const tableBody = document.getElementById('paymentTable').querySelector('tbody');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${customerName}</td>
                <td>${paymentMethod}</td>
                <td>$${amount}</td>
                <td>${orderDetails}</td>
                <td>${date}</td>
            `;
            tableBody.appendChild(newRow);

            // Clear form fields
            document.getElementById('paymentForm').reset();
        });
    </script>
</body>
</html>
