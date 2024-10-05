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