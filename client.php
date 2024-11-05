<?php
include('authentication.php');
include 'connect.php';

$NameError = $emailError = $phoneError = $projectError = '';
$valid = true;

$name = $email = $phone = '';
$project = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $project = isset($_POST['project']) ? $_POST['project'] : [];

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
    }

    if (empty($phone)) {
        $phoneError = "Phone is required.";
        $valid = false;
    }

    if (empty($project)) {
        $projectError = "Project selection is required.";
        $valid = false;
    }

    if ($valid) {
        $projectJSON = json_encode($project); 

        $sql = "INSERT INTO `client` (`name`, `email`, `phone`, `projects_id`) VALUES ('$name', '$email', '$phone', '$projectJSON')";
        $result = mysqli_query($con, $sql);

        if ($result) {
            header('location:displayclient.php');
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

        <div class="container my-2" style="max-width: 600px;">
            <h2 class="text-center mb-2 text-primary">Client</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="p-4 rounded shadow bg-light">
                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">Name</label>
                    <input type="text" name="name" class="form-control <?php echo !empty($NameError) ? 'is-invalid' : ''; ?>" id="name" value="<?php echo htmlspecialchars($name); ?>">
                    <div class="invalid-feedback"><?php echo $NameError; ?></div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">Email</label>
                    <input type="text" name="email" class="form-control <?php echo !empty($emailError) ? 'is-invalid' : ''; ?>" id="email" value="<?php echo htmlspecialchars($email); ?>">
                    <div class="invalid-feedback"><?php echo $emailError; ?></div>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label fw-bold">Phone</label>
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
                        while ($projectRow = $result->fetch_assoc()): ?>
                            <option value="<?php echo $projectRow['project_id']; ?>" <?php echo in_array($projectRow['project_id'], $project) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($projectRow['project_name']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                    <div class="invalid-feedback"><?php echo $projectError; ?></div>
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





<?php
$query = "SELECT project_id, project_name FROM project";
$result = $con->query($query);

$projects = [];
while ($project = $result->fetch_assoc()) {
    $projects[] = [
        'project_id' => $project['project_id'],
        'project_name' => $project['project_name']
    ];
}

echo json_encode($projects);
?>
