<?php

session_start();
require_once 'db.php';

if (!empty($_SESSION['user_db'])) {
    header("Location: index.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    $conn = connectMaster();

    $stmt = $conn->prepare("SELECT id, first_name, password, user_db FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    $conn->close();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id']    = $user['id'];
        $_SESSION['user_name']  = $user['first_name'];
        $_SESSION['user_db']    = $user['user_db'];

        header("Location: index.php");
        exit();
    } else {
        $message = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login - AquaStream</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/login.css">
<link rel="icon" type="image/png" href="imgs/logo.png">
</head>
<body>

<div class="container">

    <!-- LEFT SIDE -->
    <div class="left-panel">
        <div class="logo">
            <img src="imgs/login_img.jpg" alt="AquaStream Logo">
        </div>
    </div>

    <!-- RIGHT SIDE -->
    <div class="right-panel">
        <img src="imgs/logo.png" alt="AquaStream Logo" class="logo_login">
        <h2 class="welcome">Welcome!</h2>

        <?php if($message != ""): ?>
            <div class="error"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="POST">
            <label>Email</label>
            <input type="text" name="email" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <div class="forgot">
                <a href="#">Forgot Password?</a>
            </div>

            <button type="submit" class="btn-primary">Log In</button>

            <div class="signup-link">
                Don't you have an account?
                <a href="Signup.php" class="btn-small">Sign Up</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>
