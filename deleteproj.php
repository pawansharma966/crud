<?php 

include 'connect.php';
if(isset($_GET['deleteid'])){
    $project_id=$_GET['deleteid'];
    // $id =$_GET['deleteid'];
    // $sql = "DELETE FROM `employee` WHERE id = $id";

    $sql = "DELETE FROM `project` WHERE project_id = $project_id";
    $result=mysqli_query($con,$sql);
    if($result){
        // echo "Deleted success";
        header('location:display_project.php');
    }else{
        die(mysqli_error($con));
    }
}
?>