<?php 
include 'connect.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
    // session_destroy();
}

$first_nameError = $last_nameError = $emailError = $usernameError = $passwordError = $mobileError = '';
$valid = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $first_name = trim($_POST['firstname']);
    $last_name = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $mobile = trim($_POST['mobile']);


    if (!preg_match("/^[a-zA-Z]+$/", $first_name)) {
        $first_nameError = "A valid first name is required (letters only, no digits or special characters).";
        $valid = false;
    }

   
    if (!preg_match("/^[a-zA-Z]+$/", $last_name)) {
        $last_nameError = "A valid last name is required (letters only, no digits or special characters).";
        $valid = false;
    }

    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = "A valid email is required.";
        $valid = false;
    }

   
    if (!preg_match("/^[a-zA-Z]+$/", $username)) {
        $usernameError = "Username should contain letters only, no digits or special characters.";
        $valid = false;
    }

   
    if (!preg_match("/^\d{6,}$/", $password)) {
        $passwordError = "Password must be at least 6 digits long and contain only numbers.";
        $valid = false;
    }

    if (!preg_match("/^\d{10}$/", $mobile)) {
        $mobileError = "Mobile number must be exactly 10 digits and contain only numbers.";
        $valid = false;
    }


    if ($valid) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        
        $stmt = $con->prepare("INSERT INTO crud (first_name, last_name, email, mobile, username, password) 
                               VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $first_name, $last_name, $email, $mobile, $username, $hashedPassword);

        if ($stmt->execute()) {
            $_SESSION['email'] = $email; 
            $_SESSION['username'] = $username; 
            header("Location: index.php");
            exit();
        } else {
            die("Database error: " . $con->error);
        }

        $stmt->close();
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Register</title>
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
  <main>
    <div class="container">
      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

            <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">NiceAdmin</span>
                </a>
              </div>
              <div class="card mb-3">
                <div class="card-body">
                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                    <p class="text-center small">Enter your personal details to create an account</p>
                  </div>

                  <form action="" method="POST" class="needs-validation" novalidate>
    <div class="col-12">
        <label for="firstname" class="form-label">First Name</label>
        <input type="text" name="firstname" class="form-control <?php echo !empty($first_nameError) ? 'is-invalid' : ''; ?>" 
               id="firstname" value="<?php echo htmlspecialchars($first_name ?? ''); ?>" required>
        <div class="invalid-feedback"><?php echo $first_nameError; ?></div>
    </div>
    
    <div class="col-12">
        <label for="lastname" class="form-label">Last Name</label>
        <input type="text" name="lastname" class="form-control <?php echo !empty($last_nameError) ? 'is-invalid' : ''; ?>" 
               id="lastname" value="<?php echo htmlspecialchars($last_name ?? ''); ?>" required>
        <div class="invalid-feedback"><?php echo $last_nameError; ?></div>
    </div>

    <div class="col-12">
        <label for="yourEmail" class="form-label">Your Email</label>
        <input type="email" name="email" class="form-control <?php echo !empty($emailError) ? 'is-invalid' : ''; ?>" 
               id="yourEmail" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
        <div class="invalid-feedback"><?php echo $emailError; ?></div>
    </div>

    <div class="col-12">
        <label for="yourUsername" class="form-label">Username</label>
        <div class="input-group has-validation">
            <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
            <input type="text" name="username" class="form-control <?php echo !empty($usernameError) ? 'is-invalid' : ''; ?>" 
                   id="yourUsername" value="<?php echo htmlspecialchars($username ?? ''); ?>" required>
            <div class="invalid-feedback"><?php echo $usernameError; ?></div>
        </div>
    </div>

    <div class="col-12">
        <label for="yourPassword" class="form-label">Password</label>
        <input type="password" name="password" class="form-control <?php echo !empty($passwordError) ? 'is-invalid' : ''; ?>" 
               id="yourPassword" required>
        <div class="invalid-feedback"><?php echo $passwordError; ?></div>
    </div>

    <div class="col-12">
        <label for="mobile" class="form-label">Mobile No.</label>
        <input type="text" name="mobile" class="form-control <?php echo !empty($mobileError) ? 'is-invalid' : ''; ?>" 
               id="mobile" value="<?php echo htmlspecialchars($mobile ?? ''); ?>" required>
        <div class="invalid-feedback"><?php echo $mobileError; ?></div>
    </div>

    <div class="col-12">
        <button class="btn btn-primary w-100" type="submit">Create Account</button>
    </div>
    <div class="col-12">
        <p class="small mb-0">Already have an account? <a href="index.php">Log in</a></p>
    </div>
</form>


                </div>
              </div>

              <div class="credits">
                Designed by <a href="https://bootstrapmade.com/">Vidhema Technologies</a>
              </div>

            </div>
          </div>
        </div>

      </section>
    </div>
  </main>

  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/main.js"></script>
  <script>
(function () {
  'use strict';
  var forms = document.querySelectorAll('.needs-validation');
  Array.prototype.slice.call(forms).forEach(function (form) {
    form.addEventListener('submit', function (event) {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      }
      form.classList.add('was-validated');
    }, false);
  });
})();
</script>


</body>
</html>
