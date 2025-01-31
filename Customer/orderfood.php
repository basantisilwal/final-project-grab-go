<?php
include('../conn/conn.php'); ?>
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
        .form-container {
            max-width: 500px;
            padding: 20px;
        }
        .form-group {
            margin-bottom: 12px;
        }
        .form-group label {
            font-size: 14px;
        }
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 8px;
            font-size: 14px;
        }
        .form-group button {
            padding: 10px;
            font-size: 14px;
        }
        #qrCodeContainer {
            display: none;
            text-align: center;
        }
        #qrCodeImage {
            width: 200px;
            height: 200px;
        }
    </style>
</head>
<body>
    <!-- Order Form Modal -->
    <div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="form-container">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h1>Food Order</h1>
                    <form id="orderForm" method="POST" action="">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number:</label>
                            <input type="tel" id="phone" name="phone" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="foodDescription">Food Items:</label>
                            <textarea id="foodDescription" name="foodDescription" class="form-control" placeholder="Enter food item details" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity:</label>
                            <input type="number" id="quantity" name="quantity" class="form-control" value="1" min="1" max="100" required>
                        </div>
                        <div class="form-group">
                            <label for="orderType">Order Type:</label>
                            <select id="orderType" name="orderType" class="form-control" required>
                                <option value="pickup">Pickup</option>
                                <option value="delivery">Delivery</option>
                            </select>
                        </div>
                        <div class="form-group" id="addressGroup" style="display: none;">
                            <label for="address">Delivery Address:</label>
                            <textarea id="address" name="address" class="form-control" placeholder="Enter your address"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="time">Preferred Time:</label>
                            <input type="time" id="time" name="time" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="paymentMethod">Payment Method:</label>
                            <select id="paymentMethod" name="paymentMethod" class="form-control" required>
                                <option value="online">Online Payment</option>
                                <option value="cash">Cash on Delivery</option>
                            </select>
                        </div>
                        <div class="form-group" id="qrCodeContainer">
                            <label>Scan the QR Code to Pay:</label>
                            <img id="qrCodeImage" src="images/download.png" alt="QR Code">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit Order</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
     <script>
        document.addEventListener('DOMContentLoaded', () => {
            const orderType = document.getElementById('orderType');
            const addressGroup = document.getElementById('addressGroup');
            const paymentMethod = document.getElementById('paymentMethod');
            const qrCodeContainer = document.getElementById('qrCodeContainer');

            // Show/hide delivery address field based on initial order type
            if (orderType.value === 'delivery') {
                addressGroup.style.display = 'block';
            }

            // Show/hide delivery address field when order type changes
            orderType.addEventListener('change', () => {
                addressGroup.style.display = orderType.value === 'delivery' ? 'block' : 'none';
            });

            // Show/hide QR code for online payment
            paymentMethod.addEventListener('change', () => {
                qrCodeContainer.style.display = paymentMethod.value === 'online' ? 'block' : 'none';
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
