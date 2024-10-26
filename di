
<!-- <?php 
include 'connect.php';
?>
 <?php include ('authentication.php'); ?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud Operation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary ">
  <div class="container-fluid justify-content-between">
        <button class="btn btn-primary">
      <a href="user.php" class="text-light">Add User</a>
    </button>
     
        <button class="btn btn-secondary">
        <a href="logout.php" class="text-light">Logout</a>
      </button>
  </div>
</nav>


  <table class="table  table-bordered my-5 border w-75 mx-5 justify-content-center rounded table-light">
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
            <th scope="row">'.$si_no.'</th>
            <td>'.$firstname.'</td>
            <td>'.$lastname.'</td>
            <td>'.$username.'</td>
            <td>'.$email.'</td>
            <td>'.$mobile.'</td>
            <td>
              <button class="btn btn-primary">
                <a href="update.php?updateid='.$id.'" class="text-light">Update</a>
              </button>
              <button class="btn btn-danger" onclick="confirmDelete('.$id.')">
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

  <script>
    function confirmDelete(id) {
      if (confirm("Are you sure you want to delete this record?")) {
        window.location.href = "delete.php?deleteid=" + id;
      } else {
        return false;
      }
    }
  </script>

</body>
</html> -->



