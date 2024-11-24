<?php
include('../conn/conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize user input
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = $_POST['password'];

    // Start session
    session_start();

    // Function to handle redirects
    function redirectTo($location) {
        header("Location: $location");
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
            // Regenerate session ID to prevent session fixation attacks
            session_regenerate_id(true);

            $_SESSION['username'] = $username;
            $_SESSION['role'] = $user_role;

            // Redirect based on the role
            $dashboards = [
                'customer' => '/final-project-grab-go/Customer/customerdashboard.php',
                'dispatcher' => '/final-project-grab-go/Dispatcher/dispatcherdashboard.php'
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
            // Regenerate session ID for security
            session_regenerate_id(true);

            $_SESSION['username'] = $username;
            $_SESSION['role'] = 'admin';  // Manually set the role for admin
            redirectTo('/final-project-grab-go/Admin/admindashboard.php');
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
            // Regenerate session ID for security
            session_regenerate_id(true);

            $_SESSION['username'] = $username;
            $_SESSION['role'] = 'restaurant';  // Add role if needed
            redirectTo('/final-project-grab-go/Restaurant/restaurantdashboard.php');
        }
    }

    // User not found or incorrect password
    redirectTo('/final-project-grab-go/login.php?error=Invalid username or password');
}
?>
