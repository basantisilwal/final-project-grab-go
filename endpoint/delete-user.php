<?php
include('../conn/conn.php');

if (isset($_GET['user'])) {
    $user = $_GET['user'];

    try {
        // Prepare the DELETE query using a parameterized statement to prevent SQL injection
        $query = "DELETE FROM `tbl_otp` WHERE `tbl_otp_id` = :user_id";
        $stmt = $conn->prepare($query);

        // Bind the parameter and execute the query
        $stmt->bindParam(':user_id', $user, PDO::PARAM_INT);
        $query_execute = $stmt->execute();

        if ($query_execute) {
            echo "
            <script>
                alert('User Deleted Successfully');
                window.location.href = 'http://localhost/login-system-with-email-verification/home.php';
            </script>
            ";
        } else {
            echo "
            <script>
                alert('Failed to Delete User');
                window.location.href = 'http://localhost/login-system-with-email-verification/home.php';
            </script>
            ";
        }

    } catch (PDOException $e) {
        // Output error message
        echo "
        <script>
            alert('Error: " . $e->getMessage() . "');
            window.location.href = 'http://localhost/login-system-with-email-verification/home.php';
        </script>
        ";
    }
} else {
    // If 'user' parameter is not set, redirect with an error message
    echo "
    <script>
        alert('Invalid Request: User ID not provided.');
        window.location.href = 'http://localhost/login-system-with-email-verification/home.php';
    </script>
    ";
}
?>
