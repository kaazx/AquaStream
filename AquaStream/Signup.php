<?php
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstName = htmlspecialchars($_POST["first_name"]);
    $lastName  = htmlspecialchars($_POST["last_name"]);
    $email     = htmlspecialchars($_POST["email"]);
    $password  = $_POST["password"];
    $confirm   = $_POST["confirm_password"];

    if ($password !== $confirm) {
        $message = "Passwords do not match!";
    } else {
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $message = "Account created successfully!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Sign Up - AquaStream</title>
<link rel="stylesheet" href="css/signup.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="icon" type="image/png" href="imgs/logo.png">
</head>
<body>

<div class="container">
    
    <div class="left-panel">
    <img src="imgs/login_img.jpg" alt="AquaStream">
    </div>

    <div class="right-panel">
        <h2>Create an Account</h2>
        <p class="login-link">Already have an account? <a href="login.php">Log in</a></p>

        <?php if($message != ""): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="row">
                <input type="text" name="first_name" placeholder="First Name" required>
                <input type="text" name="last_name" placeholder="Last Name" required>
            </div>

            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Create password" required>
            <input type="password" name="confirm_password" placeholder="Confirm password" required>

            <label class="terms">
                <input type="checkbox" required>
                I agree to the <a href="#">Terms & Conditions</a>
            </label>

            <button type="submit" class="btn-primary">Create account</button>

            <div class="divider"><span>Or register with</span></div>

            <div class="social-buttons">
                <button type="button" class="btn-google">
                    <img src="imgs/google-icon.png" alt='Google'>Google</button>
                <button type="button" class="btn-facebook">
                    <img src="imgs/facebook-icon.png" alt='Facebook'>Facebook</button>
            </div>
        </form>
    </div>

</div>

</body>
</html>
