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

            <?php if (isset($_SESSION['username']) && $_SESSION['username'] === 'wayvBB'): ?>
            <li>
                <a href="accounts.php">
                    <i class="bx bxs-user-account"></i>
                    <span class="nav-items">Acccounts</span> 
                </a>
                <span class="tooltip">Acccounts</span>
            </li>
            <?php endif; ?>

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
            <h1>Profile</h1>
        </div>

        <?php
        require_once "includes/SQLConnect.php";

        // Make sure user is logged in
        if (!isset($_SESSION['username'])) {
            header("Location: login.php");
            exit();
        }
        
        $username = $_SESSION['username'];
        
        $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        // checks if the logged in user is found in the admin table for roles
        if ($user) {
            $role = 'admin';
        } else {
        // pag dli, sa users table
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $role = 'student';
        }
        
        ?>

        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($user)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['id']); ?></td>
                        <td><?php echo htmlspecialchars($user['fullname']); ?></td>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td>
                            <a href="edit_profile.php?id=<?php echo $user['id']; ?>">Edit</a> |
                            <a href="delete_user.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                        </td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No users found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>        

    </div>

</body>

<script>
   let btn = document.querySelector("#btn");
   let sidebar = document.querySelector(".sidebar");

   btn.onclick = function () {
        sidebar.classList.toggle("active");
   };
</script>

</html> 