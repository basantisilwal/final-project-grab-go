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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- ADD POPPINS FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- ADD BOOTSTRAP ICONS CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    
    <style>

  body {
    background-color: beige; 
  }

  .contact-img img {
    border-radius: 10px; /* Optional: for rounded corners */
    width: 100%; /* Ensure it scales with the container */
    height: auto; /* Maintain aspect ratio */
}

  /* Contact Form Background and Text Color */
  .contact-form {
    background-color: #F6BE00; /* Light grayish blue background */
    color: #333; /* Text color */
    border-radius: 10px; /* Rounded corners */
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Soft shadow */
  }

  /* Customize Input Fields */
  .contact-form input, 
  .contact-form textarea {
    background-color: #ffffff; /* White background for inputs */
    border: 1px solid #ccc; /* Light gray border */
    border-radius: 5px;
    padding: 10px;
    color: #333; /* Text color */
    width: 100%;
    margin-bottom: 15px;
  }

  /* Change Placeholder Color */
  .contact-form input::placeholder,
  .contact-form textarea::placeholder {
    color: #888; /* Light gray placeholder text */
  }

  /* Customize Submit Button */
  .contact-form button {
    background-color: #007bff; /* Blue background for button */
    color: white; /* White text */
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
  }

  /* Hover Effect for Submit Button */
  .contact-form button:hover {
    background-color: #0056b3; /* Darker blue on hover */
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
          <a class="nav-link me-2" aria-current="page" href="#">Home</a>
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
            <div class="left-section">
        
        <img src="images/logo.png" alt="Website Logo" class="logo" />
        <img src="images/loginpic.jpg" alt="Login Graphic" class="sidepicture" />
      </div>

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
          <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap th-base"></span>
          <div class="container-fluid">
            <div class="row">
              <!-- Left Column (6 columns) -->
              <div class="col-md-10 mb-3">
                <label class="form-label">Name</label>
                <textarea class="form-control shadow" name="name" rows="1" required></textarea>
              </div>

               <!-- Full width column for Address -->
               <div class="col-md-10 mb-3">
                <label class="form-label">Address</label>
                <textarea class="form-control shadow" name="address" rows="1" required></textarea>
              </div>

              <div class="col-md-10 mb-3">
                <label class="form-label">Phone Number</label>
                <input type="number" class="form-control shadow-none" name="phone" num_rows="1" required>
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


    <!-- FOR IMAGE SLIDE  -->
<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" class="active" aria-current="true" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" class="active" aria-current="true" aria-label="Slide 3"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" class="active" aria-current="true" aria-label="Slide 4"></button>
</div>

  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="images/index 1.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
      </div>
    </div>
    <div class="carousel-item">
      <img src="images/index 2.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <p>Simple single </p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="images/index 3.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
  
        <p>Some representative placeholder content for the second slide.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="images/index 4.jpg class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <p>Some representative placeholder content for the second slide.</p>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>  
     <!-- HOME SECTION -->  
    <div id="content"></div>
        <section id="home" class="page active">  
        <h1>Welcome to Our Website <br> FOOD DELIVERY</h1>
        
        <a href="login.html"><button class="home-button">ORDER NOW</button></a>
        <p>Grab&Go</p>
    </section>

<!-- ABOUT US SECTION -->
 <section id="about" class="about-section-padding mt-5">
  <div class="container">
    <div class="row align-items-top">
      <div class="col-lg-3 col-md-12 col-12">
        <div class="about-img">
        <img src="images/pizza.jpg" alt="" class="img-fluid">
        </div>
      </div>
      <div class="col-lg-9 col-md-12 col-12 ps-lg-0 mt-md-5">
        <div class="about-text">
        <h1>About Us</h1>
        <p class="about-paragraph" >
        Welcome to Grab&Go, your go-to platform for fast, reliable, and delicious food delivery. We partner with your favorite local restaurants to bring a wide variety of cuisines right to your doorstep. Whether you're craving comfort food, healthy meals, or international flavors, we ensure quick service, user-friendly ordering, and real-time tracking. Our mission is to make dining convenient and enjoyable, connecting you with great food in just a few taps! Enjoy exceptional service and meals delivered with care.</p>
        </div>
      </div>
    </div>
  </div>
 </section>


 <!-- CONTACT SECTION -->
  <section id="contact" class="contact-section-padding mt-5">
  <h2 class=" mt-5 pt-4 mb-4 text-center">Contact Us</h2>
  <div class="container">
    <div class="row align-items-center">
      <!-- Contact Image on the Left -->
      <div class="col-lg-4 col-md-12 col-12">
      </div>
      <!-- Contact Form on the Right -->
      <div class="col-lg-8 col-md-12 col-12">
        <div class="contact-form p-4">
          <form action="#" class="m-auto">
            <div class="row">
              <div class="col-md-12">
                <div class="mb-3">
                  <input type="text" class="form-control" required placeholder="Your Full Name">
                </div>
              </div>
              <div class="col-md-12">
                <div class="mb-3">
                  <input type="email" class="form-control" required placeholder="Your Email Here">
                </div>
              </div>
              <div class="col-md-12">
                <div class="mb-3">
                  <textarea rows="3" required class="form-control" placeholder="Your Query Here"></textarea>
                </div>
              </div>
              <div class="col-md-12">
                <button class="btn btn-warning btn-lg btn-block mt-3">order Now</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>


<!-- REACH US -->
<h2 class=" mt-5 pt-4 mb-4 text-center">Lets connect with us</h2>
<div class="container">
</div>
<div class="container-fluid bg-white mt-5">
<div class="row">
<div class="col-lg-4 p-4">
<h3 class="h-font fw-bold fs-3 mb-2">Grab&Go</h3>
<p>
</p>
"People who love to eat are always the best people."</p>
</div>
<div class="col-lg-4 p-4">
<h5 class="mb-3">Links</h5>
<a href="" class="d-inline-block mb-2 text-dark text-decoration-none">Home</a> <br>
<a href="" class="d-inline-block mb-2 text-dark text-decoration-none">About Us</a> <br>
<a href="" class="d-inline-block mb-2 text-dark text-decoration-none">Contact Us</a> <br>
</div>


<div class="col-lg-4 p-4">
<h5 class="mb-3">Follow us</h5>
<a href="#" class="d-inline-block text-dark text-decoration-none mb-2"> <i class="bi bi-twitter me-1"></i> Twitter
</a><br>
<a href="#" class="d-inline-block text-dark text-decoration-none mb-2"> <i class="bi bi-facebook me-1"></i> Facebook
</a><br>
<a href="#" class="d-inline-block text-dark text-decoration-none mb-2"> <i class="bi bi-instagram ne-1"></i> instagram
</a><br>
</div>
</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
