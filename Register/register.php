<?php include 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GRAB&GO</title>
    <!-- ADD BOOTSTRAP CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- ADD POPPINS FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- ADD BOOTSTRAP ICONS CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
    <body>

 <!-- Register Modal -->
 <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="registerForm">
        <div class="modal-header">
          <h5 class="modal-title" id="registerModalLabel">Register Customer</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap th-base"></span>
          <div class="container-fluid">
            <div class="row">
              <!-- Left Column (6 columns) -->
              <div class="col-md-10 mb-3">
                <label class="form-label">Name</label>
                <textarea class="form-control shadow" name="name" rows="1" required></textarea>
              </div>

               <!-- Full width column for Address -->
               <div class="col-md-10 mb-3">
                <label class="form-label">Address</label>
                <textarea class="form-control shadow" name="address" rows="1" required></textarea>
              </div>

              <div class="col-md-10 mb-3">
                <label class="form-label">Phone Number</label>
                <input type="number" class="form-control shadow-none" name="phone" num_rows="1" required>
              </div>
              
              <div class="col-md-12 ps-6 mb-3">
                <label class="form-label">Address</label>
                <textarea class="form-control shadow" rows="1"></textarea>
              </div>
              <div class="col-md-12 ps-6 mb-3">
                <label class="form-label">Username</label>
                <textarea class="form-control shadow" rows="1"></textarea>
              </div>
             
      
              <div class="col-md-6 p-0 mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control shadow-none" name="password" required>
              </div>

              <div class="col-md-10 mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" class="form-control shadow-none" name="confirm_password" required>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Register</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>