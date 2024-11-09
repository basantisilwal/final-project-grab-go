<?php
include('../conn/conn.php');

$updateUserID = $_POST['user_id'];
$updateName = $_POST['name'];
$updateAddress = $_POST['address'];
$updatePhoneNumber = $_POST['phone_number'];
$updateEmail = $_POST['email'];
$updateUsername = $_POST['username'];
$updatePassword = $_POST['password'];

try {
    // Start a transaction
    $conn->beginTransaction();

    // Check if another user with the same first and last name exists, excluding the current user
    $stmt = $conn->prepare("SELECT `user_id` FROM `tbl_otp` WHERE `name` = :name AND `user_id` != :userID");
    $stmt->execute([
        'name' => $updateName,
        'userID' => $updateUserID
    ]);
    $nameExist = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$nameExist) {
        // Prepare the update statement
        $updateStmt = $conn->prepare("UPDATE `tbl_otp` SET `name` = :name, `address` = :address, `phone_number` = :phone_number, `email` = :email, `username` = :username, `password` = :password WHERE `user_id` = :userID");

        // Bind parameters
        $updateStmt->bindParam(':name', $updateName, PDO::PARAM_STR);
        $updateStmt->bindParam(':address', $updateAddress, PDO::PARAM_STR);
        $updateStmt->bindParam(':phone_number', $updatePhoneNumber, PDO::PARAM_STR); // Use PARAM_STR for contact_number
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
            window.location.href = 'http://localhost/Grabandgo/final-project-grab-go/customer.php';
        </script>
        ";
    } else {
        // Rollback transaction if a duplicate name is found
        $conn->rollBack();

        echo "
        <script>
            alert('User Already Exists');
            window.location.href = 'http://localhost/Grabandgo/final-project-grab-go/customer.php';
        </script>
        ";
    }
} catch (PDOException $e) {
    // Rollback the transaction if an error occurred
    $conn->rollBack();
    echo "
    <script>
        alert('An error occurred: " . $e->getMessage() . "');
        window.location.href = 'http://localhost/Grabandgo/final-project-grab-go/customer.php';
    </script>
    ";
}
?>
