<?php 
include 'connect.php';

if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];
    $sql = "DELETE FROM `employee` WHERE id = $id";

    $result = mysqli_query($con, $sql);
    if ($result) {
        header('Location: displayemp.php');
        exit;
    } else {
        die("Error deleting record: " . mysqli_error($con));
    }
}
?>
<!-- <?php
include 'connect.php';

if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];

    // Delete associated records in the `project` table first
    $deleteProjectQuery = "DELETE FROM `project` WHERE emp_id = $id";
    mysqli_query($con, $deleteProjectQuery);

    // Then delete the employee record
    $deleteEmployeeQuery = "DELETE FROM `employee` WHERE id = $id";
    $result = mysqli_query($con, $deleteEmployeeQuery);

    if ($result) {
        header('Location: displayemp.php');
    } else {
        die(mysqli_error($con));
    }
}
?> -->