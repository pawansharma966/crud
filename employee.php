<?php
include('authentication.php');
include 'connect.php';

$firstNameError = $lastNameError = $mobileError = $fileError = '';
$valid = true;
$first_name = $last_name = $mobile = $filePath = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetching data from the form
    $first_name = $_POST['firstname'] ?? '';
    $last_name = $_POST['lastname'] ?? '';
    $mobile = $_POST['mobile'] ?? '';

    // First name validation
    if (empty($first_name)) {
        $firstNameError = "First name is required.";
        $valid = false;
    } elseif (!preg_match("/^[a-zA-Z]+$/", $first_name)) {
        $firstNameError = "A valid first name is required (letters only).";
        $valid = false;
    }

    // Last name validation
    if (empty($last_name)) {
        $lastNameError = "Last name is required.";
        $valid = false;
    } elseif (!preg_match("/^[a-zA-Z]+$/", $last_name)) {
        $lastNameError = "A valid last name is required (letters only).";
        $valid = false;
    }

    // Mobile validation
    if (empty($mobile)) {
        $mobileError = "Mobile number is required.";
        $valid = false;
    } elseif (!preg_match("/^\d{10}$/", $mobile)) {
        $mobileError = "Mobile number must be exactly 10 digits.";
        $valid = false;
    }

    // File upload validation
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $fileType = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
        if (in_array($fileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            // Define upload directory and file path
            $filePath = 'uploads/' . basename($_FILES['file']['name']);
            if (!is_dir('uploads')) {
                mkdir('uploads', 0777, true); // Create uploads directory if not exists
            }                        
            // Move uploaded file to the designated directory
            if (!move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
                $fileError = "Failed to upload image.";
                $valid = false;
            }
        } else {
            $fileError = "Only JPG, JPEG, PNG, and GIF files are allowed.";
            $valid = false;
        }
    } else {
        $fileError = "Please upload an image.";
        $valid = false;
    }

    // Insert data into the database if validation passes
    if ($valid) {
        $sql = "INSERT INTO `employee` (emp_first_name, emp_last_name, emp_mobile, file) 
                VALUES ('$first_name', '$last_name', '$mobile', '$filePath')";
        $result = mysqli_query($con, $sql);

        if ($result) {
            header('location:displayemp.php'); // Redirect to a display page after successful insertion
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
    <title>Employee </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<main class="d-flex g-2">
<?php include('components/sidebar.php')?>

<div class="container my-2" style="max-width: 600px;">
    <h2 class="text-center mb-2 text-primary">Employee </h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" 
          enctype="multipart/form-data" class="p-4 rounded shadow bg-light">
        
        <div class="mb-3">
            <label for="firstname" class="form-label fw-bold">First Name</label>
            <input type="text" name="firstname" class="form-control <?php echo !empty($firstNameError) ? 'is-invalid' : ''; ?>" 
                   id="firstname" value="<?php echo htmlspecialchars($first_name); ?>">
            <div class="invalid-feedback"><?php echo $firstNameError; ?></div>
        </div>

        <div class="mb-3">
            <label for="lastname" class="form-label fw-bold">Last Name</label>
            <input type="text" name="lastname" class="form-control <?php echo !empty($lastNameError) ? 'is-invalid' : ''; ?>" 
                   id="lastname" value="<?php echo htmlspecialchars($last_name); ?>">
            <div class="invalid-feedback"><?php echo $lastNameError; ?></div>
        </div>

        <div class="mb-3">
            <label for="mobile" class="form-label fw-bold">Mobile</label>
            <input type="text" name="mobile" class="form-control <?php echo !empty($mobileError) ? 'is-invalid' : ''; ?>" 
                   id="mobile" value="<?php echo htmlspecialchars($mobile); ?>">
            <div class="invalid-feedback"><?php echo $mobileError; ?></div>
        </div>

        <div class="mb-3">
            <label for="file" class="form-label fw-bold">Upload Image</label>
            <input type="file" name="file" class="form-control <?php echo !empty($fileError) ? 'is-invalid' : ''; ?>" id="file" required>
            <div class="invalid-feedback"><?php echo $fileError; ?></div>
         
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary fw-bold" name="submit">Submit</button>
        </div>
    </form>
</div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
