<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dispatcher Dashboard</title>
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f3f4f6;
            color: #333;
        }
        header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
        }
        header h1 {
            font-size: 1.8rem;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], button, input[type="checkbox"] {
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #007bff;
            color: white;
            cursor: pointer;
            border: none;
        }
        button:hover {
            background-color: #0056b3;
        }
        .details {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
        }
        .details p {
            margin: 8px 0;
        }
        .checkbox-group {
            margin: 15px 0;
        }
        .checkbox-group label {
            font-size: 1rem;
            display: inline-block;
            margin-left: 10px;
        }
        .success {
            color: #155724;
            background-color: #d4edda;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
            display: none;
        }
    </style>
</head>
<body>
    <header>
        <h1>Dispatcher Dashboard</h1>
    </header>
    <div class="container">
        <!-- Input Token ID -->
        <div class="form-group">
            <label for="token-id">Enter Token ID</label>
            <input type="text" id="token-id" placeholder="Enter token ID to view request">
        </div>
        <button onclick="viewRequest()">View Request</button>
        
        <!-- Request Details -->
        <div id="request-details" class="details" style="display: none;">
            <h2>Request Details</h2>
            <p><strong>Order ID:</strong> <span id="order-id">--</span></p>
            <p><strong>Customer Name:</strong> <span id="customer-name">--</span></p>
            <p><strong>Address:</strong> <span id="delivery-address">--</span></p>
            <button onclick="confirmRequest()">Confirm Request</button>
            <div id="confirm-message" class="success">Request confirmed!</div>
        </div>
        
        <!-- Status Update -->
        <div id="status-section" class="details" style="display: none;">
            <h2>Update Status</h2>
            <div class="checkbox-group">
                <input type="checkbox" id="status-available" onchange="toggleStatus('available')">
                <label for="status-available">Available</label>
            </div>
            <div class="checkbox-group">
                <input type="checkbox" id="status-picked-up" onchange="toggleStatus('picked-up')">
                <label for="status-picked-up">Picked Up</label>
            </div>
            <div class="checkbox-group">
                <input type="checkbox" id="status-on-way" onchange="toggleStatus('on-way')">
                <label for="status-on-way">On the Way</label>
            </div>
            <div class="checkbox-group">
                <input type="checkbox" id="status-arrived" onchange="toggleStatus('arrived')">
                <label for="status-arrived">Arrived</label>
            </div>
            <div id="status-message" class="success">Status updated successfully!</div>
        </div>
    </div>

    <script>
        // Mock data for requests
        const requests = {
            TOK123: {
                orderId: "1001",
                customerName: "John Doe",
                address: "123 Elm Street"
            },
            TOK456: {
                orderId: "1002",
                customerName: "Jane Smith",
                address: "456 Oak Avenue"
            }
        };

        // Function to view request details
        function viewRequest() {
            const tokenId = document.getElementById('token-id').value;
            const detailsSection = document.getElementById('request-details');
            const statusSection = document.getElementById('status-section');
            const request = requests[tokenId];

            if (request) {
                // Update details section with request data
                document.getElementById('order-id').textContent = request.orderId;
                document.getElementById('customer-name').textContent = request.customerName;
                document.getElementById('delivery-address').textContent = request.address;

                detailsSection.style.display = "block";
                statusSection.style.display = "block";
            } else {
                alert("Request not found for the provided token ID.");
                detailsSection.style.display = "none";
                statusSection.style.display = "none";
            }
        }

        // Function to confirm a request
        function confirmRequest() {
            const confirmMessage = document.getElementById('confirm-message');
            confirmMessage.style.display = "block";
            setTimeout(() => {
                confirmMessage.style.display = "none";
            }, 2000);
        }

        // Function to toggle status updates
        function toggleStatus(statusType) {
            const statusMessage = document.getElementById('status-message');
            statusMessage.textContent = `Status updated to: ${statusType.replace("-", " ")}`;
            statusMessage.style.display = "block";

            setTimeout(() => {
                statusMessage.style.display = "none";
            }, 2000);
        }
    </script>
</body>
</html>
