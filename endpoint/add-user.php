<?php
include('../conn/conn.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

// Registration Logic
if (isset($_POST['register'])) {
    try {
        // User input
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $address = $_POST['address'];
        $contactNumber = $_POST['contact_number'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password']; // Hash passwords in real projects!

        $conn->beginTransaction();

        // Check if user already exists
        $stmt = $conn->prepare("SELECT `first_name`, `last_name` FROM `tbl_otp` WHERE `first_name` = :first_name AND `last_name` = :last_name");
        $stmt->execute([
            'first_name' => $firstName,
            'last_name' => $lastName
        ]);
        $nameExist = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($nameExist)) {
            // Generate verification code
            $verificationCode = rand(100000, 999999);

            // Insert into database
            $insertStmt = $conn->prepare("
                INSERT INTO `tbl_otp` 
                (`tbl_user_id`, `first_name`, `last_name`, `address`, `contact_number`, `email`, `username`, `password`, `verification_code`) 
                VALUES 
                (NULL, :first_name, :last_name, :address, :contact_number, :email, :username, :password, :verification_code)
            ");

            $insertStmt->bindParam(':first_name', $firstName, PDO::PARAM_STR);
            $insertStmt->bindParam(':last_name', $lastName, PDO::PARAM_STR);
            $insertStmt->bindParam(':address', $address, PDO::PARAM_STR);
            $insertStmt->bindParam(':contact_number', $contactNumber, PDO::PARAM_STR);
            $insertStmt->bindParam(':email', $email, PDO::PARAM_STR);
            $insertStmt->bindParam(':username', $username, PDO::PARAM_STR);
            $insertStmt->bindParam(':password', $password, PDO::PARAM_STR); 
            $insertStmt->bindParam(':verification_code', $verificationCode, PDO::PARAM_INT);
            $insertStmt->execute();

            // Send Email with Verification Code
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'lorem.ipsum.sample.email@gmail.com';
            $mail->Password   = 'novtycchbrhfyddx';
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = 465;

            $mail->setFrom('lorem.ipsum.sample.email@gmail.com', 'UNICAFE');
            $mail->addAddress($email);   
            $mail->addReplyTo('lorem.ipsum.sample.email@gmail.com', 'UNICAFE');

            $mail->isHTML(true);
            $mail->Subject = 'Verification Code';
            $mail->Body    = 'Your verification code is: <b>' . $verificationCode . '</b>';

            $mail->send();

            // Start session and store user ID
            session_start();
            $userVerificationID = $conn->lastInsertId();
            $_SESSION['user_verification_id'] = $userVerificationID;

            $conn->commit();

            // Redirect to verification page
            header('Location: http://localhost/Grabandgo/final-project-grab-go/verification.php');
            exit;
        } else {
            // User already exists
            header('Location: http://localhost/Grabandgo/final-project-grab-go/register.php?error=user_exists');
            exit;
        }

    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: " . $e->getMessage();
    } catch (Exception $e) {
        echo "Mailer Error: " . $e->getMessage();
    }
}

// Verification Logic
if (isset($_POST['verify'])) {
    try {
        // Start session and get stored user ID
        session_start();
        $userVerificationID = $_SESSION['user_verification_id'];
        $verificationCode = $_POST['verification_code'];

        // Check verification code
        $stmt = $conn->prepare("SELECT `verification_code` FROM `tbl_otp` WHERE `tbl_user_id` = :tbl_user_id");
        $stmt->execute(['tbl_user_id' => $userVerificationID]);
        $codeExist = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($codeExist && $codeExist['verification_code'] == $verificationCode) {
            // Verification successful
            session_destroy();
            header('Location: http://localhost/Grabandgo/final-project-grab-go/register.php?success=verified');
            exit;
        } else {
            // Verification failed - delete the record
            $deleteStmt = $conn->prepare("DELETE FROM `tbl_otp` WHERE `tbl_user_id` = :tbl_user_id");
            $deleteStmt->execute(['tbl_user_id' => $userVerificationID]);

            header('Location: http://localhost/Grabandgo/final-project-grab-go/register.php?error=invalid_code');
            exit;
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
