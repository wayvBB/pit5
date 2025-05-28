<?php
session_start();

// Only allow access if admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: dashboard.php"); // Redirect if not logged in as 'wayvBB'
    exit();
}

require_once "includes/SQLConnect.php";
echo "<p>Connected to DB: " . $pdo->query("SELECT DATABASE()")->fetchColumn() . "</p>";

// Redirect if no ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: accounts.php");
    exit();
}

$id = intval($_GET['id']);

// Fetch user data
$stmt = $pdo->prepare("SELECT id, fullname, username, email FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "User not found.";
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'] ?? '';
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';

    try {
        $update = $pdo->prepare("UPDATE users SET fullname = ?, username = ?, email = ? WHERE id = ?");
        $update->execute([$fullname, $username, $email, $id]);

        header("Location: accounts.php");
        exit();

    } catch (PDOException $e) {
        echo "<p style='color:red;'>Error: " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="main-content" style="padding: 2rem;">
    <h2>Edit User</h2>

    <form method="POST">
        <label>Full Name:</label><br>
        <input type="text" name="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>" required><br><br>

        <label>Username:</label><br>
        <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br><br>

        <button type="submit">Save Changes</button>
        <a href="accounts.php">Cancel</a>
    </form>
</div>

</body>
</html>
