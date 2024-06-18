            <?php
        require_once('classes/database.php');
        $con = new Database();
        session_start();

        // Check if the user is not logged in or not an admin
        if (!isset($_SESSION['username']) || $_SESSION['account_type'] != 1) {
            // Redirect to tenant_account.php if the current script is not tenant_account.php
            if (basename($_SERVER['PHP_SELF']) != 'tenant_account.php') {
                header('Location: tenant_account.php');
                exit();
            }
        }

        // User's ID from session
        $id = $_SESSION['tenant_id'];

        // Fetch user data
        $data = $con->viewdata($id);
        
        // Handle form submission for updating address
        if (isset($_POST['updateapartment'])) {
            $user_id = $id;
            $building = $_POST['building_text'];
            $floor = $_POST['floor_text'];
            $bedrooms = $_POST['bedrooms_text'];
            $bathrooms = $_POST['bathrooms_text'];

            // Assuming updateUserAddress function handles the database update
            if ($con->updateUserAddress($user_id, $building, $floor, $bedrooms, $bathrooms)) {
                // Address updated successfully
                header('Location: tenant_account.php?status=success1');
                exit();
            } else {
                // Failed to update address
                header('Location: tenant_account.php?status=error');
                exit();
            }
        }
        ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Back admin!</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- For Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="./includes/style.css">
    <!-- Sweetalert2 CSS -->
    <link rel="stylesheet" href="package/dist/sweetalert2.css">
</head>
<body>

<?php include('sidebar.php'); ?>

<div class="container my-5">
    <h2 class="text-center">Tenant Account</h2>
    <div class="card-container">

        <!-- Update Account Information Modal -->
        <div class="modal fade" id="updateAccountInfoModal" tabindex="-1" role="dialog" aria-labelledby="updateAccountInfoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form id="updateAccountForm" method="post" novalidate>
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateAccountInfoModalLabel">Update Account Information</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Current Address: <address><?php echo isset($data['Roomno']) ? $data['Roomno'] . ', ' . $data['floor'] . ', ' . $data['numBedrooms'] . ', ' . $data['numBathrooms'] : ''; ?></address></p>
                            <div class="form-group">
                                <label class="form-label">Building<span class="text-danger"> *</span></label>
                                <input type="text" class="form-control form-control-md" name="building_text" id="building-text" required>
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please enter your building.</div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Floor<span class="text-danger"> *</span></label>
                                <input type="text" class="form-control form-control-md" name="floor_text" id="floor-text" required>
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please enter your floor.</div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Bedrooms<span class="text-danger"> *</span></label>
                                <input type="text" class="form-control form-control-md" name="bedrooms_text" id="bedrooms-text" required>
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please enter number of bedrooms.</div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Bathrooms<span class="text-danger"> *</span></label>
                                <input type="text" class="form-control form-control-md" name="bathrooms_text" id="bathrooms-text" required>
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please enter number of bathrooms.</div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="updateaddress" class="btn btn-primary">Update Address</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<!-- Sweetalert2 JS -->
<script src="package/dist/sweetalert2.all.min.js"></script>
</body>
</html>
