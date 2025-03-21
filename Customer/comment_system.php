<?php
session_start();
include('../conn/conn.php');

$customer_id = $_SESSION['customer_id'] ?? null;

if (!$customer_id) {
    // Redirect to login if not logged in
    header("Location: http://localhost/Grabandgo/final-project-grab-go/Customer/customerdashboard.php");
    exit();
}

// Fetch the user's order history
$sql = "SELECT * FROM tbl_orders WHERE cid = :customer_id ORDER BY order_time DESC";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h1>Order History</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Order Time</th>
                    <th>Food Description</th>
                    <th>Quantity</th>
                    <th>Preferred Time</th>
                    <th>Payment Method</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo date('Y-m-d H:i:s', strtotime($order['order_time'])); ?></td>
                    <td><?php echo htmlspecialchars($order['food_description']); ?></td>
                    <td><?php echo $order['quantity']; ?></td>
                    <td><?php echo $order['preferred_time']; ?></td>
                    <td><?php echo ucfirst($order['payment_method']); ?></td>
                    <td><?php echo ucfirst($order['status']); ?></td>
                    <td>
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#orderDetailsModal" data-order-id="<?php echo $order['id']; ?>">
                            View Details
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Order Details Modal -->
    <div class="modal fade" id="orderDetailsModal" tabindex="-1" role="dialog" aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderDetailsModalLabel">Order Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Order details will be populated here using JavaScript -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#orderDetailsModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var orderId = button.data('order-id');

                // Fetch the order details using AJAX
                $.ajax({
                    url: 'fetch_order_details.php',
                    method: 'POST',
                    data: { order_id: orderId },
                    dataType: 'json',
                    success: function(data) {
                        if (data.success) {
                            // Populate the modal with the order details
                            $('#orderDetailsModalLabel').text('Order #' + data.order.id);
                            $('.modal-body').html(`
                                <p><strong>Order Time:</strong> ${data.order.order_time}</p>
                                <p><strong>Food Description:</strong> ${data.order.food_description}</p>
                                <p><strong>Quantity:</strong> ${data.order.quantity}</p>
                                <p><strong>Preferred Time:</strong> ${data.order.preferred_time}</p>
                                <p><strong>Payment Method:</strong> ${data.order.payment_method}</p>
                                <p><strong>Status:</strong> ${data.order.status}</p>
                            `);
                        } else {
                            alert('Error: ' + data.error);
                        }
                    },
                    error: function() {
                        alert('Error fetching order details.');
                    }
                });
            });
        });
    </script>
</body>
</html>
