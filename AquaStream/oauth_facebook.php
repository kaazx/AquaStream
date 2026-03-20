<?php
session_start();
require_once 'db.php';
require_once 'oauth_config.php';

// Step 1 — redirect user to Facebook
if (!isset($_GET['code'])) {
    $state = bin2hex(random_bytes(16));
    $_SESSION['oauth_state'] = $state;

    $params = http_build_query([
        'client_id'     => FB_APP_ID,
        'redirect_uri'  => FB_REDIRECT_URI,
        'state'         => $state,
        'scope'         => 'email,public_profile',
    ]);
    header('Location: https://www.facebook.com/v19.0/dialog/oauth?' . $params);
    exit;
}

// Step 2 — Facebook redirected back with ?code=
if (!isset($_GET['state']) || $_GET['state'] !== $_SESSION['oauth_state']) {
    die('Invalid state. Possible CSRF attack.');
}

// Exchange code for access token
$tokenRes = json_decode(file_get_contents(
    'https://graph.facebook.com/v19.0/oauth/access_token?' . http_build_query([
        'client_id'     => FB_APP_ID,
        'client_secret' => FB_APP_SECRET,
        'redirect_uri'  => FB_REDIRECT_URI,
        'code'          => $_GET['code'],
    ])
), true);

if (empty($tokenRes['access_token'])) {
    die('Failed to get access token from Facebook.');
}

// Fetch user profile
$profile = json_decode(file_get_contents(
    'https://graph.facebook.com/me?fields=email,first_name,last_name&access_token=' . $tokenRes['access_token']
), true);

$email     = $profile['email']      ?? '';
$firstName = $profile['first_name'] ?? '';
$lastName  = $profile['last_name']  ?? '';

if (empty($email)) {
    die('Could not retrieve email from Facebook. Please ensure email permission is granted.');
}

handleOAuthLogin($email, $firstName, $lastName);