<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acadify</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="container">

    <nav>
        <h1>Acadify</h1>
    </nav>

    <div class="box">

        <div class="inner-box">
            <h1>Welcome to Acadify</h1>
            <?php
            ?>
            <p>Log in or <a href="register.php" target="_blank">create an account</a></p>

            <div class="form-container">
                <form class="login" action="" method="post">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="index-form-input" name="username" placeholder="Username" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="index-form-input" name="password" placeholder="Password" required>
                    </div>

                    <div class="form-group remember-me">
                        <label>
                            <input type="checkbox" name="remember"> Remember Me
                        </label>
                    </div>

                    <div class="index-button-container">
                        <button class="login-button" type="submit">Login</button>
                        <button class="index-register-button" onclick="window.location.href='register.php'">Register</button>
                    </div>
                </form>
            </div>

        </div>

        <?php
            require_once "includes/SQLConnect.php";
            
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $username = $_POST['username'];
                $password = $_POST['password'];

                $pepper = "ASecretPepperString";

                // Retrieve admin from the database
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

                // Check if user exists
                if ($user) {
                    // Retrieve the salt stored in the database
                    $salt = $user['salt'];

                    // Concatenate password, salt, and pepper
                    $dataToHash = $password . $salt . $pepper;

                    // Hash the concatenated string
                    $hashedPassword = hash("sha256", $dataToHash);

                    // Compare the hashed password with the stored hash in the database
                    if ($hashedPassword === $user['password']) {

                        session_start();
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['role'] = $role;
                        
                        // Successful login
                        header("Location: dashboard.php");
                        exit();
                    } else {
                        // Invalid password
                        echo "Invalid username or password.";
                    }
                } else {
                    // User not found
                    echo "Invalid username or password.";
                }

            }

        ?>
        
    </div>
    
</body>

</html>