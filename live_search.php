<?php
require_once('classes/database.php');


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['search'])) {
        $searchterm = $_POST['search']; 
        $con = new database();

        try {
            $connection = $con->opencon();
            
            // Check if the connection is successful
            if ($connection) {
                // SQL query with JOIN
                $query = $connection->prepare("SELECT tenants.tenant_id, tenants.Tenant FN, tenants.TenantLN, tenants.sex, tenants.username, tenants.profile_picture, CONCAT(apartment.Roomno,', ', apartment.floor) AS apartment FROM tenants INNER JOIN apartment ON tenants.tenant_id = tenants_apartment.tenant_id WHERE tenants.username LIKE ? OR tenants.tenant_id LIKE ?");
                $query->execute(["%$searchterm%","%$searchterm%"]);
                $users = $query->fetchAll(PDO::FETCH_ASSOC);

                // Generate HTML for table rows
                $html = '';
                foreach ($tenants as $tenants) {
                    $html .= '<tr>';
                    $html .= '<td>' . $tenants['tenant_id'] . '</td>';
                    $html .= '<td><img src="' . htmlspecialchars($tenants['profile_picture']) . '" alt="Profile Picture" style="width: 50px; height: 50px; border-radius: 50%;"></td>';
                    $html .= '<td>' . $tenants['firstname'] . '</td>';
                    $html .= '<td>' . $tenants['lastname'] . '</td>';
                    $html .= '<td>' . $tenants['sex'] . '</td>';
                    $html .= '<td>' . $tenants['username'] . '</td>';
                    $html .= '<td>' . $tenants['address'] . '</td>';
                    $html .= '<td>'; // Action column
                    $html .= '<form action="update.php" method="post" style="display: inline;">';
                    $html .= '<input type="hidden" name="id" value="' .$tenants['tenant_id'] . '">';
                    $html .= '<button type="submit" class="btn btn-primary btn-sm">Edit</button>';
                    $html .= '</form>';
                    $html .= '<form method="POST" style="display: inline;">';
                    $html .= '<input type="hidden" name="id" value="' . $tenants['tenant_id'] . '">';
                    $html .= '<input type="submit" name="delete" class="btn btn-danger btn-sm" value="Delete" onclick="return confirm(\'Are you sure you want to delete this user?\')">';
                    $html .= '</form>';
                    $html .= '</td>';
                    $html .= '</tr>';
                }
                echo $html;
            } else {
                echo json_encode(['error' => 'Database connection failed.']);
            }
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'No search query provided.']);
    }
} 