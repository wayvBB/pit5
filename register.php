<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="index.php">
    <link rel="stylesheet" href="style.css">
</head>

<body class="container">

    <nav>
        <h1>Acadify</h1>
    </nav>

    <div class="box">

        <div class="inner-box">
            <h1>Create Your Account</h1>
            <p>Already have an account? <a href="index.php" target="blank">Log in</a></p>

            <form class="registration" action="register.php" method="post">
                <label for="username">Username</label>
                <input type="text" class="form-input" name="username" placeholder="Username" required>

                <label for="email">Email</label>
                <input type="email" class="form-input" name="email" placeholder="Email" required>

                <label for="password">Password</label>
                <input type="password" class="form-input" name="password" placeholder="Password" required>

                <label for="confirm_password">Confirm Password</label>
                <input type="password" class="form-input" name="confirm_password" placeholder="Confirm Password" required>

                <label for="fullname">Full Name</label>
                <input type="text" class="form-input" name="fullname" placeholder="Full Name" required>

                <div class="button-container">
                    <button class="back-button" onclick="window.location.href='index.php'">Back</button>
                    <button class="register-button" type="submit">Register</button>
                </div>
            </form>
        </div>

        <!--php baks-->
        
        <?php
        
        require_once "includes/SQLConnect.php";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $username = $_POST["username"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $confirm_password = $_POST["confirm_password"];
            $fullname = $_POST["fullname"];

            //for hashing ni anteh
            $salt = bin2hex(random_bytes(16)); //random string for each users stored in the database
            $pepper = "ASecretPepperString"; //a secret value kept in the code to make the hash more secure

            $dataToHash = $password . $salt . $pepper;
            $hash = hash("sha256", $dataToHash);

            $errors = false;

            if (empty($username)) {
                $errors = true;
                echo "Username is required";
            }
            
            if (empty($email)) {
                $errors = true;
                echo "Email is required";
            }

            if (empty($password)) {
                $errors = true;
                echo "Password is required";
            }
            
            if (empty($confirm_password)) {
                $errors = true;
                echo "Confirm your Password!!!";
            }
            
            if ($password !== $confirm_password) {
                $errors = true;
                echo "Passwords do not match!";
            }
            
            if
                (empty($fullname)) {
                $errors = true;
                echo "Full Name is required";
            }

        //mo proceed na ani if walay errors
        if (!$errors) {
            try {
                $query = "INSERT INTO users (username, email, password, fullname, salt) VALUES (?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($query);//prepared statement=pared with pdo; prevents sql injection attacks

                $stmt->execute([$username, $email, $hash, $fullname, $salt]);

                echo "Registration successful! You can now log in.";

                //stopping the connection
                $pdo = null;
                $stmt = null;

                header("Location: index.php");

                die();

            } catch (PDOException $e) {
                die("Query failed! " . $e->getMessage());
            }
        } else {
            echo "Please fill in all fields.";
        }

        }
        ?>
    
    </div>
    
</body>

</html>