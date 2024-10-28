<?php
include('authentication.php');
include 'connect.php';

// Fetch the record that needs to be updated using the `updateid` parameter from URL
$project_id = $_GET['updateid'];
$sql = "SELECT * FROM `employee` WHERE id = $project_id";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

if ($row) {
    $first_name = $row['emp_first_name'];
    $last_name = $row['emp_last_name'];
    $mobile = $row['emp_mobile'];
} else {
    die("Record not found.");
}

$first_nameError = $last_nameError = $mobileError = '';
$valid = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
    $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
    $mobile = isset($_POST['mobile']) ? $_POST['mobile'] : '';

    if (empty($first_name)) {
        $first_nameError = "First name is required.";
        $valid = false;
    } elseif (!preg_match("/^[a-zA-Z ]+$/", $first_name)) {
        $first_nameError = "A valid first name is required (letters only).";
        $valid = false;
    }

    if (empty($last_name)) {
        $last_nameError = "Last name is required.";
        $valid = false;
    } elseif (!preg_match("/^[a-zA-Z ]+$/", $last_name)) {
        $last_nameError = "A valid last name is required (letters only).";
        $valid = false;
    }

    if (empty($mobile)) {
        $mobileError = "Mobile number is required.";
        $valid = false;
    } elseif (!preg_match("/^\d{10}$/", $mobile)) {
        $mobileError = "Mobile number must be exactly 10 digits.";
        $valid = false;
    }

    if ($valid) { 
        $sql = "UPDATE `employee` SET emp_first_name='$first_name', emp_last_name='$last_name', emp_mobile='$mobile' WHERE id=$project_id";
        $result = mysqli_query($con, $sql);

        if ($result) {
            header('location:displayemp.php');
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
    <title>Update Employee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <main class="d-flex g-2">
        <?php include('components/sidebar.php') ?>

        <div class="container my-5" style="max-width: 600px;">
            <h2 class="text-center mb-4 text-primary">Update Employee</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?updateid=' . $project_id; ?>" class="p-4 rounded shadow bg-light">
                
                <div class="mb-3">
                    <label for="first_name" class="form-label fw-bold">First Name</label>
                    <input type="text" name="first_name" class="form-control <?php echo !empty($first_nameError) ? 'is-invalid' : ''; ?>" id="first_name" value="<?php echo htmlspecialchars($first_name); ?>">
                    <div class="invalid-feedback"><?php echo $first_nameError; ?></div>
                </div>

                <div class="mb-3">
                    <label for="last_name" class="form-label fw-bold">Last Name</label>
                    <input type="text" name="last_name" class="form-control <?php echo !empty($last_nameError) ? 'is-invalid' : ''; ?>" id="last_name" value="<?php echo htmlspecialchars($last_name); ?>">
                    <div class="invalid-feedback"><?php echo $last_nameError; ?></div>
                </div>

                <div class="mb-3">
                    <label for="mobile" class="form-label fw-bold">Mobile</label>
                    <input type="text" name="mobile" class="form-control <?php echo !empty($mobileError) ? 'is-invalid' : ''; ?>" id="mobile" value="<?php echo htmlspecialchars($mobile); ?>">
                    <div class="invalid-feedback"><?php echo $mobileError; ?></div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary fw-bold" name="submit">Update</button>
                </div>
            </form>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
