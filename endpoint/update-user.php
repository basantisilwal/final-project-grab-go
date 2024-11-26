<?php
include('../conn/conn.php');

$updateUserID = $_POST['tbl_user_id'];
$updateFirstName = $_POST['first_name'];
$updateLastName = $_POST['last_name'];
$updateAddress = $_POST['address'];
$updateContactNumber = $_POST['contact_number'];
$updateEmail = $_POST['email'];
$updateUsername = $_POST['username'];
$updatePassword = $_POST['password']; // Assuming it comes in plain text and needs to be hashed

try {
    // Check for duplicate names, excluding the current user
    $stmt = $conn->prepare("SELECT `tbl_user_id` FROM `tbl_otp` WHERE `first_name` = :first_name AND `last_name` = :last_name AND `tbl_user_id` != :userID");
    $stmt->execute([
        'first_name' => $updateFirstName,
        'last_name' => $updateLastName,
        'userID' => $updateUserID
    ]);
    $nameExist = $stmt->fetch(PDO::FETCH_ASSOC);

    if (empty($nameExist)) {
        $conn->beginTransaction();

        // Hash the password before updating
        $hashedPassword = password_hash($updatePassword, PASSWORD_BCRYPT);

        $updateStmt = $conn->prepare("
            UPDATE `tbl_otp` 
            SET `first_name` = :first_name, 
                `last_name` = :last_name,
                `address` = :address, 
                `contact_number` = :contact_number, 
                `email` = :email, 
                `username` = :username, 
                `password` = :password 
            WHERE `tbl_user_id` = :userID
        ");
        $updateStmt->bindParam(':first_name', $updateFirstName, PDO::PARAM_STR);
        $updateStmt->bindParam(':last_name', $updateLastName, PDO::PARAM_STR);
        $updateStmt->bindParam(':address', $updateAddress, PDO::PARAM_STR);
        $updateStmt->bindParam(':contact_number', $updateContactNumber, PDO::PARAM_STR); // Fixed to PARAM_STR
        $updateStmt->bindParam(':email', $updateEmail, PDO::PARAM_STR);
        $updateStmt->bindParam(':username', $updateUsername, PDO::PARAM_STR);
        $updateStmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR); // Use hashed password
        $updateStmt->bindParam(':userID', $updateUserID, PDO::PARAM_INT);
        $updateStmt->execute();

        $conn->commit();

        // Redirect to customer management page
        header('Location: http://localhost/Grabandgo/final-project-grab-go/Admin/customer.php');
        exit; // Stop further script execution
    } else {
        // Redirect to register page if duplicate names are found
        header('Location: http://localhost/Grabandgo/final-project-grab-go/register.php');
        exit; // Ensure no further code is executed
    }
} catch (PDOException $e) {
    // Roll back transaction if an error occurs
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }
    echo "Error: " . $e->getMessage();
}
?>
