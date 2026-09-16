<?php
// Shared helper functions used across the application.
// These keep common tasks simple and easy for students to follow.

function e($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

// Redirect to another page and stop the current script.
function redirect($location) {
    header('Location: ' . $location);
    exit;
}

// Create a CSRF token for form protection.
function csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

// Check that the form token matches the session value.
function verify_csrf() {
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'])) {
        http_response_code(403);
        exit('Invalid form token. Please go back and try again.');
    }
}

// Show the right CSS class for each request status.
function status_class($status) {
    $classes = array(
        'Pending' => 'status-pending',
        'Approved' => 'status-approved',
        'Completed' => 'status-completed',
        'Rejected' => 'status-rejected'
    );

    return $classes[$status] ?? 'status-pending';
}

// Format the amount as money with 2 decimal places.
function format_amount($amount) {
    return number_format((float) $amount, 2);
}

// Available color themes for the settings page.
function theme_options() {
    return array(
        'green' => 'Green',
        'blue' => 'Blue',
        'purple' => 'Purple',
        'orange' => 'Orange',
        'red' => 'Red',
        'teal' => 'Teal',
        'dark' => 'Dark'
    );
}

// Keep theme names safe and valid before using them in the app.
function normalize_theme($theme) {
    $theme = strtolower(trim((string) $theme));

    return array_key_exists($theme, theme_options()) ? $theme : 'green';
}

// Get the currently selected user theme.
function current_theme() {
    return normalize_theme($_SESSION['theme'] ?? 'green');
}
?>
