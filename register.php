<?php
include('./conn/conn.php');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and retrieve input
    $firstName = filter_var(trim($_POST['first_name']), FILTER_SANITIZE_STRING);
    $lastName = filter_var(trim($_POST['last_name']), FILTER_SANITIZE_STRING);
    $address = filter_var(trim($_POST['address']), FILTER_SANITIZE_STRING);
    $contactNumber = filter_var(trim($_POST['contact_number']), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $username = filter_var(trim($_POST['username']), FILTER_SANITIZE_STRING);
    $password = $_POST['password']; // Will be hashed later

    // Validation patterns
    $nameRegex = "/^[a-zA-Z]{2,}$/";
    $phoneRegex = "/^[0-9]{10}$/";
    $emailRegex = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
    $usernameRegex = "/^[a-zA-Z0-9_]{4,}$/";
    $passwordRegex = "/^(?=.*[A-Z])(?=.*\d).{8,}$/";

    // Validate First & Last Name
    if (!preg_match($nameRegex, $firstName) || !preg_match($nameRegex, $lastName)) {
        header("Location: register.php?error=Invalid name format.");
        exit();
    }

    // Validate Address
    if (strlen($address) < 5) {
        header("Location: register.php?error=Address must be at least 5 characters long.");
        exit();
    }

    // Validate Contact Number
    if (!preg_match($phoneRegex, $contactNumber)) {
        header("Location: register.php?error=Invalid contact number.");
        exit();
    }

    // Validate Email
    if (!preg_match($emailRegex, $email)) {
        header("Location: register.php?error=Invalid email format.");
        exit();
    }

    // Validate Username
    if (!preg_match($usernameRegex, $username)) {
        header("Location: register.php?error=Invalid username format.");
        exit();
    }

    // Validate Password
    if (!preg_match($passwordRegex, $password)) {
        header("Location: register.php?error=Password must be at least 8 characters long, include one uppercase letter and one number.");
        exit();
    }

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insert into the database
    $query = "INSERT INTO tbl_otp (username, password, first_name, last_name, email, contact_number, address) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if ($stmt->execute([$username, $hashedPassword, $firstName, $lastName, $email, $contactNumber, $address])) {
        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['tbl_user_id'] = $conn->lastInsertId();

        // Redirect to customer dashboard
        header("Location: http://localhost/Grabandgo/final-project-grab-go/Customer/customerdashboard.php?id=" . $_SESSION['tbl_user_id']);
        exit();
    } else {
        header("Location: register.php?error=Registration failed.");
        exit();
    }
}
?>


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
            justify-content: center;
            align-items: center;
            background-color: #f7e4a3; 
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            height: 100vh;
        }

        .login-form, .registration-form {
            backdrop-filter: blur(100px);
            color: rgb(7, 0, 0);
            padding: 40px;
            width: 500px;
            border: 2px solid;
            border-radius: 10px;
        }
        .switch-form-link {
            text-decoration: underline;
            cursor: pointer;
            color: rgb(1, 1, 11);
        }

        /* Custom Dropdown Styling */
        select {
            background-color: black;
            color: white;
            border: 1px solid black;
            appearance: none;
            padding: 10px;
            border-radius: 5px;
        }

        select option {
            background-color: white;
            color: black;
        }

        select option:checked,
        select option:hover {
            background-color: black;
            color: white;
        }
        .login-btn {
    background-color: black !important;
    color: white !important;
    border: none;
    padding: 10px;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: 0.3s;
}

.login-btn:hover {
    background-color: #333 !important; /* Darker black on hover */
}
.register-btn {
    background-color: black !important;
    color: white !important;
    border: none;
    padding: 10px;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: 0.3s;
}

.register-btn:hover {
    background-color: #333 !important; /* Darker black on hover */
}
    </style>
</head>
<body>
    
    <div class="main">

        <!-- Login Area -->

        <div class="login-container">

            <div class="login-form" id="loginForm">
                <h2 class="text-center">Welcome Back!</h2>
                <p class="text-center">Fill your login details.</p>
                <form action="./endpoint/login.php" method="POST">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" id="username" name="username" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" autocomplete="new-password">
                    </div>
                    <div class="form-group">
                <select class="form-control" name="user_type" required>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                    <option value="owner">Owner</option>
                    
                </select>
            </div>
                    <p>No Account? Register <span  class="switch-form-link" onclick="showRegistrationForm()">Here.</span></p>
                    <button type="submit" class="btn btn-secondary login-btn form-control" >Login</button>
                    <div class="text-center mt-3">
                        <a href="forgotpassword.php" class="switch-form-link">Forgot Password?</a>
                    </div>
                </form>
            </div>

        </div>



        <!-- Registration Area -->
        <div class="registration-form" id="registrationForm">
            <h2 class="text-center">Registration Form</h2>
            <p class="text-center">Fill in you personal details.</p>
            <form action="./endpoint/add-user.php" method="POST">
                <div class="form-group registration row">
                    <div class="col-6">
                        <label for="firstName">First Name:</label>
                        <input type="text" class="form-control" id="firstName" name="first_name">
                    </div>
                    <div class="col-6">
                        <label for="lastName">Last Name:</label>
                        <input type="text" class="form-control" id="lastName" name="last_name">
                    </div>
                </div>
                <div class="col-7">
                        <label for="address">Address:</label>
                        <input type="text" class="form-control" id="address" name="address">
                    </div>
                <div class="form-group registration row">
                    <div class="col-5">
                        <label for="contactNumber">Contact Number:</label>
                        <input type="text" class="form-control" id="contactNumber" name="contact_number" maxlength="10" pattern="\d*" title="Only numbers are allowed">

                    </div>
                    <div class="col-7">
                        <label for="email">Email:</label>
                        <input type="text" class="form-control" id="email" name="email">
                    </div>
                </div>
                <div class="form-group registration">
                    <label for="registerUsername">Username:</label>
                    <input type="text" class="form-control" id="registerUsername" name="username" autocomplete="off">
                </div>
                <div class="form-group registration">
                    <label for="registerPassword">Password:</label>
                    <input type="password" class="form-control" id="registerPassword" name="password" autocomplete="new-password">
                </div>
                <p>Already have an account? Login <span class="switch-form-link" onclick="showLoginForm()">Here.</span></p>
                <button type="submit" class="btn btn-dark login-register form-control" name="register">Register</button>

            </form>

        </div>

    </div>

    <script>
        const loginForm = document.getElementById('loginForm');
        const registrationForm = document.getElementById('registrationForm');

        registrationForm.style.display = "none";


        function showRegistrationForm() {
            registrationForm.style.display = "";
            loginForm.style.display = "none";
        }

        function showLoginForm() {
            registrationForm.style.display = "none";
            loginForm.style.display = "";
        }

        function sendVerificationCode() {
            const registrationElements = document.querySelectorAll('.registration');

            registrationElements.forEach(element => {
                element.style.display = 'none';
            });

            const verification = document.querySelector('.verification');
            if (verification) {
                verification.style.display = 'none';
            }
        }
        
document.getElementById("registerForm").addEventListener("submit", function (event) {
    let password = document.getElementById("password").value;
    let email = document.getElementById("email").value;
    let contact = document.getElementById("contact_number").value;
    
    let passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W]).{8,}$/;
    let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    let contactRegex = /^[0-9]{10,15}$/;

    if (!emailRegex.test(email)) {
        alert("Invalid email format.");
        event.preventDefault();
    }

    if (!passwordRegex.test(password)) {
        alert("Password must be at least 8 characters, include uppercase, lowercase, a number, and a special character.");
        event.preventDefault();
    }

    if (!contactRegex.test(contact)) {
        alert("Invalid contact number.");
        event.preventDefault();
    }
});
    </script>

    <!-- Bootstrap Js -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

</body>
</html>