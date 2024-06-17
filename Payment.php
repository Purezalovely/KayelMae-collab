<?php
require_once('classes/database.php');
$con = new database();
session_start();

if (empty($_SESSION['username'])) {
    header('location:login.php');
}

if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    if ($con->delete($id)) {
        header('location:index.php?status=success');
    } else {
        echo "Something went wrong.";
    }
}

// Create a new PDO instance
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

// Function to add a new payment
function addPayment($apartmentId, $paymentDate, $amount)
{
    global $pdo;

    // Prepare the SQL statement
    $stmt = $pdo->prepare("INSERT INTO payments (apartment_id, payment_date, amount) VALUES (?, ?, ?)");

    // Execute the SQL statement
    $stmt->execute([$apartmentId, $paymentDate, $amount]);
}

// Example usage
$apartmentId = 1;
$paymentDate = '2023-03-01';
$amount = 1000;

addPayment($apartmentId, $paymentDate, $amount);

echo "Payment added successfully!";

?>