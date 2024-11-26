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
    /* Existing styles */
    body {
        background-color: beige; 
    }
    
    #home {
        margin-top: 50px;
        padding-top: 20px;
        text-align: center;
        background-color: #f9f9f9;
    }
    .home-button {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        margin-top: 20px;
    }
    .home-button:hover {
        background-color: #0056b3;
    }

    .contact-img img {
        border-radius: 10px;
        width: 100%;
        height: auto;
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
        color: #333;
        width: 100%;
        margin-bottom: 15px;
    }

    .contact-form input::placeholder,
    .contact-form textarea::placeholder {
        color: #888;
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

    /* New styles for enhanced design */
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8f9fa;
    }

    .navbar {
        box-shadow: 0 2px 4px rgba(0,0,0,.1);
    }

    .navbar-brand {
        font-weight: 700;
        color: #F6BE00;
    }

    .nav-link {
        font-weight: 500;
        color: #333;
        transition: color 0.3s ease;
    }

    .nav-link:hover {
        color: #F6BE00;
    }

    #carouselExampleCaptions {
        margin-top: 76px;
    }

    .carousel-item img {
        object-fit: cover;
        height: 60vh;
    }

    #home {
        background-color: #ffffff;
        padding: 60px 0;
    }

    #home h1 {
        font-weight: 700;
        color: #333;
        margin-bottom: 30px;
    }

    .home-button {
        background-color: #F6BE00;
        border: none;
        padding: 12px 30px;
        font-weight: 600;
        transition: background-color 0.3s ease;
    }

    .home-button:hover {
        background-color: #e5b000;
    }

    #about {
        background-color: #f8f9fa;
        padding: 60px 0;
    }

    .about-text h1 {
        font-weight: 700;
        color: #333;
        margin-bottom: 30px;
    }

    .about-paragraph {
        line-height: 1.8;
        color: #555;
    }

    #contact {
        background-color: #ffffff;
        padding: 60px 0;
    }

    #contact h2 {
        font-weight: 700;
        color: #333;
        margin-bottom: 40px;
    }

    .contact-form {
        background-color: #F6BE00;
    }

    .contact-form input,
    .contact-form textarea {
        border: none;
        box-shadow: 0 1px 3px rgba(0,0,0,.1);
    }

    .contact-form button {
        background-color: #blue;
        font-weight: 600;
        transition: background-color 0.3s ease;
    }

    .contact-form button:hover {
        background-color: #555;
    }

    .container-fluid.bg-white {
        background-color: #333 !important;
        color: #fff;
    }

    .container-fluid.bg-white a {
        color: #F6BE00;
        transition: color 0.3s ease;
    }

    .container-fluid.bg-white a:hover {
        color: #fff;
        text-decoration: none;
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
        <a class="nav-link me-2" href="register.php">Login</a> 
        </li>
        </ul>
    </div>
  </div>
</nav>


    <!-- FOR IMAGE SLIDE  -->
<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
  <div class="carouseforl-indicators">
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" class="active" aria-current="true" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" class="active" aria-current="true" aria-label="Slide 3"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" class="active" aria-current="true" aria-label="Slide 4"></button>
</div>

  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="images/image1.jpg" class="d-block w-100" alt="...">
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
  
        <p>Some representative placeholder content for the second slide</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="images/index 4.jpg" class="d-block w-100" alt="...">
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
        <img src="images/logo.png" alt="" class="img-fluid">
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
<a href="" class="d-inline-block mb-2 text-white text-decoration-none">Home</a> <br>
<a href="" class="d-inline-block mb-2 text-white text-decoration-none">About Us</a> <br>
<a href="" class="d-inline-block mb-2 text-white text-decoration-none">Contact Us</a> <br>
</div>


<div class="col-lg-4 p-4">
<h5 class="mb-3">Follow us</h5>
<a href="#" class="d-inline-block text-white text-decoration-none mb-2"> <i class="bi bi-twitter me-1"></i> Twitter
</a><br>
<a href="#" class="d-inline-block text-white text-decoration-none mb-2"> <i class="bi bi-facebook me-1"></i> Facebook
</a><br>
<a href="#" class="d-inline-block text-white text-decoration-none mb-2"> <i class="bi bi-instagram ne-1"></i> instagram
</a><br>
</div>
</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
