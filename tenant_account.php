<?php
require_once('classes/database.php');
$con = new Database();
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['account_type'] != 1) {
    header('Location: login.php');
    exit();
}

// Fetch user's ID from session
$id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

// Fetch tenant profile data
$tenant_profile = null;
if ($id) {
    $tenant_profile = $con->viewTenantProfile($id);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenant Account</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- For Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="./includes/style.css">
</head>
<body>

<div class="container my-5">
    <h2 class="text-center">Tenant Profile</h2>
    <div class="card-container">
        <?php if ($tenant_profile): ?>
            <p>Tenant ID: <?php echo $tenant_profile['tenant_id']; ?></p>
            <p>Name: <?php echo $tenant_profile['Tenant FN'] . ' ' . $tenant_profile['Tenant LN']; ?></p>
            <p>Username: <?php echo $tenant_profile['username']; ?></p>
            <p>Email: <?php echo $tenant_profile['email']; ?></p>
            <p>Phone: <?php echo $tenant_profile['phone']; ?></p>
            <p>Lease ID: <?php echo $tenant_profile['lease_id']; ?></p>
        <?php else: ?>
            <p>No tenant profile found.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
