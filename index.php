<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grab&Go - Food Delivery</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Lora:wght@400;700&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* General Styles */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        .navbar {
            background-color: #1e293b;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-family: 'Lora', serif;
            font-size: 1.5rem;
            font-weight: bold;
            color: #fbbf24;
        }

        .nav-link {
            color: white !important;
            margin-right: 15px;
        }

        .nav-link:hover {
            color: #fbbf24 !important;
        }

        .carousel-item img {
            object-fit: cover;
            height: 70vh;
        }

        /* Hero Section */
        #home {
            background: linear-gradient(135deg, #1e293b, #fbbf24);
            color: white;
            padding: 100px 0;
            text-align: center;
        }

        #home h1 {
            font-family: 'Lora', serif;
            font-size: 3rem;
            font-weight: bold;
        }

        #home .btn {
            background-color: #fbbf24;
            border: none;
            font-weight: 600;
            padding: 15px 30px;
        }

        #home .btn:hover {
            background-color: #d19d1e;
        }

        /* About Section */
        #about {
            padding: 60px 0;
        }

        #about h1 {
            font-family: 'Lora', serif;
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        #about p {
            line-height: 1.8;
        }

        /* Contact Section */
        #contact {
            background-color: #1e293b;
            color: white;
            padding: 60px 0;
        }

        #contact h2 {
            font-family: 'Lora', serif;
            font-size: 2.5rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
        }

        #contact .form-control {
            border: none;
            border-radius: 5px;
            padding: 15px;
        }

        #contact .btn {
            background-color: #fbbf24;
            border: none;
            font-weight: bold;
            padding: 10px 20px;
        }

        #contact .btn:hover {
            background-color: #d19d1e;
        }

        /* Footer */
        footer {
            background-color: #1e293b;
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        footer a {
            color: #fbbf24;
            text-decoration: none;
            margin: 0 10px;
        }

        footer a:hover {
            color: white;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
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

    <!-- Hero Section -->
    <section id="home">
        <h1>Welcome to Grab&Go</h1>
        <p>Your favorite meals, delivered fast!</p>
        <a href="register.php" class="btn">Order Now</a>
    </section>

    <!-- About Section -->
    <section id="about" class="text-center">
        <div class="container">
            <h1>About Us</h1>
            <p>
                Grab&Go is your trusted partner for fast, reliable, and delicious food delivery. We work with the best local restaurants to ensure every meal meets your expectations. Enjoy diverse cuisines, fast service, and real-time tracking.
            </p>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact">
        <div class="container">
            <h2>Contact Us</h2>
            <form>
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Your Name">
                </div>
                <div class="mb-3">
                    <input type="email" class="form-control" placeholder="Your Email">
                </div>
                <div class="mb-3">
                    <textarea class="form-control" rows="4" placeholder="Your Message"></textarea>
                </div>
                <button type="submit" class="btn">Send Message</button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Grab&Go. All Rights Reserved.</p>
        <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
