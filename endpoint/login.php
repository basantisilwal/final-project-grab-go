<?php
// Include DB connection
include('../conn/conn.php');

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();

    // Sanitize inputs
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
    $user_type = strtolower(filter_var($_POST['user_type'], FILTER_SANITIZE_STRING));

    // Dashboards based on roles
    $dashboards = [
        'user' => 'http://localhost/Grabandgo/final-project-grab-go/Customer/customerdashboard.php',
        'admin' => 'http://localhost/Grabandgo/final-project-grab-go/Admin/admindashboard.php',
        'owner' => 'http://localhost/Grabandgo/final-project-grab-go/Restaurant/das.php',
    ];

    if (!array_key_exists($user_type, $dashboards)) {
        header('Location: http://localhost/Grabandgo/final-project-grab-go/register.php?error=Invalid User Type');
        exit();
    }

    // Tables and columns map - updated to include contact_number for users
    $tables = [
        'admin' => [
            'table' => 'tbl_admin', 
            'id_column' => 'id',
            'select_columns' => ['id AS user_id', 'username', 'password', 'role']
        ],
        'user'  => [
            'table' => 'tbl_otp', 
            'id_column' => 'tbl_user_id',
            'select_columns' => ['tbl_user_id AS user_id', 'username', 'password', 'role', 'contact_number']
        ],
        'owner' => [
            'table' => 'tbl_restaurant', 
            'id_column' => 'id',
            'select_columns' => ['id AS user_id', 'username', 'password', 'role']
        ],
    ];

    $table = $tables[$user_type]['table'];
    $select_columns = implode(', ', $tables[$user_type]['select_columns']);

    try {
        // Query to fetch user
        $query = "SELECT $select_columns FROM `$table` 
                  WHERE `username` = :username AND `role` = :role";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':role', $user_type);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // NOTE: If passwords are plain text, use ===
            // If passwords are hashed, use password_verify()
            if ($password === $row['password']) { // <-- Change this if using plain text
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $user_type;
                $_SESSION['customer_id'] = $row['user_id'];
                
                // Store contact_number in session if this is a user login
                if ($user_type === 'user' && isset($row['contact_number'])) {
                    $_SESSION['contact_number'] = $row['contact_number'];
                }

                header('Location: ' . $dashboards[$user_type] . '?id=' . $row['user_id']);
                exit();
            } else {
                header('Location: http://localhost/Grabandgo/final-project-grab-go/register.php?error=Incorrect Password');
                exit();
            }
        } else {
            header('Location: http://localhost/Grabandgo/final-project-grab-go/register.php?error=User Not Found');
            exit();
        }
    } catch (PDOException $e) {
        error_log("Database Error: " . $e->getMessage());
        header('Location: http://localhost/Grabandgo/final-project-grab-go/register.php?error=Database Error');
        exit();
    }
} else {
    header('Location: http://localhost/Grabandgo/final-project-grab-go/register.php?error=Invalid Access');
    exit();
}
?>
