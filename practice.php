<?php
session_start();
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'grab&go';
$errorMessage = '';

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $userType = $_POST['user_type'];

    switch ($userType) {
        case 'Admin':
            $table = 'tbl_admin';
            $dashboard = 'Admin/admindashboard.php';
            break;
        case 'Resturant':
            $table = 'tbl_resturant';
            $dashboard = 'Resturant/restaurantdashboard.php';
            break;
        case 'Customer':
            $table = 'tbl_customer';
            $dashboard = 'Customer/customerdashboard.php';
            break;
        case 'Dispatcher':
            $table = 'tbl_dispatcher';
            $dashboard = 'Dispatcher/dispatcherdashboard.php';
            break;
        default:
            $errorMessage = "Invalid user type selected";
            break;
    }

    if (empty($errorMessage)) {
        $stmt = $conn->prepare("SELECT * FROM $table WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['username'] = $username;
            header("Location: $dashboard");
            exit();
        } else {
            $errorMessage = "Invalid username or password.";
        }

        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GRAB&GO</title>
    <!-- ADD BOOTSTRAP CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- ADD POPPINS FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- ADD BOOTSTRAP ICONS CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: beige;
        }

        .contact-form {
            background-color: #F6BE00;
            color: #333;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .contact-form input,
        .contact-form textarea {
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            width: 100%;
            margin-bottom: 15px;
        }

        .contact-form button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .contact-form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<!-- NAVIGATION BAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-white px-lg-3 py-lg-2 fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand me-6 fq-bold fs-3" href="index.html">Grab and Go</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link me-2" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link me-2" href="#about">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link me-2" href="#contact">Contact Us</a>
                </li>
                <li class="nav-item">
                    <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body login-container">
                <div class="right-section">
                    <h1>LOG IN</h1>
                    <p>Welcome!! Login or signup to access our website</p>
                    <form id="login-form" method="POST" action="">
                        <div class="mb-3">
                            <label for="username">Username:</label>
                            <input type="text" class="form-control" id="username" name="username" required placeholder="Enter correct Username">
                        </div>
                        <div class="mb-3">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" id="password" name="password" required placeholder="Enter correct Password">
                        </div>
                        <!-- Dropdown menu -->
                        <label for="user-type">Select User Type:</label>
                        <select name="user_type" class="form-control" id="userTypeDropdown" required>
                            <option value="">Choose an option</option>
                            <option value="Admin">Admin</option>
                            <option value="Resturant">Resturant</option>
                            <option value="Customer">Customer</option>
                            <option value="Dispatcher">Dispatcher</option>
                        </select><br />
                        <button type="submit" class="btn btn-primary">LOG IN</button>
                    </form>
                    <p class="signup-text">
                        Not registered? <a href="#" data-bs-toggle="modal" data-bs-target="#registerModal">Create an account...!</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="registerForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">Register Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-10 mb-3">
                                <label class="form-label">Name</label>
                                <textarea class="form-control shadow" name="name" rows="1" required></textarea>
                            </div>
                            <div class="col-md-10 mb-3">
                                <label class="form-label">Address</label>
                                <textarea class="form-control shadow" name="address" rows="1" required></textarea>
                            </div>
                            <div class="col-md-10 mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="number" class="form-control shadow-none" name="phone" required>
                            </div>
                            <div class="col-md-10 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control shadow-none" name="email" required>
                            </div>
                            <div class="col-md-10 mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control shadow-none" name="password" required>
                            </div>
                            <div class="col-md-10 mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" class="form-control shadow-none" name="confirm_password" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Include Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
