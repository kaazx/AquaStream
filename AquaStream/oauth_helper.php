<?php
session_start();
require_once 'db.php';

function handleOAuthLogin(string $email, string $firstName, string $lastName): void {
    $conn = connectMaster();

    // Check if user already exists
    $stmt = $conn->prepare("SELECT id, user_db FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($userId, $userDb);
    $stmt->fetch();
    $stmt->close();

    if ($userId) {
        // Existing user — log them in
        $_SESSION['user_id'] = $userId;
        $_SESSION['user_db'] = $userDb;
        $conn->close();
        header('Location: dashboard.php');
        exit;
    }

    // New user — auto-register them
    $safeName = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $firstName . '_' . $lastName));
    $suffix   = substr(uniqid(), -4);
    $userDb   = 'aquastream_' . $safeName . '_' . $suffix;

    // No password for OAuth users (store NULL)
    $stmt = $conn->prepare(
        "INSERT INTO users (first_name, last_name, email, password, user_db) VALUES (?, ?, ?, NULL, ?)"
    );
    $stmt->bind_param("ssss", $firstName, $lastName, $email, $userDb);

    if (!$stmt->execute()) {
        die('Could not create your account. Please try again.');
    }

    $newUserId = $conn->insert_id;
    $stmt->close();

    // Create their personal database + tables (same as signup.php)
    $conn->query("CREATE DATABASE `$userDb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
    $conn->select_db($userDb);

    $conn->multi_query("
        CREATE TABLE `customers` (
            `CustomerID` int(11) NOT NULL AUTO_INCREMENT,
            `Name` varchar(255) NOT NULL,
            `Address` text NOT NULL,
            PRIMARY KEY (`CustomerID`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

        CREATE TABLE `products` (
            `ProductID` int(11) NOT NULL AUTO_INCREMENT,
            `ProductName` varchar(100) NOT NULL,
            `CurrentPrice` decimal(10,2) NOT NULL CHECK (`CurrentPrice` > 0),
            PRIMARY KEY (`ProductID`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

        CREATE TABLE `orders` (
            `OrderID` int(11) NOT NULL AUTO_INCREMENT,
            `CustomerID` int(11) DEFAULT NULL,
            `ProductID` int(11) DEFAULT NULL,
            `OrderDate` date DEFAULT curdate(),
            `DeliveryDate` date DEFAULT NULL,
            `Quantity` int(11) NOT NULL,
            `UnitPrice` decimal(10,2) NOT NULL CHECK (`UnitPrice` > 0),
            `TotalAmount` decimal(10,2) GENERATED ALWAYS AS (`Quantity` * `UnitPrice`) STORED,
            `ModeOfPayment` varchar(20) NOT NULL,
            `OrderStatus` varchar(20) DEFAULT 'Pending',
            `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
            `UpdatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (`OrderID`),
            FOREIGN KEY (`CustomerID`) REFERENCES `customers`(`CustomerID`),
            FOREIGN KEY (`ProductID`) REFERENCES `products`(`ProductID`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ");
    while ($conn->more_results() && $conn->next_result()) {}
    $conn->query("INSERT INTO `products` (`ProductName`, `CurrentPrice`) VALUES ('Gallon of Water', 25.00)");

    $conn->close();

    $_SESSION['user_id'] = $newUserId;
    $_SESSION['user_db'] = $userDb;
    header('Location: dashboard.php');
    exit;
}