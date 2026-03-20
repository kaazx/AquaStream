<?php
session_start();
require_once 'db.php';
require_once 'oauth_config.php';

// Step 1 — redirect user to Google
if (!isset($_GET['code'])) {
    $state = bin2hex(random_bytes(16));
    $_SESSION['oauth_state'] = $state;

    $params = http_build_query([
        'client_id'     => GOOGLE_CLIENT_ID,
        'redirect_uri'  => GOOGLE_REDIRECT_URI,
        'response_type' => 'code',
        'scope'         => 'openid email profile',
        'state'         => $state,
    ]);
    header('Location: https://accounts.google.com/o/oauth2/v2/auth?' . $params);
    exit;
}

// Step 2 — Google redirected back with ?code=
if (!isset($_GET['state']) || $_GET['state'] !== $_SESSION['oauth_state']) {
    die('Invalid state. Possible CSRF attack.');
}

// Exchange code for access token
$tokenRes = json_decode(file_get_contents('https://oauth2.googleapis.com/token', false,
    stream_context_create(['http' => [
        'method'  => 'POST',
        'header'  => 'Content-Type: application/x-www-form-urlencoded',
        'content' => http_build_query([
            'code'          => $_GET['code'],
            'client_id'     => GOOGLE_CLIENT_ID,
            'client_secret' => GOOGLE_CLIENT_SECRET,
            'redirect_uri'  => GOOGLE_REDIRECT_URI,
            'grant_type'    => 'authorization_code',
        ]),
    ]])
), true);

if (empty($tokenRes['access_token'])) {
    die('Failed to get access token from Google.');
}

// Fetch user profile
$profile = json_decode(file_get_contents(
    'https://www.googleapis.com/oauth2/v3/userinfo',
    false,
    stream_context_create(['http' => [
        'header' => 'Authorization: Bearer ' . $tokenRes['access_token'],
    ]])
), true);

$email     = $profile['email'];
$firstName = $profile['given_name']  ?? '';
$lastName  = $profile['family_name'] ?? '';

handleOAuthLogin($email, $firstName, $lastName);