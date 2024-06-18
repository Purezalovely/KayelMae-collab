<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<div class="sidebar bg-dark" style="width: 250px; height: 100vh; position: fixed; top: 0; left: 0;">
  <div class="sidebar-header text-white p-3">
    <h3>Welcome, <?php echo $_SESSION['username']; ?>!</h3>
  </div>
  
  <ul class="nav flex-column">
    <li class="nav-item">
      <a class="nav-link text-white <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>" href="index.php"> Tenant List</a>
    </li>
    <hr class="bg-white">
    <li class="nav-item">
      <a class="nav-link text-white <?php echo ($current_page == 'Tenantprofile.php') ? 'active' : ''; ?>" href="Tenantprofile.php">Tenant Profiles</a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-white <?php echo ($current_page == 'tenant_account.php') ? 'active' : ''; ?>" href="tenant_account.php">Tenant Account</a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-white <?php echo ($current_page == 'Payment.php') ? 'active' : ''; ?>" href="Payment.php">Payment</a>
    </li>
    <hr class="bg-white">
    <li class="nav-item">
      <a class="nav-link text-white <?php echo ($current_page == 'register.php' || $current_page == 'update.php') ? 'active' : ''; ?>" href="register.php">Register</a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-white <?php echo ($current_page == 'logout.php') ? 'active' : ''; ?>" href="logout.php">Logout</a>
    </li>
  </ul>
</div>
