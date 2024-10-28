<div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 250px; height:100vh">
    <a href="display.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <svg class="bi me-2" width="40" height="32">
            <use xlink:href="#bootstrap" />
        </svg>
        <span class="fs-4">Admin Panel</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
    <li class="nav-item">
            <a href="dashboard.php" class="nav-link text-white" aria-current="page">Dashboard</a>
        </li>
        <li class="nav-item">
            <a href="displayemp.php" class="nav-link text-white" aria-current="page">Employee</a>
        </li>
        <!-- <li>
            <a href="project.php" class="nav-link text-white">
            Project
            </a>
        </li> -->
        <li>
            <a href="display_project.php" class="nav-link text-white">
             Project
            </a>
        </li>
        <li>
            <a href="logout.php" onclick="return confirmLogout()" class="nav-link text-white">
                Logout
            </a>
        </li>
        
    </ul>
</div>
<script>
      
        function confirmLogout() {
    return confirm("Are you sure you want to logout?");
}
    </script>