<?php

include ('authentication.php');
include 'connect.php';

// Fetch the record that needs to be updated using the `id` parameter from URL
$id = $_GET['updateid'];
$sql = "SELECT * FROM `crud` WHERE id=$id";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

// Initialize variables with the current record values
$username = $row['username'];
$email = $row['email'];
$mobile = $row['mobile'];
$first_name = $row['first_name'];
$last_name = $row['last_name'];

// Initialize error variables
$usernameError = $emailError = $mobileError = $first_nameError = $last_nameError = '';
$valid = true;

// Handle form submission
if (isset($_POST['submit'])) {
    // Retrieve the submitted form values
    $first_name = trim($_POST['firstname']);
    $last_name = trim($_POST['lastname']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $mobile = trim($_POST['mobile']);

    
    if (empty($first_name)) {
        $first_nameError = "First name is required.";
        $valid = false;
    } elseif (!preg_match("/^[a-zA-Z]+$/", $first_name)) {
        $first_nameError = "A valid first name is required (letters only).";
        $valid = false;
    }

    if (empty($last_name)) {
        $last_nameError = "Last name is required.";
        $valid = false;
    } elseif (!preg_match("/^[a-zA-Z]+$/", $last_name)) {
        $last_nameError = "A valid last name is required (letters only).";
        $valid = false;
    }

    if (empty($username)) {
        $usernameError = "Username is required.";
        $valid = false;
    } elseif (!preg_match("/^[a-zA-Z]+$/", $username)) {
        $usernameError = "Username should contain letters only.";
        $valid = false;
    }

    if (empty($email)) {
        $emailError = "Email is required.";
        $valid = false;
    }

    if (empty($mobile)) {
        $mobileError = "Mobile number is required.";
        $valid = false;
    } elseif (!preg_match("/^\d{10}$/", $mobile)) {
        $mobileError = "Mobile number must be exactly 10 digits.";
        $valid = false;
    }

    // If all validations pass, update the record in the database
    if ($valid) {
        $sql = "UPDATE `crud` SET first_name='$first_name', last_name='$last_name', username='$username', email='$email', mobile='$mobile' WHERE id=$id";
        $result = mysqli_query($con, $sql);

        if ($result) {
            // Redirect to the display page after successful update
            header('location:display.php');
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
    <title>Crud Operation - Update</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column; /* Ensure the footer is at the bottom */
        }
        .sidebar {
            height: 100vh;
            position: sticky;
            top: 0;
            background-color: blue;
        }
        footer {
            margin-top: auto; /* Push footer to the bottom */
        }
    </style>
<body>
<?php include('components/sidebar.php')?>

    <div class="container  my-5 mx-auto" style="margin-left: 180px; max-width: 700px;">
        <h2 class="text-center mb-4 text-primary">Update Record</h2>

        <form method="post" class="p-4 rounded shadow bg-light mx-auto">
            <div class="mb-3">
                <label for="first_name" class="form-label fw-bold">First Name</label>
                <input type="text" name="firstname" 
                       class="form-control <?php echo !empty($first_nameError) ? 'is-invalid' : ''; ?>" 
                       id="firstname" 
                       value="<?php echo htmlspecialchars($first_name ?? ''); ?>">
                <div class="invalid-feedback"><?php echo $first_nameError; ?></div>
            </div>

            <div class="mb-3">
                <label for="last_name" class="form-label fw-bold">Last Name</label>
                <input type="text" name="lastname" 
                       class="form-control <?php echo !empty($last_nameError) ? 'is-invalid' : ''; ?>" 
                       id="lastname" 
                       value="<?php echo htmlspecialchars($last_name ?? ''); ?>">
                <div class="invalid-feedback"><?php echo $last_nameError; ?></div>
            </div>

            <div class="mb-3">
                <label for="username" class="form-label fw-bold">User Name</label>
                <input type="text" name="username" 
                       class="form-control <?php echo !empty($usernameError) ? 'is-invalid' : ''; ?>" 
                       id="yourUsername" 
                       value="<?php echo htmlspecialchars($username ?? ''); ?>">
                <div class="invalid-feedback"><?php echo $usernameError; ?></div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label fw-bold">Email</label>
                <input type="text" class="form-control" 
                       name="email" autocomplete="off" 
                       value="<?php echo htmlspecialchars($email ?? ''); ?>">
                <?php if (!empty($emailError)): ?>
                    <div class="text-danger small"><?php echo $emailError; ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="mobile" class="form-label fw-bold">Mobile</label>
                <input type="text" name="mobile" 
                       class="form-control <?php echo !empty($mobileError) ? 'is-invalid' : ''; ?>" 
                       id="mobile" 
                       value="<?php echo htmlspecialchars($mobile ?? ''); ?>">
                <div class="invalid-feedback"><?php echo $mobileError; ?></div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary fw-bold" name="submit">Update</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
