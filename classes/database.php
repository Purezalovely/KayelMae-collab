<?php
class Database {
    private $pdo;

    public function __construct() {
        $dsn = 'mysql:host=localhost;dbname=wilesdb;charset=utf8mb4';
        $username = 'username';  // Update with your database username
        $password = 'password';  // Update with your database password

        try {
            $this->pdo = new PDO($dsn, $username, $password);
            // Set error mode to exception
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }


    // Define the viewdata method for apartments
    public function viewdata($apartment_id) {
        $stmt = $this->pdo->prepare("SELECT apartment_id, Roomno, floor, num_bedrooms, num_bathrooms, rent, created_at FROM apartments WHERE apartment_id = ?");
        $stmt->execute([$apartment_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Define the updateApartmentDetails method
    public function updateApartmentDetails($apartment_id, $Roomno, $floor, $num_bedrooms, $num_bathrooms, $rent) {
        $stmt = $this->pdo->prepare("UPDATE apartments SET Roomno = ?,  floor = ?, num_bedrooms = ?, num_bathrooms = ?, rent = ? WHERE apartment_id = ?");
        return $stmt->execute([$Roomno, $floor, $num_bedrooms, $num_bathrooms, $rent, $apartment_id]);
    }

    public function __destruct() {
        $this->pdo = null;
    }

    public function view() {
        try {
            $stmt = $this->pdo->query("SELECT tenant_id, `Tenant FN`, `Tenant LN`, phone, lease_id, sex, username, email,  apartment_id, age FROM tenants");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

     // Function to view tenant profile
    public function viewTenantProfile($tenantId) {
        $stmt = $this->pdo->prepare("SELECT tenant_id, Tenant FN, Tenant LN,  username, email,  phone, lease_id FROM tenants WHERE tenant_id = ?");
        $stmt->execute([$tenantId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Function to delete tenant
    public function deleteTenant($tenantId) {
        try {
            $this->pdo->beginTransaction();
            $stmt = $this->pdo->prepare("DELETE FROM tenants WHERE tenant_id = ?");
            $stmt->execute([$tenantId]);
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollback();
            return false;
        }
    }

    // Function to add apartment
    public function addApartment($Roomno, $floor, $numBedrooms, $numBathrooms, $rent) {
        try {
            $this->pdo->beginTransaction();
            $stmt = $this->pdo->prepare("INSERT INTO apartments (Room.no, floor, num_bedrooms, num_bathrooms, rent) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$Roomno, $floor, $numBedrooms, $numBathrooms, $rent]);
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollback();
            return false;
        }
    }

    // Function to add lease
    public function addLease($tenantId, $apartmentId, $startDate, $endDate, $rent) {
        try {
            $this->pdo->beginTransaction();
            $stmt = $this->pdo->prepare("INSERT INTO leases (tenant_id, apartment_id, start_date, end_date, rent) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$tenantId, $apartmentId, $startDate, $endDate, $rent]);
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollback();
            return false;
        }
    }

    // Function to add maintenance request
    public function addMaintenanceRequest($tenantId, $apartmentId, $requestDate, $description) {
        try {
            $this->pdo->beginTransaction();
            $stmt = $this->pdo->prepare("INSERT INTO maintenance_requests (tenant_id, apartment_id, request_date, description) VALUES (?, ?, ?, ?)");
            $stmt->execute([$tenantId, $apartmentId, $requestDate, $description]);
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollback();
            return false;
        }
    }

    // Function to add payment
    public function addPayment($leaseId, $amount, $paymentDate) {
        try {
            $this->pdo->beginTransaction();
            $stmt = $this->pdo->prepare("INSERT INTO payments (lease_id, amount, payment_date) VALUES (?, ?, ?)");
            $stmt->execute([$leaseId, $amount, $paymentDate]);
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollback();
            return false;
        }
    }
}
?>
