<?php
session_start();
include('config.php');

// Handle logo upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['logo'])) {
    $targetDir = "images/";
    $targetFile = $targetDir . basename($_FILES["logo"]["name"]);
    $uploadOk = 1;

    // Check if image file is a actual image
    $check = getimagesize($_FILES["logo"]["tmp_name"]);
    if ($check === false) {
        echo "<div class='alert alert-danger'>File is not an image.</div>";
        $uploadOk = 0;
    }

    // Check file size (limit to 2MB)
    if ($_FILES["logo"]["size"] > 2000000) {
        echo "<div class='alert alert-danger'>Sorry, your file is too large.</div>";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
        echo "<div class='alert alert-danger'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</div>";
        $uploadOk = 0;
    }

    // If everything is ok, try to upload the file
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["logo"]["tmp_name"], $targetFile)) {
            // Update the logo path in the database
            $query = "UPDATE settings SET logo_path = '$targetFile' WHERE id = 1";
            if ($conn->query($query) === TRUE) {
                echo "<div class='alert alert-success'>The logo has been updated successfully.</div>";
                header("Refresh:0"); // Refresh the page to show new logo
                exit();
            } else {
                echo "<div class='alert alert-danger'>Error updating logo: " . $conn->error . "</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Sorry, there was an error uploading your file.</div>";
        }
    }
}

// Fetch current logo path from the database
$query = "SELECT logo_path FROM settings WHERE id = 1";
$result = $conn->query($query);
$row = $result->fetch_assoc();
$logoPath = $row['logo_path'] ?? 'images/default-logo.png'; // Fallback logo
?