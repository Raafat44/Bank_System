<nav class="navbar navbar-expand-lg navbar-light bg-light">
<div class="container-fluid">
<a class="navbar-brand">BANKY.eg Bank</a>
<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse " id="navbarSupportedContent">
    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
    <li class="nav-item">
        <a class="nav-link <?php if($pageName == "DashBoard" || $pageName == "Add New User") {echo 'active';}?>" aria-current="page" href="../Admin/DashBoard.php">DashBoard</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php if($pageName == "Make Transmissions") {echo 'active';}?>" aria-current="page" href="../makeTransmission/AdminMake.php">Make Transmissions</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php if($pageName == "Recent Transmissions") {echo 'active';}?>" aria-current="page" href="../recentTransmission/AdminRecent.php">Recent Transmissions</a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle <?php if($pageName == "Edit MY Profile") {echo 'active';}?>" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php echo $_SESSION['FullName']  ?>
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
        <li><a class="dropdown-item" href="../editProfile/editMyProfile.php">Edit Profile</a></li>
        <li><a class="dropdown-item" href="../Sign/logout.php">Logout</a></li>
        <!-- Logout  Logs the user out and redirects to home -->
        </ul>
    </li>
    </ul>
</div>
</div>
</nav>