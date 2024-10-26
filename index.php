<?php 
include 'connect.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();  
}

if(isset($_SESSION['auth']))
{
  $redirect_to = $_SESSION['last_page'] ?? 'display.php';
  header("Location: $redirect_to");
  exit;
}

$usernameError = $passwordError = $loginError = '';
$valid = true;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
  $_SESSION['auth'] = true;

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    
    if (empty($username)) {
        $usernameError = "Username is required.";
        $valid = false;
    }
    if (empty($password)) {
        $passwordError = "Password is required.";
        $valid = false;
    }

   
    if ($valid) {
      
        $sql = "SELECT * FROM `crud` WHERE username = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

           
            if (password_verify($password, $row['password'])) {
              
                $_SESSION['username'] = $username;
                
               
                $_SESSION['message'] = "Login Sucessfull";
                header("Location: display.php");
                exit();
            } else {
             
                $loginError = "Incorrect password.";
                $_SESSION['message'] = "crediential does not exist";

            }
        } else {
          
            $loginError = "Invalid username.";
        }

        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Login - NiceAdmin</title>
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
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
                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                    <p class="text-center small">Enter your username & password to login</p>
                  </div>

                 
                  <?php if (!empty($loginError)): ?>
                    <div class="alert alert-danger">
                      <?php echo $loginError; ?>
                    </div>
                  <?php endif; ?>

                  <form action="" method="POST" class="needs-validation" novalidate>
                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Username</label>
                      <div class="input-group has-validation">
                        <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                        <input type="text" name="username" class="form-control" id="yourUsername" required value="pawan">
                        <div class="invalid-feedback">Please enter your username.</div>
                      </div>
                      <?php if (!empty($usernameError)): ?>
                        <small class="text-danger"><?php echo $usernameError; ?></small>
                      <?php endif; ?>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="yourPassword" required value="1234567">
                      <div class="invalid-feedback">Please enter your password!</div>
                      <?php if (!empty($passwordError)): ?>
                        <small class="text-danger"><?php echo $passwordError; ?></small>
                      <?php endif; ?>
                    </div>

                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Login</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Don't have account? <a href="signup.php">Create an account</a></p>
                    </div>
                  </form>

                </div>
              </div>

              <div class="credits">
                Designed by <a href="https://vidhema.com/">Vidhema Technologies</a>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main>

  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
