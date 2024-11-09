<?php
include('../conn/conn.php');
session_start(); // Start the session at the top

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

if (isset($_POST['register'])) {
    try {
        // Getting user input from POST request
        $name = $_POST['name'];
        $address = $_POST['address'];
        $phoneNumber = $_POST['phone'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        // Begin transaction
        $conn->beginTransaction();

        // Check if the username already exists in tbl_otp
        $stmt = $conn->prepare("SELECT `name`, `address` FROM `tbl_otp` WHERE `username` = :username");
        $stmt->execute(['username' => $username]);
        $nameExist = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($nameExist)) {
            $verificationCode = rand(100000, 999999); // Generate verification code

            // Insert the new user into tbl_otp
            $insertStmt = $conn->prepare("INSERT INTO `tbl_otp` 
                (`name`, `address`, `phone_number`, `email`, `username`, `password`, `verification_code`) 
                VALUES (:name, :address, :phone_number, :email, :username, :password, :verification_code)");

            $insertStmt->bindParam(':name', $name, PDO::PARAM_STR);
            $insertStmt->bindParam(':address', $address, PDO::PARAM_STR);
            $insertStmt->bindParam(':phone_number', $phoneNumber, PDO::PARAM_STR);
            $insertStmt->bindParam(':email', $email, PDO::PARAM_STR);
            $insertStmt->bindParam(':username', $username, PDO::PARAM_STR);
            $insertStmt->bindParam(':password', $password, PDO::PARAM_STR);
            $insertStmt->bindParam(':verification_code', $verificationCode, PDO::PARAM_INT);
            $insertStmt->execute();

            // Email Configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'grab.and.go.email@gmail.com';
            $mail->Password = 'novtycchbrhfyddx'; // Make sure this is correct or use environment variables for security
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            // Email Settings
            $mail->setFrom('grab.and.go.email@gmail.com', 'Grab & Go');
            $mail->addAddress($email);
            $mail->addReplyTo('grab.and.go.email@gmail.com', 'Grab & Go');
            
            $mail->isHTML(true);
            $mail->Subject = 'Verification Code';
            $mail->Body = 'Your verification code is: <b>' . $verificationCode . '</b>';

            // Send Email
            $mail->send();

            // Store user verification ID in session
            $userVerificationID = $conn->lastInsertId();
            $_SESSION['user_verification_id'] = $userVerificationID;

            // Commit transaction
            $conn->commit();

            echo "
            <script>
                alert('Check your email for the verification code.');
                window.location.href = 'http://localhost/Grabandgo/final-project-grab-go/verification.php';
            </script>
            ";
        } else {
            echo "
            <script>
                alert('User already exists.');
                window.location.href = 'http://localhost/Grabandgo/final-project-grab-go/index.php';
            </script>
            ";
        }
    } catch (PDOException $e) {
        $conn->rollBack();
        echo 'Error: ' . $e->getMessage();
    }
}

if (isset($_POST['verify'])) {
    try {
        $userVerificationID = $_SESSION['user_verification_id']; 
        $verificationCode = $_POST['verification_code'];

        $stmt = $conn->prepare("SELECT `verification_code` FROM `tbl_otp` WHERE `tbl_otp_id` = :user_verification_id");
        $stmt->execute(['user_verification_id' => $userVerificationID]);
        $codeExist = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($codeExist && $codeExist['verification_code'] == $verificationCode) {
            session_destroy(); 
            echo "
            <script>
                alert('Registered Successfully.');
                window.location.href = 'http://localhost/Grabandgo/final-project-grab-go/index.php';
            </script>
            ";
        } else {
            // Delete user record if verification fails
            $deleteStmt = $conn->prepare("DELETE FROM `tbl_otp` WHERE `tbl_otp_id` = :user_verification_id");
            $deleteStmt->execute(['user_verification_id' => $userVerificationID]);

            echo "
            <script>
                alert('Incorrect Verification Code. Register Again.');
                window.location.href = 'http://localhost/Grabandgo/final-project-grab-go/index.php';
            </script>
            ";
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>
