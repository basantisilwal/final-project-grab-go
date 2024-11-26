<?php include('../conn/conn.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <title>Admin Panel</title>
    <style>
        body {
            font-size: 0.9rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            height: 100vh;
        }
        .sidebar {
            width: 250px;
            background-color: #000;
            color: #fff;
            height: 100vh;
            display: flex;
            flex-direction: column;
            padding: 20px 15px;
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
        .content {
            padding: 30px;
            margin-left: 250px;
            width: calc(100% - 250px);
        }

        .table {
            color: rgb(26, 22, 22) !important;
        }

        td button {
            font-size: 20px;
            width: 31px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary" style="width: 100%;">
        <a class="navbar-brand ml-5" href="#">Admin Panel</a>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <a class="nav-link" href="./logout.php">Log Out</a>
            </li>
        </ul>
    </nav>

    <!-- Sidebar -->
    <aside class="sidebar">
        <h2>Admin Dashboard</h2>
        <a href="admindashboard.php">Dashboard</a>
        <a href="manage.php">Manage Restaurants</a>
        <a href="customer.php">View Customers</a>
        <a href="setting.php">Settings</a>
        <a href="logout.php">Logout</a>
    </aside>

    <!-- Main Content -->
    <div class="content">
        <h4>List of Users</h4>
        <hr>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">User ID</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Address</th>
                    <th scope="col">Contact</th>
                    <th scope="col">Email</th>
                    <th scope="col">Username</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $conn->prepare("SELECT * FROM tbl_otp");
                $stmt->execute();
                $users = $stmt->fetchAll();

                foreach ($users as $user) { ?>
                    <tr>
                        <td><?= htmlspecialchars($user['tbl_user_id']); ?></td>
                        <td><?= htmlspecialchars($user['first_name']); ?></td>
                        <td><?= htmlspecialchars($user['last_name']); ?></td>
                        <td><?= htmlspecialchars($user['address']); ?></td>
                        <td><?= htmlspecialchars($user['contact_number']); ?></td>
                        <td><?= htmlspecialchars($user['email']); ?></td>
                        <td><?= htmlspecialchars($user['username']); ?></td>
                        <td>
                            <button onclick="updateUser(<?= $user['tbl_user_id']; ?>)" class="btn btn-primary btn-sm">Edit</button>
                            <button onclick="deleteUser(<?= $user['tbl_user_id']; ?>)" class="btn btn-danger btn-sm">Delete</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Modal for Update -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="updateUserForm" method="POST" action="update_user.php">
                    <div class="modal-header">
                        <h5 class="modal-title">Update User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="tbl_user_id" id="updateUserId">
                        <div class="mb-3">
                            <label for="updateFirstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" name="first_name" id="updateFirstName" required>
                        </div>
                        <div class="mb-3">
                            <label for="updateLastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" name="last_name" id="updateLastName" required>
                        </div>
                        <div class="mb-3">
                            <label for="updateAddress" class="form-label">Address</label>
                            <input type="text" class="form-control" name="address" id="updateAddress" required>
                        </div>
                        <div class="mb-3">
                            <label for="updateContact" class="form-label">Contact</label>
                            <input type="text" class="form-control" name="contact_number" id="updateContact" required>
                        </div>
                        <div class="mb-3">
                            <label for="updateEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="updateEmail" required>
                        </div>
                        <div class="mb-3">
                            <label for="updateUsername" class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" id="updateUsername" required>
                        </div>
                        <div class="mb-3">
                            <label for="updatePassword" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" id="updatePassword" placeholder="Leave blank to keep existing">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        function updateUser(id) {
            const row = document.querySelector(`tr[data-id='${id}']`);
            document.getElementById('updateUserId').value = id;
            document.getElementById('updateFirstName').value = row.querySelector('.first_name').innerText;
            document.getElementById('updateLastName').value = row.querySelector('.last_name').innerText;
            // Continue filling the modal...
            new bootstrap.Modal(document.getElementById('updateModal')).show();
        }

        function deleteUser(id) {
            if (confirm('Are you sure you want to delete this user?')) {
                window.location.href = `delete_user.php?id=${id}`;
            }
        }
    </script>
</body>
</html>
