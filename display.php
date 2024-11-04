<?php
include 'connect.php';
include('authentication.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Operation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <main class="d-flex g-2">
        <?php include('components/sidebar.php') ?>      
                <div class="flex-grow-1 p-4">
                    <div class="d-flex flex-wrap justify-content-center mx-lg-5">
                        <button class="m-lg-3 btn btn-primary" style="margin-right: 40px;">
                            <a class="nav-link text-light" href="user.php">Add User</a>
                        </button>
                        <!-- <button class="m-lg-3 btn btn-secondary" style="margin-left: 30px;">
                            <a class="nav-link text-light" href="logout.php" onclick="return confirmLogout()">Logout</a>
                        </button> -->
                    </div>

                    <table class="table table-bordered my-5 border mx-auto rounded table-light">
                        <thead>
                            <tr>
                                <th scope="col">SI.no</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Username</th>
                                <th scope="col">Email</th>
                                <th scope="col">Mobile</th>
                                <th scope="col">Operation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM `crud`";
                            $result = mysqli_query($con, $sql);

                            if ($result) {
                                $si_no = 1;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $id = $row['id'];
                                    $firstname = isset($row['first_name']) ? $row['first_name'] : 'N/A';
                                    $lastname = isset($row['last_name']) ? $row['last_name'] : 'N/A';
                                    $username = $row['username'];
                                    $email = $row['email'];
                                    $mobile = $row['mobile'];

                                    echo '<tr>
                        <th scope="row">' . $si_no . '</th>
                        <td>' . $firstname . '</td>
                        <td>' . $lastname . '</td>
                        <td>' . $username . '</td>
                        <td>' . $email . '</td>
                        <td>' . $mobile . '</td>
                        <td>
                            <button class="btn btn-primary">
                                <a href="update.php?updateid=' . $id . '" class="text-light">Update</a>
                            </button>
                            <button class="btn btn-danger" onclick="confirmDelete(' . $id . ')">
                                Delete
                            </button>
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
    <!-- <footer class="bg-light text-center text-lg-start mt-auto py-3">
        <div class="container">
            <div class="text-center">
                <span class="text-muted">© 2024 Your Company. All Rights Reserved.</span>
            </div>
            <div class="d-flex justify-content-center mt-2">
                <a href="#" class="me-3 text-muted">Privacy Policy</a>
                <a href="#" class="me-3 text-muted">Terms of Service</a>
                <a href="#" class="text-muted">Contact Us</a>
            </div>
        </div>
    </footer> -->
   
    <script>
        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this record?")) {
                window.location.href = "delete.php?deleteid=" + id;
            } else {
                return false;
            }
        }
    //     function confirmLogout() {
    // return confirm("Are you sure you want to logout?");
// }
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-COUVpBL9i5aOVP/59LG90u7IPU5QH+0y8i/mEo+uRuC1yPj0k84hZ7G8/2CZmB4Z"
        crossorigin="anonymous"></script>
</body>

</html>