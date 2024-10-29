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
    <div class="flex-grow-1 p-4">
        <div class="d-flex flex-wrap justify-content-center mx-lg-5">
            <button class="m-lg-3 btn btn-primary" style="margin-right: 40px;">
                <a class="nav-link text-light" href="employee.php">Add Employee</a>
            </button>
        </div>
        
        <div class="container my-5">
            <table class="table table-bordered table-striped w-75 mx-auto rounded table-hover">
                <thead class="text-center">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Mobile</th>
                        <th scope="col">Image</th>
                        <th scope="col">Operation</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM `employee`";
                    $result = mysqli_query($con, $sql);

                    if ($result) {
                        $si_no = 1;
                        while ($row = mysqli_fetch_assoc($result)) { 
                            $id = $row['id'];
                            $first_name = isset($row['emp_first_name']) ? $row['emp_first_name'] : 'N/A';
                            $last_name = isset($row['emp_last_name']) ? $row['emp_last_name'] : 'N/A';
                            $mobile = isset($row['emp_mobile']) ? $row['emp_mobile'] : 'N/A';
                            $imagePath = isset($row['file']) ? $row['file'] : '';

                            echo '<tr class="text-center">
                                <td>' . $si_no . '</td>
                                <td>' . htmlspecialchars($first_name) . '</td>
                                <td>' . htmlspecialchars($last_name) . '</td>
                                <td>' . htmlspecialchars($mobile) . '</td>
                                <td>';
                            
                            // Display the image if the path exists
                            if ($imagePath && file_exists($imagePath)) {
                                echo '<img src="' . htmlspecialchars($imagePath) . '" alt="Employee Image" style="width: 50px; height: 50px; object-fit: cover;">';
                            } else {
                                echo 'No Image';
                            }

                            echo '</td>
                                <td>
                                    <a href="updateemp.php?updateid=' . $id . '" class="btn btn-primary btn-sm me-2">Update</a>
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
            window.location.href = "deleteemp.php?deleteid=" + id;
        } else {
            return false;
        }
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
