<?php
include ('../conn/conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Start session
    session_start();

    // Function to handle redirects
    function redirectTo($location) {
        header("Location: http://localhost/Grabandgo/final-project-grab-go$location");
        exit;
    }

    // First check in tbl_otp for Customer and Dispatcher
    $stmt = $conn->prepare("SELECT `password`, `role` FROM `tbl_otp` WHERE `username` = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch();
        $stored_password = $row['password'];
        $user_role = $row['role']; // Fetch the role (customer or dispatcher)

        if (password_verify($password, $stored_password)) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $user_role;

            // Redirect based on the role
            $dashboards = [
                'customer' => '/Customer/customerdashboard.php',
                'dispatcher' => '/Dispatcher/dispatcherdashboard.php'
            ];

            if (array_key_exists($user_role, $dashboards)) {
                redirectTo($dashboards[$user_role]);
            }
        }
    }

    // Check tbl_admin for Admin
    $stmtAdmin = $conn->prepare("SELECT `password` FROM `tbl_admin` WHERE `username` = :username");
    $stmtAdmin->bindParam(':username', $username);
    $stmtAdmin->execute();

    if ($stmtAdmin->rowCount() > 0) {
        $rowAdmin = $stmtAdmin->fetch();
        $stored_password_admin = $rowAdmin['password'];

        if (password_verify($password, $stored_password_admin)) {
            $_SESSION['username'] = $username;
            redirectTo('/Admin/admindashboard.php');
        }
    }

    // Check tbl_restaurant for Restaurant
    $stmtRestaurant = $conn->prepare("SELECT `password` FROM `tbl_restaurant` WHERE `username` = :username");
    $stmtRestaurant->bindParam(':username', $username);
    $stmtRestaurant->execute();

    if ($stmtRestaurant->rowCount() > 0) {
        $rowRestaurant = $stmtRestaurant->fetch();
        $stored_password_restaurant = $rowRestaurant['password'];

        if (password_verify($password, $stored_password_restaurant)) {
            $_SESSION['username'] = $username;
            redirectTo('/Restaurant/restaurantdashboard.php');
        }
    }

    // User not found or incorrect password
    redirectTo('/login.php?error=Invalid username or password');
}
?>
