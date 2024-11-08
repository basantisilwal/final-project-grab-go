<?php include ('./conn/conn.php') ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login System with Email Verification</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap');

        * {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-image: url("https://images.unsplash.com/photo-1485470733090-0aae1788d5af?q=80&w=1517&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D");
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            height: 100vh;
        }

        .content {
            backdrop-filter: blur(100px);
            color: rgb(255, 255, 255);
            padding: 40px;
            border: 2px solid;
            border-radius: 10px;
            margin-top: 100px;
        }

        .table {
            color: rgb(255, 255, 255) !important;
        }

        td button {
            font-size: 20px;
            width: 30px;
        }
    </style>
</head>
<body>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary" style="width: 100%;">
        <a class="navbar-brand ml-5" href="home.php">User Registration and Login System</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="./index.php">Log Out</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Update Modal -->
    <div class="modal fade mt-5" id="updateUserModal" tabindex="-1" aria-labelledby="updateUser" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateUserModal">Update User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="./endpoint/update-user.php" method="POST">
                        <div class="form-group row">
                            <div class="col-6">
                                <input type="text" name="tbl_otp_id" id="updateUserID" hidden>
                                <label for="updateName">Name:</label>
                                <input type="text" class="form-control" id="updateName" name="name">
                            </div>
                            <div class="col-6">
                                <label for="updateAddress">Address:</label>
                                <input type="text" class="form-control" id="updateAddress" name="address">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-5">
                                <label for="updatePhoneNumber">Phone Number:</label>
                                <input type="number" class="form-control" id="updatePhoneNumber" name="phone_number" maxlength="11">
                            </div>
                            <div class="col-7">
                                <label for="updateEmail">Email:</label>
                                <input type="text" class="form-control" id="updateEmail" name="email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="updateUsername">Username:</label>
                            <input type="text" class="form-control" id="updateUsername" name="username">
                        </div>
                        <div class="form-group">
                            <label for="updatePassword">Password:</label>
                            <input type="text" class="form-control" id="updatePassword" name="password">
                        </div>
                        <button type="submit" class="btn btn-dark login-register form-control">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="content">
        <h4>List of users</h4>
        <hr>
        <table class="table table-hover table-collapse">
            <thead>
                <tr>
                <th scope="col">User ID</th>
                <th scope="col"> Name</th>
                <th scope="col">Address</th>
                <th scope="col">Phone Number</th>
                <th scope="col">Email</th>
                <th scope="col">Username</th>
                <th scope="col">Password</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>

                <?php 
                
                    $stmt = $conn->prepare("SELECT * FROM `tbl_otp`");
                    $stmt->execute();

                    $result = $stmt->fetchAll();

                    foreach ($result as $row) {
                        $userID = $row['user_id'];
                        $name = $row['name'];
                        $address = $row['address'];
                        $phoneNumber = $row['phone_number'];
                        $email = $row['email'];
                        $username = $row['username'];
                        $password = $row['password'];

                    ?>

                    <tr>
                        <td id="userID-<?= $userID ?>"><?php echo $userID ?></td>
                        <td id="name-<?= $userID ?>"><?php echo $firstName ?></td>
                        <td id="address-<?= $userID ?>"><?php echo $address?></td>
                        <td id="phoneNumber-<?= $userID ?>"><?php echo $phoneNumber ?></td>
                        <td id="email-<?= $userID ?>"><?php echo $email ?></td>
                        <td id="username-<?= $userID ?>"><?php echo $username ?></td>
                        <td id="password-<?= $userID ?>"><?php echo $password ?></td>
                        <td>
                            <button id="editBtn" onclick="update_user(<?php echo $userID ?>)" title="Edit">&#9998;</button>
                            <button id="deleteBtn" onclick="delete_user(<?php echo $userID ?>)">&#128465;</button>
                        </td>
                    </tr>    

                    <?php
                    }

                ?>
            </tbody>
        </table>
    </div>

    <script>
        // Update user
        function update_user(id) {
            $("#updateUserModal").modal("show");

            let updateUserID = $("#userID-" + id).text();
            let updateName = $("#Name-" + id).text();
            let updateAddress = $("#address-" + id).text();
            let updatePhoneNumber = $("#PhoneNumber-" + id).text();
            let updateEmail = $("#email-" + id).text();
            let updateUsername = $("#username-" + id).text();
            let updatePassword = $("#password-" + id).text();

            console.log(updateName);

            $("#updateUserID").val(updateUserID);
            $("#updateFirstName").val(updateName);
            $("#updateLastName").val(updateAddress);
            $("#updateContactNumber").val(updatePhoneNumber);
            $("#updateEmail").val(updateEmail);
            $("#updateUsername").val(updateUsername);
            $("#updatePassword").val(updatePassword);

        }

        // Delete user
        function delete_user(id) {
            if (confirm("Do you want to delete this user?")) {
                window.location = "./endpoint/delete-user.php?user=" + id;
            }
        }


    </script>

    <!-- Bootstrap Js -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

</body>
</html>