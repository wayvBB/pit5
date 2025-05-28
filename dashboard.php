<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acadify</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="sidebar">
        <div class="top">
            <div class="logo">
                <i class="bx bx-home"></i>
                <span>Acadify</span>
            </div>
            <i class="bx bx-menu" id="btn"></i>
        </div>
        <div class="user">
            <a href="profile.php">
                <img src="img/Default_pfp.jpg" alt="User Profile" class="user-img">
            </a>

            <div>
            <p class="bold"><?php echo htmlspecialchars($_SESSION['username']); ?></p>
            <p>
                <?php
                    // Check the role and display accordingly
                    if ($_SESSION['role'] === 'admin') {
                        echo "Admin";
                    } else {
                        echo "Student";
                    }
                    ?>
                </p>

            </div>
        </div>
        
        <ul>
            <li>
                <a href="dashboard.php">
                    <i class="bx bxs-grid-alt"></i>
                    <span class="nav-items">Dashboard</span>    
                </a>
                <span class="tooltip">Dashboard</span>
            </li>

            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <li>
                <a href="accounts.php">
                    <i class="bx bxs-user-account"></i>
                    <span class="nav-items">Acccounts</span> 
                </a>
                <span class="tooltip">Acccounts</span>
            </li>
            <?php endif; ?>

            <li>
                <a href="dashboard.php">
                    <i class="bx bxs-graduation"></i>
                    <span class="nav-items">Student</span>    
                </a>
                <span class="tooltip">Student</span>
            </li>

            <li>
                <a href="dashboard.php">
                    <i class="bx bxs-notepad"></i>
                    <span class="nav-items">Enrollment</span>    
                </a>
                <span class="tooltip">Enrollment</span>
            </li>

            <li>
                <a href="index.php">
                    <i class="bx bxs-log-out"></i>
                    <span class="nav-items">Logout</span>
                </a>
                <span class="tooltip">Logout</span>
            </li>
        </ul>

    </div>

    <div class="main-content">
        <div class="d-container">
            <h1>Dashboard</h1>
        </div>
        
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <div class="for_accounts">
                <a href="accounts.php">
                    <i class="bx bxs-user-account"></i>
                    <span class="db-items">Acccounts</span> 
                </a>
            </div>
        <?php endif; ?>

        <div class="for_students">
            <a href="accounts.php">
                <i class="bx bxs-graduation"></i>
                <span class="db-items">Student</span> 
            </a>
        </div>

        <div class="for_enrollment">
            <a href="accounts.php">
                <i class="bx bxs-notepad"></i>
                <span class="db-items">Enrollment</span> 
            </a>
        </div>

    </div>

    <?php 
    
    require_once "includes/SQLConnect.php";
        

    ?>
        

</body>

<script>
   let btn = document.querySelector("#btn");
   let sidebar = document.querySelector(".sidebar");

   btn.onclick = function () {
        sidebar.classList.toggle("active");
   };
</script>

</html>