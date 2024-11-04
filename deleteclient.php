<?php 

include 'connect.php';
if(isset($_GET['deleteid'])){
    $id=$_GET['deleteid'];
 

    $sql = "DELETE FROM `client` WHERE id = $id";
    $result=mysqli_query($con,$sql);
    if($result){
        // echo "Deleted success";
        header('location:displayclient.php');
    }else{
        die(mysqli_error($con));
    }
}
?>