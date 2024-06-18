<!-- To be added in the multisave.php -->

<?php

require_once('classes/database.php');

$con = new database();
if (isset($_POST['multisave'])) {
  $Tenantfirstname = $_POST['TenantFN'];
  $Tenantlastname = $_POST['TenantLN'];
    $sex = $_POST['sex'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

  //
    
  $Roomno = $_POST['Roomno'];
  $floor = $_POST['floor'];
  $numBedrooms = $_POST['numBedrooms'];
  $numBathrooms = $_POST['numBathrooms'];
    

    
    if ($password == $confirm) {
        // Passwords match, proceed with signup
        $tenant_id = $con->signup($Tenantfirstname,  $Tenantlastname, $username, $password,$sex); // Insert into users table and get user_id
        if ($tenant_id) {
            // Signup successful, insert address into users_address table
            if ($con->insertAddress($tenant_id, $Roomno, $floor,  $numBedrooms,   $numBathrooms)) {
                // Address insertion successful, redirect to login page
                header('location:login.php');
                exit();
            } else {
                // Address insertion failed, display error message
                $error = "Error occurred while signing up. Please try again.";
            }
        } else {
            // User insertion failed, display error message
            $error = "Error occurred while signing up. Please try again.";
        }
    } else {
        // Passwords don't match, display error message
        $error = "Passwords did not match. Please try again.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MultiSave Page</title>
  <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <style>
    .custom-container{
        width: 800px;
    }
    body{
    font-family: 'Roboto', sans-serif;
    }
  </style>

</head>
<body>

<div class="container custom-container rounded-3 shadow my-5 p-3 px-5">
  <h3 class="text-center mt-4"> Registration Form</h3>
  <form method="post" action="multisave.php">
    <!-- Personal Information -->
    <div class="form-step" id="step-2">
      <div class="card mt-4">
        <div class="card-header bg-info text-white">Personal Information</div>
        <div class="card-body">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="TenantFN">First Name:</label>
              <input type="text" class="form-control" name="TenantFN" placeholder="Enter first name" required>
              <div class="valid-feedback">Looks good!</div>
              <div class="invalid-feedback">Please enter a valid first name.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="TenantLN">Last Name:</label>
              <input type="text" class="form-control" name="TenantLN" placeholder="Enter last name" required>
              <div class="valid-feedback">Looks good!</div>
              <div class="invalid-feedback">Please enter a valid last name.</div>
            </div>
          </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="sex">Sex:</label>
            <select class="form-control" name="sex" >
              <option selected>Select Sex</option>
              <option>Male</option>
              <option>Female</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="username">Username:</label>
          <input type="text" class="form-control" name="username"  placeholder="Enter username">
        </div>
        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" class="form-control" name="password"  placeholder="Enter password">
        </div>
        <div class="form-group">
    <label for="confirm_password">Confirm Password:</label>
    <input type="password" class="form-control" name="confirm_password" placeholder="Confirm password">
</div>
      </div>
    </div>
    
    <!-- Address Information -->
    <div class="form-step" id="step-3">
  <div class="card mt-4">
    <div class="card-header bg-info text-white">Address Information</div>
    <div class="card-body">
      <div class="form-group">
        <label for="Roomno">Room Number:</label>
        <input type="text" class="form-control" name="Roomno" id="Roomno" placeholder="Enter room number" required>
        <div class="valid-feedback">Looks good!</div>
        <div class="invalid-feedback">Please enter the room number.</div>
      </div>
      <div class="form-group">
        <label for="floor">Floor:</label>
        <input type="text" class="form-control" name="floor" id="floor" placeholder="Enter floor" required>
        <div class="valid-feedback">Looks good!</div>
        <div class="invalid-feedback">Please enter the floor number.</div>
      </div>
      <div class="form-group">
        <label for="numBedrooms">Number of Bedrooms:</label>
        <input type="number" class="form-control" name="numBedrooms" id="numBedrooms" placeholder="Enter number of bedrooms" required>
        <div class="valid-feedback">Looks good!</div>
        <div class="invalid-feedback">Please enter the number of bedrooms.</div>
      </div>
      <div class="form-group">
        <label for="numBathrooms">Number of Bathrooms:</label>
        <input type="number" class="form-control" name="numBathrooms" id="numBathrooms" placeholder="Enter number of bathrooms" required>
        <div class="valid-feedback">Looks good!</div>
        <div class="invalid-feedback">Please enter the number of bathrooms.</div>
      </div>
    </div>
  </div>
    
    <!-- Submit Button -->
    
    <div class="container">
    <div class="row justify-content-center gx-0">
        <div class="col-lg-3 col-md-4"> 
            <input type="submit" name="multisave" class="btn btn-outline-primary btn-block mt-4" value="Sign Up">
        </div>
        <div class="col-lg-3 col-md-4"> 
            <a class="btn btn-outline-danger btn-block mt-4" href="login.php">Go Back</a>
        </div>
    </div>
</div>


  </>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="./bootstrap-5.3.3-dist/js/bootstrap.js"></script>
<!-- Bootsrap JS na nagpapagana ng danger alert natin -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
