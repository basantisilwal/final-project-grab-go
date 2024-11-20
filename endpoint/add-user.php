<?php
include('../conn/conn.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

if (isset($_POST['register'])) {
    try {
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $address = $_POST['address'];
        $contactNumber = $_POST['contact_number'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        $conn->beginTransaction();

        $stmt = $conn->prepare("SELECT `first_name`, `last_name` FROM `tbl_otp` WHERE `first_name` = :first_name AND `last_name` = :last_name");
        $stmt->execute([
            'first_name' => $firstName,
            'last_name' => $lastName
        ]);
        $nameExist = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($nameExist)) {
            $verificationCode = rand(100000, 999999);

            $insertStmt = $conn->prepare("INSERT INTO `tbl_otp` (`tbl_user_id`, `first_name`, `last_name`, `address`, `contact_number`, `email`, `username`, `password`, `verification_code`) VALUES (NULL, :first_name, :last_name, :address, :contact_number, :email, :username, :password, :verification_code)");
            $insertStmt->bindParam(':first_name', $firstName, PDO::PARAM_STR);
            $insertStmt->bindParam(':last_name', $lastName, PDO::PARAM_STR);
            $insertStmt->bindParam(':address', $address, PDO::PARAM_STR);
            $insertStmt->bindParam(':contact_number', $contactNumber, PDO::PARAM_INT);
            $insertStmt->bindParam(':email', $email, PDO::PARAM_STR);
            $insertStmt->bindParam(':username', $username, PDO::PARAM_STR);
            $insertStmt->bindParam(':password', $password, PDO::PARAM_STR);
            $insertStmt->bindParam(':verification_code', $verificationCode, PDO::PARAM_INT);
            $insertStmt->execute();

            // Server settings for email
            $mail->isSMTP(); 
            $mail->Host       = 'smtp.gmail.com'; 
            $mail->SMTPAuth   = true; 
            $mail->Username   = 'lorem.ipsum.sample.email@gmail.com';
            $mail->Password   = 'novtycchbrhfyddx';
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = 465; 

            // Recipients
            $mail->setFrom('lorem.ipsum.sample.email@gmail.com', 'Grab &Go');
            $mail->addAddress($email);   
            $mail->addReplyTo('lorem.ipsum.sample.email@gmail.com', 'Grab &Go'); 

            // Content
            $mail->isHTML(true);  
            $mail->Subject = 'Verification Code';
            $mail->Body    = 'Your verification code is: ' . $verificationCode; 

            // Send email
            $mail->send();

            session_start();

            $userVerificationID = $conn->lastInsertId();
            $_SESSION['user_verification_id'] = $userVerificationID;

            // Redirect to verification page
            header('Location: http://localhost/Grabandgo/final-project-grab-go/verification.php');
            exit;

            $conn->commit();
        } else {
            // Redirect to registration page if user already exists
            header('Location: http://localhost/Grabandgo/final-project-grab-go/register.php');
            exit;
        }
    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: " . $e->getMessage();
    }
}

if (isset($_POST['verify'])) {
    try {
        $userVerificationID = $_POST['user_verification_id'];
        $verificationCode = $_POST['verification_code'];

        $stmt = $conn->prepare("SELECT `verification_code` FROM `tbl_otp` WHERE `tbl_user_id` = :user_verification_id");
        $stmt->execute([
            'user_verification_id' => $userVerificationID,
        ]);
        $codeExist = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($codeExist && $codeExist['verification_code'] == $verificationCode) {
            session_destroy();

            // Redirect to registration page after successful registration
            header('Location: http://localhost/Grabandgo/final-project-grab-go/register.php');
            exit;
        } else {
            // Delete the record if verification fails
            $conn->prepare("DELETE FROM `tbl_otp` WHERE `tbl_user_id` = :user_verification_id")->execute([
                'user_verification_id' => $userVerificationID
            ]);

            // Redirect to registration page on failure
            header('Location: http://localhost/Grabandgo/final-project-grab-go/register.php');
            exit;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
