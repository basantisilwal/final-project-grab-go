<?php
include('../conn/conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
    $user_type = $_POST['user_type'];

    // Start session
    session_start();

    // Define redirection URLs
    $dashboards = [
        'customer' => 'http://localhost/Grabandgo/final-project-grab-go/Customer/customerdashboard.php',
        'admin' => 'http://localhost/Grabandgo/final-project-grab-go/Admin/admindashboard.php',
        'restaurant' => 'http://localhost/Grabandgo/final-project-grab-go/Restaurant/restaurantdashboard.php',
        'dispatcher' => 'http://localhost/Grabandgo/final-project-grab-go/Dispatcher/dispatcherdashboard.php'
    ];

    // Query appropriate table based on user type
    $table = '';
    if ($user_type === 'admin') $table = 'tbl_admin';
    elseif ($user_type === 'customer') $table = 'tbl_otp';
    elseif ($user_type === 'dispatcher') $table = 'tbl_otp';
    elseif ($user_type === 'restaurant') $table = 'tbl_restaurant';

    $query = "SELECT `password` FROM `$table` WHERE `username` = :username";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch();
        if ($password === $row['password']) { // Match passwords
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $user_type;
            header('Location: ' . $dashboards[$user_type]);
        } else {
            header('Location: /index.php?error=Incorrect Password');
        }
    } else {
        header('Location: /index.php?error=User Not Found');
    }
}
?>
