<?php
include('../conn/conn.php');

$updateUserID = $_POST['tbl_user_id'];
$updateFirstName = $_POST['first_name'];
$updateLastName = $_POST['last_name'];
$updateContactNumber = $_POST['contact_number'];
$updateEmail = $_POST['email'];
$updateUsername = $_POST['username'];
$updatePassword = $_POST['password'];

try {
    // Start a transaction
    $conn->beginTransaction();

    // Check if another user with the same first and last name exists, excluding the current user
    $stmt = $conn->prepare("SELECT `tbl_user_id` FROM `tbl_user` WHERE `first_name` = :first_name AND `last_name` = :last_name AND `tbl_user_id` != :userID");
    $stmt->execute([
        'first_name' => $updateFirstName,
        'last_name' => $updateLastName,
        'userID' => $updateUserID
    ]);
    $nameExist = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$nameExist) {
        // Prepare the update statement
        $updateStmt = $conn->prepare("UPDATE `tbl_user` SET `first_name` = :first_name, `last_name` = :last_name, `contact_number` = :contact_number, `email` = :email, `username` = :username, `password` = :password WHERE `tbl_user_id` = :userID");

        // Bind parameters
        $updateStmt->bindParam(':first_name', $updateFirstName, PDO::PARAM_STR);
        $updateStmt->bindParam(':last_name', $updateLastName, PDO::PARAM_STR);
        $updateStmt->bindParam(':contact_number', $updateContactNumber, PDO::PARAM_STR); // Use PARAM_STR for contact_number
        $updateStmt->bindParam(':email', $updateEmail, PDO::PARAM_STR);
        $updateStmt->bindParam(':username', $updateUsername, PDO::PARAM_STR);
        $updateStmt->bindParam(':password', $updatePassword, PDO::PARAM_STR);
        $updateStmt->bindParam(':userID', $updateUserID, PDO::PARAM_INT);

        // Execute the update statement
        $updateStmt->execute();

        // Commit the transaction
        $conn->commit();

        echo "
        <script>
            alert('Updated Successfully');
            window.location.href = 'http://localhost/login-system-with-email-verification/home.php';
        </script>
        ";
    } else {
        // Rollback transaction if a duplicate name is found
        $conn->rollBack();

        echo "
        <script>
            alert('User Already Exists');
            window.location.href = 'http://llogin-system-with-email-verification/home.php';
        </script>
        ";
    }
} catch (PDOException $e) {
    // Rollback the transaction if an error occurred
    $conn->rollBack();
    echo "
    <script>
        alert('An error occurred: " . $e->getMessage() . "');
        window.location.href = 'http://localhost/login-system-with-email-verification/home.php';
    </script>
    ";
}
?>
