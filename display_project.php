<?php 
include 'connect.php';
include ('authentication.php'); 
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
    <div class="flex-grow-1 p-4">
                    <div class="d-flex flex-wrap justify-content-center mx-lg-5">
                        <button class="m-lg-3 btn btn-primary" style="margin-right: 40px;">
                            <a class="nav-link text-light" href="project.php">Add Project</a>
                        </button>
                      
                    </div>
    <div class="container my-5">

        <table class="table table-bordered table-striped w-75 mx-auto rounded table-hover">
            <thead class=" text-center">
                <tr>
                    <th scope="col">Project ID</th>
                    <th scope="col">Project Name</th>
                    <th scope="col">Employee Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Operation</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM `project`
                JOIN employee ON project.emp_id = employee.id";
                $result = mysqli_query($con, $sql);

                if ($result) {
                    $si_no = 1;
                    while ($row = mysqli_fetch_assoc($result)) { 
                        $project_id = $row['project_id'];
                        $project_name = isset($row['project_name']) ? $row['project_name'] : 'N/A';  
                        $employee_name = $row['emp_first_name'] . " " . $row['emp_last_name'];    
                        $description = $row['description'];

                        echo '<tr class="text-center">
                            <td>' . $si_no . '</td>
                            <td>' . $project_name . '</td>
                            <td>' . $employee_name . '</td>
                            <td>' . $description . '</td>
                            <td>
                                <a href="updateproj.php?updateid=' . $project_id . '" class="btn btn-primary btn-sm me-2">Update</a>
                                <button class="btn btn-danger btn-sm" onclick="confirmDelete(' . $project_id . ')">Delete</button>
                            </td>
                        </tr>';
                        $si_no++;
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</main>

<script>
    function confirmDelete(id) {
        if (confirm("Are you sure you want to delete this record?")) {
            window.location.href = "deleteproj.php?deleteid=" + id;
        } else {
            return false;
        }
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
