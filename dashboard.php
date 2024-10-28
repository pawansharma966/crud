<?php
include('authentication.php');
include 'connect.php'; 


// Count the total number of projects

$countQuery = "SELECT COUNT(project_id) AS total_project FROM `project`";
$countResult = mysqli_query($con, $countQuery);
$countRow = mysqli_fetch_assoc($countResult);
$totalProject = $countRow['total_project'] ?? 0; // Using null coalescing operator to handle undefined index

$countQuery = "SELECT COUNT(id) AS total_employee FROM `employee`";
$countResult = mysqli_query($con, $countQuery);
$countRow = mysqli_fetch_assoc($countResult);
$totalEmployee = $countRow['total_employee'] ?? 0; // Using null coalescing operator to handle undefined index

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRUD Operation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<main class="d-flex g-2">
<?php include('components/sidebar.php')?>

<div class="container my-5" style="max-width: 400px;">
    <!-- Card displaying total employee count -->
    <div class="card text-center mb-4">
        <div class="card-body">
            <h5 class="card-title">Total Projects</h5>
            <p class="card-text fs-3 fw-bold text-primary"><?php echo $totalProject; ?></p>
        </div>
    </div>

</div>
<div class="container my-5" style="max-width: 400px;">
    <!-- Card displaying total employee count -->
    <div class="card text-center mb-4">
        <div class="card-body">
            <h5 class="card-title">Total Employees</h5>
            <p class="card-text fs-3 fw-bold text-primary"><?php echo $totalEmployee; ?></p>
        </div>
    </div>

</div>
</main>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->

</body>
</html>
