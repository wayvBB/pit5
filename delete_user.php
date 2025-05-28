<?php
// Include database connection
require_once 'includes/SQLConnect.php';

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    if ($stmt->execute([$id])) {
        header("Location: accounts.php?message=User+deleted+successfully");
        exit;
    } else {
        echo "Error deleting user.";
    }
} else {
    echo "Invalid user ID.";
}
?>
