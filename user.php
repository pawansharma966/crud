<?php
include ('authentication.php');
include 'connect.php'; 

$firstNameError = $lastNameError = $usernameError = $emailError = $mobileError = '';
$valid = true;

$first_name = $last_name = $username = $email = $mobile = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Fetching data from the form
    $first_name = isset($_POST['firstname']) ? $_POST['firstname'] : '';
    $last_name = isset($_POST['lastname']) ? $_POST['lastname'] : '';
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $mobile = isset($_POST['mobile']) ? $_POST['mobile'] : '';

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

    // Username validation
    if (empty($username)) {
        $usernameError = "Username is required.";
        $valid = false;
    } elseif (!preg_match("/^[a-zA-Z]+$/", $username)) {
        $usernameError = "Username should contain letters only.";
        $valid = false;
    }

    // Email validation
    if (empty($email)) {
        $emailError = "Email is required.";
        $valid = false;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = "A valid email address is required.";
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

    // Insert data into the database if validation passes
    if ($valid) {
        $sql = "INSERT INTO `crud` (first_name, last_name, username, email, mobile) 
                VALUES ('$first_name', '$last_name', '$username', '$email', '$mobile')";
        $result = mysqli_query($con, $sql);
        
        if ($result) {
            header('location:display.php'); // Redirect to a display page after successful insertion
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
     
<nav class="navbar navbar-expand-lg navbar-light sidebar vh-100 d-flex flex-column p-3" style="width: 150px; position: fixed; top: 0; left: 0; background-color: blue;">
    <div class="container-fluid flex-column">
        <a class="navbar-brand mb-4" style="color: white;" href="#">Admin Panel</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" style="color: white;" href="view.php">View Users</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container my-5" style="max-width: 600px;">
    <h2 class="text-center mb-4 text-primary">Add User</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="p-4 rounded shadow bg-light">
        
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
            <label for="username" class="form-label fw-bold">Username</label>
            <input type="text" name="username" class="form-control <?php echo !empty($usernameError) ? 'is-invalid' : ''; ?>" 
                   id="username" value="<?php echo htmlspecialchars($username); ?>">
            <div class="invalid-feedback"><?php echo $usernameError; ?></div>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label fw-bold">Email</label>
            <input type="email" name="email" class="form-control <?php echo !empty($emailError) ? 'is-invalid' : ''; ?>" 
                   id="email" value="<?php echo htmlspecialchars($email); ?>">
            <div class="invalid-feedback"><?php echo $emailError; ?></div>
        </div>

        <div class="mb-3">
            <label for="mobile" class="form-label fw-bold">Mobile</label>
            <input type="text" name="mobile" class="form-control <?php echo !empty($mobileError) ? 'is-invalid' : ''; ?>" 
                   id="mobile" value="<?php echo htmlspecialchars($mobile); ?>">
            <div class="invalid-feedback"><?php echo $mobileError; ?></div>
        </div>

        <!-- Submit Button -->
        <div class="d-grid">
            <button type="submit" class="btn btn-primary fw-bold" name="submit">Submit</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
