<?php

require_once 'db.php';
require_once 'oauth_helper.php';

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

                    $createTables = "
                        CREATE TABLE `customers` (
                            `CustomerID`      int(11)      NOT NULL AUTO_INCREMENT,
                            `CustomerName`    varchar(50)  NOT NULL,
                            `CustomerAddress` text         NOT NULL,
                            PRIMARY KEY (`CustomerID`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

                        CREATE TABLE `products` (
                            `ProductID`   int(11)        NOT NULL AUTO_INCREMENT,
                            `ProductName` varchar(50)    NOT NULL,
                            `UnitPrice`   decimal(10,2)  NOT NULL CHECK (`UnitPrice` > 0),
                            PRIMARY KEY (`ProductID`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

                        CREATE TABLE `ordersummary` (
                            `OrderID`       int(11)       NOT NULL AUTO_INCREMENT,
                            `OrderDate`     date          NOT NULL DEFAULT (curdate()),
                            `DeliveryDate`  date          DEFAULT NULL,
                            `ModeOfPayment` varchar(20)   NOT NULL,
                            `OrderStatus`   varchar(20)   NOT NULL DEFAULT 'Pending',
                            `TotalAmount`   decimal(10,2) NOT NULL DEFAULT 0.00,
                            `UpdatedAt`     timestamp     NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                            PRIMARY KEY (`OrderID`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

                        CREATE TABLE `orderdetails` (
                            `OrderDetailID` int(11) NOT NULL AUTO_INCREMENT,
                            `OrderID`       int(11) NOT NULL,
                            `CustomerID`    int(11) NOT NULL,
                            `ProductID`     int(11) NOT NULL,
                            `Quantity`      int(11) NOT NULL CHECK (`Quantity` > 0),
                            `UnitPrice`     decimal(10,2) NOT NULL,
                            `TotalAmount`   decimal(10,2) GENERATED ALWAYS AS (`Quantity` * `UnitPrice`) STORED,
                            PRIMARY KEY (`OrderDetailID`),
                            FOREIGN KEY (`OrderID`)    REFERENCES `ordersummary`(`OrderID`) ON DELETE CASCADE,
                            FOREIGN KEY (`CustomerID`) REFERENCES `customers`(`CustomerID`),
                            FOREIGN KEY (`ProductID`)  REFERENCES `products`(`ProductID`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
                    ";

                    if (!$conn->multi_query($createTables)) {
                        $message     = "Database created but table setup failed. Contact support.";
                        $messageType = "error";
                    } else {
                        while ($conn->more_results() && $conn->next_result()) {}

                        if (!$conn->query("INSERT INTO `products` (`ProductName`, `UnitPrice`) VALUES ('Gallon of Water', 25.00)")) {
                            $message     = "Tables created but default product could not be seeded. Contact support.";
                            $messageType = "error";
                        } else {
                            $message     = "Account created successfully! You can now log in.";
                            $messageType = "success";
                        }
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
                <!-- Google -->
                <a href="oauth_google.php" class="btn-google">
                    <img src="imgs/google-icon.png" alt="Google"> Google
                </a>

                <!-- Facebook -->
                <a href="oauth_facebook.php" class="btn-facebook">
                    <img src="imgs/facebook-icon.png" alt="Facebook"> Facebook
                </a>
            </div>
        </form>
    </div>
</div>
</body>
</html>
