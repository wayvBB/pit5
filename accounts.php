<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: dashboard.php"); // Redirect if not logged in as 'wayvBB'
    exit();
}

require_once "includes/SQLConnect.php";

// Fetch data from the database
$stmt = $pdo->prepare("SELECT id, fullname, username, email FROM users");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if data exists in the array
if (!$users) {
    echo "No users found.";
}
?>

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
                <span>Accounts</span>
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
            <li>
                <a href="accounts.php">
                    <i class="bx bxs-user-account"></i>
                    <span class="nav-items">Acccounts</span> 
                </a>
                <span class="tooltip">Acccounts</span>
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
            <h1>Accounts</h1>
        </div>

        <div class="add_accounts">
            <button class="add-button" onclick="window.location.href='register.php'">Add Account</button>
        </div>

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
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['fullname']); ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td>
                                <a href="edit_user.php?id=<?php echo $user['id']; ?>">Edit</a> 
                                <a href="delete_user.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
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