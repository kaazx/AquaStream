<?php
session_start();
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    if ($username === "Owner" && $password === "AquaStream123") {
        $_SESSION["user"] = $username;
        header("Location: Index.php");
        exit();
    } else {
        $message = "Invalid username or password!";
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
        <h2 class="welcome">Welcome!</h2>

        <?php if($message != ""): ?>
            <div class="error"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="POST">
            <label>Username</label>
            <input type="text" name="username" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <div class="forgot">
                <a href="#">Forgot Password?</a>
            </div>

            <button type="submit" class="btn-primary">Log In</button>

            <div class="signup-link">
                Don't you have an account?
                <a href="signup.php" class="btn-small">Sign Up</a>
            </div>
        </form>
    </div>

</div>

</body>
</html>
