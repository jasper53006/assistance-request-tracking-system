<?php
// Start the session before checking user access.
session_start();
require_once __DIR__ . '/functions.php';

// Protect pages that should only be seen by logged-in users.
if (!isset($_SESSION['user_id'])) {
    redirect('login.php');
}

// Keep the theme value safe before it is used on page output.
$_SESSION['theme'] = normalize_theme($_SESSION['theme'] ?? 'green');
?>
