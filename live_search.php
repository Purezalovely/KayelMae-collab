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
                $query = $connection->prepare("SELECT users.user_id, users.user_firstname, users.user_lastname, users.user_birthday, users.user_sex, users.user_name, users.user_profile_picture, CONCAT(user_address.city,', ', user_address.province) AS address FROM users INNER JOIN user_address ON users.user_id = user_address.user_id");
                $query->execute(["%$searchterm%","%$searchterm%"]);
                $users = $query->fetchAll(PDO::FETCH_ASSOC);

                // Generate HTML for table rows
                $html = '';
                foreach ($tenants as $tenants) {
                    $html .= '<tr>';
                    $html .= '<td>' . $tenants['tenant_id'] . '</td>';
                    $html .= '<td><img src="' . htmlspecialchars($tenants['profile_picture']) . '" alt="Profile Picture" style="width: 50px; height: 50px; border-radius: 50%;"></td>';
                    $html .= '<td>' . $tenants['TenantFN'] . '</td>';
                    $html .= '<td>' . $tenants['TenantLN'] . '</td>';
                    $html .= '<td>' . $tenants['sex'] . '</td>';
                    $html .= '<td>' . $tenants['username'] . '</td>';
                    $html .= '<td>' . $tenants['apartment_id'] . '</td>';
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