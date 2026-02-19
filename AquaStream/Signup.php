<?php

require_once 'db.php';

$message     = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = trim(htmlspecialchars($_POST["first_name"]));
    $lastName  = trim(htmlspecialchars($_POST["last_name"]));
    $email     = trim(htmlspecialchars($_POST["email"]));
    $password  = $_POST["password"];
    $confirm   = $_POST["confirm_password"];

    if ($password !== $confirm) {
        $message     = "Passwords do not match!";
        $messageType = "error";

    } elseif (strlen($password) < 6) {
        $message     = "Password must be at least 6 characters.";
        $messageType = "error";

    } else {
        $conn = connectMaster();

        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $message     = "An account with that email already exists.";
            $messageType = "error";
            $stmt->close();

        } else {
            $stmt->close();

            $safeName = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $firstName . '_' . $lastName));
            $suffix   = substr(uniqid(), -4);
            $userDb   = 'aquastream_' . $safeName . '_' . $suffix;

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare(
                "INSERT INTO users (first_name, last_name, email, password, user_db)
                 VALUES (?, ?, ?, ?, ?)"
            );
            $stmt->bind_param("sssss", $firstName, $lastName, $email, $hashedPassword, $userDb);

            if (!$stmt->execute()) {
                $message     = "Error saving your account. Please try again.";
                $messageType = "error";
                $stmt->close();
                $conn->close();

            } else {
                $stmt->close();

                if (!$conn->query("CREATE DATABASE `$userDb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci")) {
                    $message     = "Account saved but we couldn't create your database. Contact support.";
                    $messageType = "error";

                } else {
                    $conn->select_db($userDb);

                    $createOrdersTable = "
                        CREATE TABLE `orders` (
                            `id`               INT(11)      NOT NULL AUTO_INCREMENT,
                            `customer_name`    VARCHAR(255) DEFAULT NULL,
                            `customer_address` TEXT         DEFAULT NULL,
                            `quantity`         INT(11)      DEFAULT NULL,
                            `delivery_date`    DATE         DEFAULT NULL,
                            `payment_method`   VARCHAR(50)  DEFAULT NULL,
                            `order_status`     VARCHAR(50)  DEFAULT 'Pending',
                            `created_at`       TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
                            `updated_at`       TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                            PRIMARY KEY (`id`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
                    ";

                    if (!$conn->query($createOrdersTable)) {
                        $message     = "Database created but table setup failed. Contact support.";
                        $messageType = "error";
                    } else {
                        $message     = "Account created successfully! You can now log in.";
                        $messageType = "success";
                    }
                }

                $conn->close();
            }
        }
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
        <p class="login-link">Already have an account? <a href="Login.php">Log in</a></p>

        <?php if ($message != ""): ?>
            <div class="message <?php echo $messageType; ?>">
                <?php echo $message; ?>
                <?php if ($messageType === "success"): ?>
                    <br><a href="Login.php">Click here to log in →</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="row">
                <input type="text"  name="first_name"       placeholder="First Name" required>
                <input type="text"  name="last_name"        placeholder="Last Name"  required>
            </div>

            <input type="email"    name="email"             placeholder="Email"            required>
            <input type="password" name="password"          placeholder="Create password"  required>
            <input type="password" name="confirm_password"  placeholder="Confirm password" required>

            <label class="terms">
                <input type="checkbox" required>
                I agree to the <a href="#">Terms & Conditions</a>
            </label>

            <button type="submit" class="btn-primary">Create account</button>

            <div class="divider"><span>Or register with</span></div>

            <div class="social-buttons">
                <button type="button" class="btn-google">
                    <img src="imgs/google-icon.png" alt="Google"> Google
                </button>
                <button type="button" class="btn-facebook">
                    <img src="imgs/facebook-icon.png" alt="Facebook"> Facebook
                </button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
