<?php
require_once('classes/database.php');
$con = new database();
session_start();

if (empty($_SESSION['username'])) {
    header('location:login.php');
}

if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    if ($con->deleteTenant($id)) { // Assuming deleteTenant method is defined in Database class
        header('location:index.php?status=success');
    } else {
        echo "Something went wrong.";
    }
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

<div class="container user-info rounded shadow p-3 my-2" style="margin-left: 250px;">
    <h2 class="text-center mb-2"> Tenant List</h2>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Picture</th>
                    <th>Tenant FN</th>
                    <th>Tenant LN</th>
                    <th>Sex</th>
                    <th>Username</th>
                    <th>apartment_id</th>
                    <th>Payment</th>
                    <th>lease_id</th>
                    <th>Age</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
            <?php

$counter = 1;
              $data = $con->view();
            foreach ($data as $rows) {
                ?>
                <tr>
                    <td><?php echo $counter++ ?></td>
                    <td>
                        <?php if (!empty($rows['user_profile_picture'])): ?>
                            <img src="<?php echo htmlspecialchars($rows['user_profile_picture']); ?>" alt="Profile Picture" style="width: 50px; height: 50px; border-radius: 50%;">
                        <?php else: ?>
                            <img src="path/to/default/profile/pic.jpg" alt="Default Profile Picture" style="width: 50px; height: 50px; border-radius: 50%;">
                        <?php endif; ?>
                    </td>
                    <td><?php echo $rows['TenantFN']; ?></td>
                    <td><?php echo $rows['TenantLN']; ?></td>
                    <td><?php echo $rows['sex']; ?></td>
                    <td><?php echo $rows['username']; ?></td>
                    <td><?php echo ucwords($rows['apartment_id']); ?></td>
                    <td><?php echo $rows['payment']; ?></td>
                    <td><?php echo $rows['lease_id']; ?></td>
                    <td><?php echo $rows['age']; ?></td>
                    <td>
                        <div class="btn-group" role="group">
                            <form action="update.php" method="post" class="d-inline">
                                <input type="hidden" name="id" value="<?php echo $rows['tenant_id']; ?>">
                                <button type="submit" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </form>
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="id" value="<?php echo $rows['tenant_id']; ?>">
                                <button type="submit" name="delete" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    </div>
    </div>
            </tbody>
        </table>
    </div>

    </div>

    <!-- HTML declaration for bar graph -->
    <div id="chartContainer" style="height: 370px; width: 100%;"></div>

    <!-- HTML declaration for pie chart -->
    <div id="pie" style="height: 370px; width: 100%;"></div>
</div>
<!-- Combine both chart scripts inside one window.onload -->
<script>
window.onload = function() {
    var userChart = new CanvasJS.Chart("chartContainer", {
        animationEnabled: true,
        theme: "light2",
        title: {
            text: "Numbers of Users based on Sex"
        },
        axisY: {
            title: "Number of Users per Sex"
        },
        data: [{
            type: "column",
            yValueFormatString: "",
            dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
        }]
    });
    userChart.render();

    var expenseChart = new CanvasJS.Chart("pie", {
        animationEnabled: true,
        exportEnabled: true,
        title: {
            text: "Number of Users per Sex"
        },
        subtitles: [{
            text: "Total"
        }],
        data: [{
            type: "pie",
            showInLegend: "true",
            legendText: "{label}",
            indexLabelFontSize: 16,
            indexLabel: "{label} - #percent%",
            yValueFormatString: "#,##0",
            dataPoints: <?php echo json_encode($datapoints, JSON_NUMERIC_CHECK); ?>
        }]
    });
    expenseChart.render();
}
</script>
<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="./bootstrap-5.3.3-dist/js/bootstrap.js"></script>
<!-- Bootsrap JS na nagpapagana ng danger alert natin -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<!-- For Charts -->
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
<script src="package/dist/sweetalert2.js"></script>