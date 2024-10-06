<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="styles.css">
    
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="image-section">
                <img src="your-image-path-here.png" alt="Login Image">
            </div>
            <div class="login-section">
                <h2>LOG IN</h2>
                <p>Welcome!! Login or signup to access our website</p>
                <form id="loginForm">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>

                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>

                    <button type="submit">LOG IN</button>
                </form>
                <p class="register-text">Not registered? <a href="#">Create an account!</a></p>
            
            </div>
        </div>
    </div>
    <script src="scripts.js"></script>
</body>
</html>
