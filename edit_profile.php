<?php session_start(); ?>
<div class="main-content" style="padding: 2rem;">
    <h2>Edit Profile</h2>

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

        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullname = $_POST['fullname'] ?? '';
            $newUsername = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $id = $user['id'];
        
            try {
                if ($role === 'admin') {
                    $update = $pdo->prepare("UPDATE admin SET fullname = ?, username = ?, email = ? WHERE id = ?");
                } else {
                    $update = $pdo->prepare("UPDATE users SET fullname = ?, username = ?, email = ? WHERE id = ?");
                }
        
                $update->execute([$fullname, $newUsername, $email, $id]);
                $_SESSION['username'] = $newUsername;
        
                header("Location: dashboard.php");
                exit();
        
            } catch (PDOException $e) {
                echo "<p style='color:red;'>Error: " . $e->getMessage() . "</p>";
            }
        }
        
?>

    <form method="POST">
        <label>Full Name:</label><br>
        <input type="text" name="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>" required><br><br>

        <label>Username:</label><br>
        <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br><br>

        <button type="submit">Save Changes</button>
        <a href="profile.php">Cancel</a>
    </form>
</div>

</body>
</html>