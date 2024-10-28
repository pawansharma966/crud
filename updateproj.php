<?php
include('authentication.php');
include 'connect.php';

// Fetch the record that needs to be updated using the `updateid` parameter from URL
$project_id = $_GET['updateid'];
$sql = "SELECT * FROM `project` WHERE project_id = $project_id"; // Update here
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

if ($row) {
    $project_name = $row['project_name'];
    $description = $row['description'];
    $employee = $row['emp_id'];
} else {
    // Handle case where no record is found
    die("Record not found.");
}

$projectNameError = $descriptionError = $employeeError = '';
$valid = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Fetching data from the form
    $project_name = isset($_POST['projectname']) ? $_POST['projectname'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $employee = isset($_POST['employee']) ? $_POST['employee'] : '';

    // Project name validation
    if (empty($project_name)) {
        $projectNameError = "Project name is required.";
        $valid = false;
    } elseif (!preg_match("/^[a-zA-Z ]+$/", $project_name)) {
        $projectNameError = "A valid project name is required (letters only).";
        $valid = false;
    }

    // Description validation
    if (empty($description)) {
        $descriptionError = "Description is required.";
        $valid = false;
    } 

    if (empty($employee)) {
        $employeeError = "Employee is required for project.";
        $valid = false;
    }

    // Update data in the database if validation passes
    if ($valid) { 
        $sql = "UPDATE `project` SET project_name='$project_name', description='$description', emp_id='$employee' WHERE project_id=$project_id"; // Update here
        $result = mysqli_query($con, $sql);

        if ($result) {
            header('location:display_project.php'); // Redirect to a display page after successful update
            exit();
        } else {
            die(mysqli_error($con));
        }
    }
}
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
        <?php include('components/sidebar.php') ?>

        <div class="container my-5" style="max-width: 600px;">
            <h2 class="text-center mb-4 text-primary">Update Project</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?updateid=' . $project_id; ?>"
                class="p-4 rounded shadow bg-light">

                <div class="mb-3">
                    <label for="projectname" class="form-label fw-bold">Project Name</label>
                    <input type="text" name="projectname"
                        class="form-control <?php echo !empty($projectNameError) ? 'is-invalid' : ''; ?>" id="projectname"
                        value="<?php echo htmlspecialchars($project_name); ?>">
                    <div class="invalid-feedback"><?php echo $projectNameError; ?></div>
                </div>

                <div class="mb-3">
                    <label for="employee" class="form-label fw-bold">Select Employee</label>
                    <select name="employee" id="employee" class="form-control <?php echo !empty($employeeError) ? 'is-invalid' : ''; ?>">
                        <option value="">-- Select Employee --</option>
                        <?php 
                        $query = "SELECT id, emp_first_name, emp_last_name FROM employee";
                        $result = $con->query($query);                    
                        while ($emp_row = $result->fetch_assoc()): ?>
                            <option value="<?php echo $emp_row['id']; ?>" <?php echo $employee == $emp_row['id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($emp_row['emp_first_name'] . ' ' . $emp_row['emp_last_name']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                    <div class="invalid-feedback"><?php echo $employeeError; ?></div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label fw-bold">Description</label>
                    <textarea name="description"
                        class="form-control <?php echo !empty($descriptionError) ? 'is-invalid' : ''; ?>" id="description"
                        rows="4"><?php echo htmlspecialchars($description); ?></textarea>
                    <div class="invalid-feedback"><?php echo $descriptionError; ?></div>
                </div>

                <!-- Submit Button -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary fw-bold" name="submit">Update</button>
                </div>
            </form>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
