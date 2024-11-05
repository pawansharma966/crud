<?php
include('authentication.php');
include 'connect.php';

$id = $_GET['updateid'] ?? '';
if (!$id) {
    die("Invalid ID.");
}


$sql = "SELECT * FROM `client` WHERE id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    die("Record not found.");
}

$name = $row['name'];
$email = $row['email'];
$phone = $row['phone'];
$project = json_decode($row['projects_id'], true) ?: []; 


$NameError = $emailError = $phoneError = $projectError = '';
$valid = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $project = $_POST['project'] ?? [];

   
    if (empty($name)) {
        $NameError = "Name is required.";
        $valid = false;
    } elseif (!preg_match("/^[a-zA-Z ]+$/", $name)) {
        $NameError = "A valid name is required (letters only).";
        $valid = false;
    }

  
    if (empty($email)) {
        $emailError = "Email is required.";
        $valid = false;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = "Invalid email format.";
        $valid = false;
    }

    
    if (empty($phone)) {
        $phoneError = "Phone is required.";
        $valid = false;
    } elseif (!preg_match("/^[0-9]{10}$/", $phone)) {
        $phoneError = "Invalid phone number.";
        $valid = false;
    }

    if ($valid) {
        $projects_id = json_encode($project);

        
        $sql = "UPDATE `client` SET name = ?, email = ?, phone = ?, projects_id = ? WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssssi", $name, $email, $phone, $projects_id, $id);
        
        if ($stmt->execute()) {
            header('Location: displayclient.php');
            exit();
        } else {
            die("Update failed: " . $stmt->error);
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

        <div class="container my-2" style="max-width: 600px;">
            <h2 class="text-center mb-2 text-primary">Update Client</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?updateid=' . $id; ?>" class="p-4 rounded shadow bg-light">

             
                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">Name</label>
                    <input type="text" name="name" class="form-control <?php echo !empty($NameError) ? 'is-invalid' : ''; ?>" id="name" value="<?php echo htmlspecialchars($name); ?>">
                    <div class="invalid-feedback"><?php echo $NameError; ?></div>
                </div>

           
                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">Email</label>
                    <input type="email" name="email" class="form-control <?php echo !empty($emailError) ? 'is-invalid' : ''; ?>" id="email" value="<?php echo htmlspecialchars($email); ?>">
                    <div class="invalid-feedback"><?php echo $emailError; ?></div>
                </div>

            
                <div class="mb-3">
                    <label for="phone" class="form-label fw-bold">Mobile</label>
                    <input type="text" name="phone" class="form-control <?php echo !empty($phoneError) ? 'is-invalid' : ''; ?>" id="phone" value="<?php echo htmlspecialchars($phone); ?>">
                    <div class="invalid-feedback"><?php echo $phoneError; ?></div>
                </div>

           
                <div class="mb-3">
                    <label for="project" class="form-label fw-bold">Select Project</label>
                    <select name="project[]" id="project" class="form-control <?php echo !empty($projectError) ? 'is-invalid' : ''; ?>" multiple>
                        <option value="">-- Select Project --</option>
                        <?php 
                        $query = "SELECT project_id, project_name FROM project";
                        $result = $con->query($query);                    
                        while ($project_row = $result->fetch_assoc()): ?>
                            <option value="<?php echo $project_row['project_id']; ?>" <?php echo in_array($project_row['project_id'], $project) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($project_row['project_name']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                    <div class="invalid-feedback"><?php echo $projectError; ?></div>
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
