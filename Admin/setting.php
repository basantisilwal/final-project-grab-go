


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="astyle.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</head>


        <!-- Logo -->
<div class="main-content">
    <section class= "logo">
<form action="upload_logo.php" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
    <img id="logoPreview" src="https://via.placeholder.com/120x50.png?text=Logo" alt="Logo">
          </div>

          <div class="mb-3">
            <label for="logoUpload" class="form-label"><strong>Change Logo:</strong></label>
            <input type="file" class="form-control" id="logoUpload" accept="image/*">
          </div>
</section>
</form>

           

          
    <script src="script.js"></script>
</body>
</html>