<?php
// ============================================================
// db.php — Central Database Configuration
// ============================================================
// This file holds your master database credentials in one place.
// Every other file includes this instead of repeating the same
// connection code over and over.
//
// IMPORTANT: The MySQL user (root here) must have the privilege
// to CREATE DATABASES. In a local XAMPP/WAMP setup, root already
// has this. On a live server, ask your host to grant it.
// ============================================================

define('DB_HOST', 'localhost');
define('DB_USER', 'root');       // ← Change this on a live server
define('DB_PASS', '');           // ← Change this on a live server
define('MASTER_DB', 'aquastream_master'); // The one shared database

// ============================================================
// connectMaster()
// Returns a connection to the master database (used for login
// and signup — where all user accounts are stored).
// ============================================================
function connectMaster() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, MASTER_DB);

    if ($conn->connect_error) {
        die("Master DB connection failed: " . $conn->connect_error);
    }

    return $conn;
}

// ============================================================
// connectUserDB()
// Returns a connection to the currently logged-in user's own
// database. The database name is stored in the session after
// login (e.g., "aquastream_john_doe").
// ============================================================
function connectUserDB() {
    // Only start session if it hasn't been started yet
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // If there's no session, the user is not logged in.
    // Send them back to the login page.
    if (empty($_SESSION['user_db'])) {
        header("Location: Login.php");
        exit();
    }

    $userDb = $_SESSION['user_db'];
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, $userDb);

    if ($conn->connect_error) {
        die("User DB connection failed: " . $conn->connect_error);
    }

    return $conn;
}