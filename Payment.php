<?php
session_start(); // Start or resume the session

// Check if $_SESSION['username'] is not set or null
if (empty($_SESSION['username'])) {
    header('location:login.php');
    exit; // Always exit after a header redirect
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Back admin!</title>
    <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- For Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="./includes/style.css">
    <link rel="stylesheet" href="package/dist/sweetalert2.css">
</head>
<body>

<?php include('sidebar.php'); ?>

<div class="container my-5">
        <h2 class="text-center">Payments</h2>
        <div class="card-container">

<?php
require_once('classes/database.php');
$con = new database();

if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    if ($con->delete($id)) {
        header('location:index.php?status=success');
        exit;
    } else {
        echo "Something went wrong.";
    }
}

// Define database connection settings
$host = 'localhost'; // Replace with your host name or IP address
$dbname = 'wilesdb'; // Replace with your database name
$user = 'root'; // Replace with your database username
$password = ''; // Replace with your database password

// Create a new PDO instance with error handling
try {
    $pdo = new PDO("mysql:host=$host;wilesdb=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit; // Exit the script if connection fails
}

/// Function to add a new payment
function addPayment($leaseId, $paymentDate, $amount, $pdo)
{
    // Check if lease ID exists in leases table
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM leases WHERE lease_id = ?");
    $stmt->execute([$leaseId]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        try {
            // Prepare the SQL statement
            $stmt = $pdo->prepare("INSERT INTO payments (lease_id, payment_date, amount) VALUES (?, ?, ?)");

            // Execute the SQL statement
            $stmt->execute([$leaseId, $paymentDate, $amount]);

            echo "Payment added successfully!";
        } catch (PDOException $e) {
            // Handle PDO exceptions (e.g., foreign key constraint violation)
            if ($e->getCode() == '23000') {
                echo "Error adding payment: Foreign key constraint violation. Lease ID may not exist in leases table.";
            } else {
                echo "Error adding payment: " . $e->getMessage();
            }
        }
    } else {
        echo "Error adding payment: Lease ID does not exist in leases table.";
    }
}

?>

</body>
</html>
