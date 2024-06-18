<?php
require_once('classes/database.php');
$con = new Database();

session_start();

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Call adminLogin method from Database class
    if ($con->adminLogin($username, $password)) {
        $_SESSION['admin'] = $username;
        header('Location: index.php');
        exit();
    } else {
        $error_message = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container-fluid login-container rounded shadow">
    <h2 class="text-center mb-4">Login</h2>
    <form method="POST">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" name="username" placeholder="Enter username" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" name="password" placeholder="Enter password" required>
        </div>
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        <div class="container">
            <div class="row gx-1 form-group">
                <div class="col">
                    <input type="submit" name="login" class="btn btn-primary btn-block" value="Login">
                </div>
                <div class="col">
                    <a class="btn btn-danger btn-block" href="Adminsignup.php">Sign Up</a>
                </div>
            </div>
        </div>
    </form>
</div>
</body>
</html>
