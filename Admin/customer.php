<?php include('./conn/conn.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grab&Go - User List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url("https://images.unsplash.com/photo-1485470733090-0aae1788d5af?q=80&w=1517&auto=format&fit=crop");
            background-size: cover;
            color: #fff;
        }
        .content {
            backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }
        .table {
            color: #fff;
        }
        td button {
            font-size: 20px;
            width: 30px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-secondary">
    <a class="navbar-brand" href="#">User Registration and Login System</a>
    <a class="btn btn-danger" href="./index.php">Log Out</a>
</nav>

<div class="container content">
    <h4>List of Users</h4>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Address</th>
                <th>Phone Number</th>
                <th>Email</th>
                <th>Username</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt = conn.php->prepare("SELECT * FROM tbl_otp");
            $stmt->execute();
            $users = $stmt->fetchAll();

            foreach ($users as $user) {
                echo "<tr>";
                echo "<td>{$user['user_id']}</td>";
                echo "<td>{$user['name']}</td>";
                echo "<td>{$user['address']}</td>";
                echo "<td>{$user['phone_number']}</td>";
                echo "<td>{$user['email']}</td>";
                echo "<td>{$user['username']}</td>";
                echo "<td>
                        <button class='btn btn-primary' onclick='updateUser({$user['user_id']})'>Edit</button>
                        <button class='btn btn-danger' onclick='deleteUser({$user['user_id']})'>Delete</button>
                      </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Modal for Update User -->
<div class="modal fade" id="updateUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Update User</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="endpoint/update-user.php" method="POST">
                    <input type="hidden" id="userId" name="user_id">
                    <input type="text" id="name" name="name" class="form-control mb-2" placeholder="Name">
                    <input type="text" id="address" name="address" class="form-control mb-2" placeholder="Address">
                    <input type="text" id="phone_number" name="phone_number" class="form-control mb-2" placeholder="Phone">
                    <input type="email" id="email" name="email" class="form-control mb-2" placeholder="Email">
                    <button type="submit" class="btn btn-success">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function updateUser(userId) {
        const modal = document.getElementById('updateUserModal');
        document.getElementById('userId').value = userId;
        $(modal).modal('show');
    }

    function deleteUser(userId) {
        if (confirm("Are you sure you want to delete this user?")) {
            window.location.href = `endpoint/delete-user.php?user_id=${userId}`;
        }
    }
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
