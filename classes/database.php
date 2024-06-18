<?php
class Database {
    private $pdo;

    public function __construct() {
        $dsn = 'mysql:host=localhost;dbname=wilesdb;charset=utf8mb4';
        $username = 'your_database_username';  // Replace with your database username
        $password = 'your_database_password';  // Replace with your database password

        try {
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Test query to ensure the connection is working
            $this->pdo->query("SELECT 1");
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function viewdata($apartment_id) {
        $stmt = $this->pdo->prepare("SELECT apartment_id, Roomno, floor, num_bedrooms, num_bathrooms, rent, created_at FROM apartments WHERE apartment_id = ?");
        $stmt->execute([$apartment_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateApartmentDetails($apartment_id, $Roomno, $floor, $num_bedrooms, $num_bathrooms, $rent_amount, $created_at) {
        $stmt = $this->pdo->prepare("UPDATE apartments SET Roomno = ?, floor = ?, num_bedrooms = ?, num_bathrooms = ?, rent = ? WHERE apartment_id = ?");
        return $stmt->execute([$Roomno, $floor, $num_bedrooms, $num_bathrooms, $rent_amount, $created_at, $apartment_id]);
    }

    public function viewTenantProfile($tenant_id) {
        $stmt = $this->pdo->prepare("SELECT tenant_id, `Tenant FN`, `Tenant LN`, username, email, phone, lease_id FROM tenants WHERE tenant_id = ?");
        $stmt->execute([$tenant_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteTenant($tenant_id) {
        try {
            $this->pdo->beginTransaction();
            $stmt = $this->pdo->prepare("DELETE FROM tenants WHERE tenant_id = ?");
            $stmt->execute([$tenant_id]);
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollback();
            return false;
        }
    }

    public function addApartment($Roomno, $floor, $num_bedrooms, $num_bathrooms, $rent_amount, $created_at) {
        try {
            $this->pdo->beginTransaction();
            $stmt = $this->pdo->prepare("INSERT INTO apartments (Roomno, floor, num_bedrooms, num_bathrooms, rent_amount, created_at) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$Roomno, $floor, $num_bedrooms, $num_bathrooms, $rent_amount, $created_at]);
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollback();
            return false;
        }
    }

    public function addLease($lease_id, $tenant_id, $apartment_id, $start_date, $end_date, $rent) {
        try {
            $this->pdo->beginTransaction();
            $stmt = $this->pdo->prepare("INSERT INTO leases (lease_id, tenant_id, apartment_id, start_date, end_date, rent) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$lease_id, $tenant_id, $apartment_id, $start_date, $end_date, $rent]);
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollback();
            return false;
        }
    }

    public function addMaintenanceRequest($request_id, $tenant_id, $apartment_id, $request_date, $description, $status) {
        try {
            $this->pdo->beginTransaction();
            $stmt = $this->pdo->prepare("INSERT INTO maintenance_requests (request_id, tenant_id, apartment_id, request_date, description, status) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$request_id, $tenant_id, $apartment_id, $request_date, $description, $status]);
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollback();
            return false;
        }
    }

    public function addPayment($payment_id, $lease_id, $amount, $payment_date) {
        try {
            $this->pdo->beginTransaction();
            $stmt = $this->pdo->prepare("INSERT INTO payments (payment_id, lease_id, amount, payment_date) VALUES (?, ?, ?, ?)");
            $stmt->execute([$payment_id, $lease_id, $amount, $payment_date]);
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollback();
            return false;
        }
    }

    public function adminSignup($username, $password) {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->pdo->prepare("INSERT INTO admins (Admin_username, Admin_passwords) VALUES (?, ?)");
            $stmt->execute([$username, $hashedPassword]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function adminLogin($username, $password) {
        $stmt = $this->pdo->prepare("SELECT Admin_passwords FROM admins WHERE Admin_username = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && isset($admin['Admin_passwords']) && password_verify($password, $admin['Admin_passwords'])) {
            return true;
        } else {
            return false;
        }
    }
}