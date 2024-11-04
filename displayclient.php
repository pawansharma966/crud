<?php
include 'connect.php';
include 'authentication.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Operation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <main class="d-flex g-2">
        <?php include('components/sidebar.php') ?>
        <div class="flex-grow-1 p-2">
            <div class="d-flex flex-wrap justify-content-center mx-lg-5">
                <button class="m-lg-3 btn btn-primary" style="margin-right: 40px;">
                    <a class="nav-link text-light" href="client.php">Client</a>
                </button>
            </div>

            <div class="container my-5">
                <table class="table table-bordered table-striped w-75 mx-auto rounded table-hover">
                    <thead class="text-center">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Mobile</th>
                            <th scope="col">Project(s)</th>
                            <th scope="col">Operation</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM `client`";
                        // -- JOIN project ON client.projects_id = client.projects_id";
                        
                        $result = mysqli_query($con, $sql);

                        if ($result) {
                            $si_no = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                $id = $row['id'];
                                $name = isset($row['name']) ? $row['name'] : 'N/A';
                                $email = isset($row['email']) ? $row['email'] : 'N/A';
                                $phone = isset($row['phone']) ? $row['phone'] : 'N/A';

                                $project_ids = explode(',', $row['projects_id']);
                                $project_names = [];

                                // Loop through each project ID and fetch the name from the `project` table
                                foreach ($project_ids as $project_id) {
                                    // Query to fetch the project name by ID
                                    $query = "SELECT project_name FROM project WHERE project_id = ?";
                                    $stmt = $con->prepare($query);
                                    $stmt->bind_param("i", $project_id);
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    if ($result->num_rows > 0) {
                                        $project = $result->fetch_assoc();
                                        $project_names[] = $project['project_name'];
                                    }
                                }

                                // Display each project name
                                echo '<tr class="text-center">
    <td>' . $si_no . '</td>
    <td>' . htmlspecialchars($name) . '</td>
    <td>' . htmlspecialchars($email) . '</td>
    <td>' . htmlspecialchars($phone) . '</td>
    <td>' . implode('<br>', array_map('htmlspecialchars', $project_names)) . '</td>
    <td>
        <a href="updateclient.php?updateid=' . $id . '" class="btn btn-primary btn-sm me-2">Update</a>
        <button class="btn btn-danger btn-sm" onclick="confirmDelete(' . $id . ')">Delete</button>
    </td>
</tr>';

                                $si_no++;

                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this record?")) {
                window.location.href = "deleteclient.php?deleteid=" + id;
            } else {
                return false;
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

-- JOIN project ON client.projects_id = client.projects_id";




// SQL query to get client data along with their associated projects
$sql = "SELECT client.id, client.name, client.email, client.phone,
GROUP_CONCAT(project.project_name SEPARATOR ', ') AS project_names
FROM client
LEFT JOIN project ON client.projects_id = project.project_id
GROUP BY client.id";