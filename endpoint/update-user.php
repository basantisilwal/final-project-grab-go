<?php
include ('../conn/conn.php');

$updateUserID = $_POST['tbl_user_id'];
$updateFirstName = $_POST['first_name'];
$updateLastName = $_POST['last_name'];
$updateAddress = $_POST['address'];
$updateContactNumber = $_POST['contact_number'];
$updateEmail = $_POST['email'];
$updateUsername = $_POST['username'];
$updatePassword = $_POST['password'];

try {
    $stmt = $conn->prepare("SELECT `first_name`, `last_name` FROM `tbl_otp` WHERE `first_name` = :first_name AND `last_name` = :last_name");
    $stmt->execute([
        'first_name' => $updateFirstName,
        'last_name'=> $updateLastName
    ]);
    $nameExist = $stmt->fetch(PDO::FETCH_ASSOC);

    if (empty($nameExist)) {
        $conn->beginTransaction();

        $updateStmt = $conn->prepare("UPDATE `tbl_otp` SET `first_name` = :first_name, `last_name` = :last_name,`address` = :address, `contact_number` = :contact_number, `email` = :email, `username` = :username, `password` = :password WHERE `tbl_user_id` = :userID");
        $updateStmt->bindParam(':first_name', $updateFirstName, PDO::PARAM_STR);
        $updateStmt->bindParam(':last_name', $updateLastName, PDO::PARAM_STR);
        $updateStmt->bindParam(':address', $updateAddress, PDO::PARAM_STR);
        $updateStmt->bindParam(':contact_number', $updateContactNumber, PDO::PARAM_INT);
        $updateStmt->bindParam(':email', $updateEmail, PDO::PARAM_STR);
        $updateStmt->bindParam(':username', $updateUsername, PDO::PARAM_STR);
        $updateStmt->bindParam(':password', $updatePassword, PDO::PARAM_STR);
        $updateStmt->bindParam(':userID', $updateUserID, PDO::PARAM_INT);
        $updateStmt->execute();

        header('Location: http://localhost/Grabandgo/final-project-grab-go/Admin/customer.php');
        exit; // Always use exit after header to stop further script execution

        $conn->commit();
    } else {
        // Redirect to register page if names exist
        header('Location: http://localhost/Grabandgo/final-project-grab-go/register.php');
        exit; // Exit to ensure no further code is executed
    }
} catch (PDOException $e) {
    // Handle errors if any
    echo "Error: " . $e->getMessage();
}
?>

