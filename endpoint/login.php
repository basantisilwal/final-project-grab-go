<?php
include ('../conn/conn.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user_type = $_POST['user_type']; // Getting user type from the form

    try {
        $stmt = null;

        // Determine the correct table to query based on user type
        if ($user_type === 'Admin') {
            $stmt = $conn->prepare("SELECT `password` FROM `tbl_admin` WHERE `username` = :username");
        } elseif ($user_type === 'Restaurant') {
            $stmt = $conn->prepare("SELECT `password` FROM `tbl_restaurant` WHERE `username` = :username");
        } else {
            // For Customer and Dispatcher, use the `tbl_otp` table
            $stmt = $conn->prepare("SELECT `password`, `user_type` FROM `tbl_otp` WHERE `username` = :username");
        }

        // Bind the username parameter and execute the query
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        // Check if user exists
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch();
            $stored_password = $row['password'];

            // If the user type is Customer or Dispatcher, fetch `user_type` from `tbl_otp`
            if ($user_type === 'Customer' || $user_type === 'Dispatcher') {
                $user_type = $row['user_type'];
            }

            // Verify the password
            if ($password === $stored_password) {
                // Start session and store user info
                $_SESSION['username'] = $username;
                $_SESSION['user_type'] = $user_type;

                // Redirect based on user type
                switch ($user_type) {
                    case 'Admin':
                        header("Location: http://localhost/Grabandgo/final-project-grab-go/Admin/admindashboard.php");
                        break;
                    case 'Restaurant':
                        header("Location: http://localhost/Grabandgo/final-project-grab-go/Restaurant/restaurantdashboard.php");
                        break;
                    case 'Customer':
                        header("Location: http://localhost/Grabandgo/final-project-grab-go/Customer/customerdashboard.php");
                        break;
                    case 'Dispatcher':
                        header("Location: http://localhost/Grabandgo/final-project-grab-go/Dispatcher/dispatcherdashboard.php");
                        break;
                    default:
                        echo "<script>
                                alert('Invalid User Type!');
                                window.location.href = 'http://localhost/Grabandgo/final-project-grab-go/login.php';
                              </script>";
                        break;
                }
                exit();
            } else {
                echo "<script>
                        alert('Login Failed, Incorrect Password!');
                        window.location.href = 'http://localhost/Grabandgo/final-project-grab-go/login.php';
                      </script>";
            }
        } else {
            echo "<script>
                    alert('Login Failed, User Not Found!');
                    window.location.href = 'http://localhost/Grabandgo/final-project-grab-go/login.php';
                  </script>";
        }
    } catch (Exception $e) {
        echo "<script>
                alert('An error occurred: " . $e->getMessage() . "');
                window.location.href = 'http://localhost/Grabandgo/final-project-grab-go/login.php';
              </script>";
    }
}
?>
