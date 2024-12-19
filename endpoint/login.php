<?php
// Include the database connection
include('../conn/conn.php');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Start the session
    session_start();

    // Sanitize and retrieve input
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = $_POST['password']; // Password is checked exactly
    $user_type = filter_var($_POST['user_type'], FILTER_SANITIZE_STRING);

    // Define redirection URLs for different user roles
    $dashboards = [
        'customer' => 'http://localhost/Grabandgo/final-project-grab-go/Customer/customerdashboard.php',
        'admin' => 'http://localhost/Grabandgo/final-project-grab-go/Admin/admindashboard.php',
        'restaurant' => 'http://localhost/Grabandgo/final-project-grab-go/Restaurant/restaurantdashboard.php',
        'dispatcher' => 'http://localhost/Grabandgo/final-project-grab-go/Dispatcher/dispatcherdashboard.php'
    ];

    // Determine the table to query based on the role
    $table = '';
    if ($user_type === 'admin') {
        $table = 'tbl_admin';
    } elseif ($user_type === 'customer') {
        $table = 'tbl_otp';
    } elseif ($user_type === 'restaurant') {
        $table = 'tbl_restaurant';
    } elseif ($user_type === 'dispatcher') {
        $table = 'tbl_otp';
    } else {
        // Invalid user type
        header('Location: http://localhost/Grabandgo/final-project-grab-go/register.php?error=Invalid User Type');
        exit();
    }

    try {
        // Prepare and execute the query to fetch the password and username
        $query = "SELECT `password` FROM `$table` WHERE `username` = :username";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        // Check if the user exists
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Password comparison (hashing recommended for security)
            if (password_verify($password, $row['password']) || $password === $row['password']) {
                // Set session variables
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $user_type;

                // Redirect to the corresponding dashboard
                header('Location: ' . $dashboards[$user_type]);
                exit();
            } else {
                // Redirect for incorrect password
                header('Location: http://localhost/Grabandgo/final-project-grab-go/register.php?error=Incorrect Password');
                exit();
            }
        } else {
            // Redirect for user not found
            header('Location: http://localhost/Grabandgo/final-project-grab-go/register.php?error=User Not Found');
            exit();
        }
    } catch (PDOException $e) {
        // Handle database connection/query errors
        echo "Database Error: " . $e->getMessage();
        exit();
    }
} else {
    // Redirect if accessed without a POST request
    header('Location: http://localhost/Grabandgo/final-project-grab-go/register.php?error=Invalid Access');
    exit();
}
?>
