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
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grab&Go - Food Delivery</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Lora:wght@400;700&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* General Styles */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f7e4a3;
            color: #5a3e2b;
        }

        .navbar {
            background-color: #603813;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-family: 'Lora', serif;
            font-size: 1.8rem;
            font-weight: bold;
            color: #f7e4a3;
        }

        .nav-link {
            color: #f7e4a3 !important;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: #c69c6d !important;
        }

        #home {
            background: linear-gradient(135deg, #f7e4a3, #e8dbc5);
            color: #5a3e2b;
            padding: 120px 0;
            text-align: center;
        }

        #home h1 {
            font-family: 'Lora', serif;
            font-size: 3.5rem;
            font-weight: bold;
        }

        #home .btn {
            background-color: #603813;
            border: none;
            font-weight: 700;
            padding: 15px 35px;
            font-size: 1.2rem;
            color: white;
            border-radius: 30px;
            transition: background 0.3s;
        }

        #home .btn:hover {
            background-color: #3b3a36;
        }

        #about, #contact {
            padding: 80px 0;
            background-color: #fffaf0;
            text-align: center;
        }

        #about h1, #contact h2 {
            font-family: 'Lora', serif;
            font-size: 2.8rem;
            font-weight: bold;
            margin-bottom: 25px;
            color: #5a3e2b;
        }

        #contact {
            background-color: #c69c6d;
            color: white;
        }

        #contact .form-control {
            border: 2px solid #603813;
            border-radius: 10px;
            padding: 15px;
        }

        #contact .btn {
            background-color: #603813;
            border: none;
            font-weight: bold;
            padding: 12px 25px;
            font-size: 1.1rem;
            border-radius: 25px;
            color: white;
        }

        #contact .btn:hover {
            background-color: #3b3a36;
        }

        footer {
            background-color: #603813;
            color: white;
            padding: 25px 0;
            text-align: center;
            font-size: 1.1rem;
        }

        footer a {
            color: #f7e4a3;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
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
