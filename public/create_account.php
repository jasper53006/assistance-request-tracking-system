<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../inc/functions.php';

if (isset($_SESSION['user_id'])) {
    redirect('dashboard.php');
}

$errors = array();
$full_name = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $full_name = trim($_POST['full_name'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if ($full_name === '') {
        $errors[] = 'Full name is required.';
    }
    if ($username === '' || strlen($username) < 4) {
        $errors[] = 'Username must be at least 4 characters.';
    }
    if (!preg_match('/^[A-Za-z0-9_.-]+$/', $username)) {
        $errors[] = 'Username may only contain letters, numbers, dots, underscores, and hyphens.';
    }
    if (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters.';
    }
    if ($password !== $confirm_password) {
        $errors[] = 'Passwords do not match.';
    }

    if (!$errors) {
        $check = $pdo->prepare('SELECT id FROM users WHERE username = ? LIMIT 1');
        $check->execute(array($username));
        if ($check->fetch()) {
            $errors[] = 'That username is already in use.';
        } else {
            $statement = $pdo->prepare('INSERT INTO users (username, password, full_name) VALUES (?, ?, ?)');
            $statement->execute(array($username, password_hash($password, PASSWORD_DEFAULT), $full_name));
            $_SESSION['account_created'] = 'Account created successfully. You can now sign in.';
            redirect('login.php');
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account | ARTS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"><link rel="stylesheet" href="css/style.css"><link rel="stylesheet" href="css/friendly.css">
</head>
<body class="login-page">
    <section class="login-panel"><div class="login-brand"><span class="brand-mark"><i class="bi bi-heart-fill"></i></span><div><strong>ARTS</strong><small>Assistance Request Tracking System</small></div></div><div class="login-copy"><p class="eyebrow">Staff access</p><h1>Create your workspace account.</h1><p>Set up a secure staff account to record and manage community assistance requests.</p></div><div class="login-footer"><i class="bi bi-shield-check"></i> Passwords are securely encrypted</div></section>
    <section class="login-form-wrap"><div class="login-form-card"><p class="eyebrow">New staff account</p><h2>Create an account</h2><p class="muted">Enter your details to get started.</p><?php if ($errors): ?><div class="alert alert-error"><i class="bi bi-exclamation-circle"></i><div><?= e(implode(' ', $errors)); ?></div></div><?php endif; ?><form method="post"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()); ?>"><label for="full_name">Full Name</label><div class="input-icon"><i class="bi bi-person-badge"></i><input id="full_name" name="full_name" value="<?= e($full_name); ?>" required autocomplete="name"></div><label for="username">Username</label><div class="input-icon"><i class="bi bi-person"></i><input id="username" name="username" value="<?= e($username); ?>" required autocomplete="username"></div><label for="password">Password</label><div class="input-icon"><i class="bi bi-lock"></i><input id="password" name="password" type="password" required autocomplete="new-password"><button class="password-toggle" type="button" data-password-toggle="password" aria-label="Show password"><i class="bi bi-eye"></i></button></div><label for="confirm_password">Confirm Password</label><div class="input-icon"><i class="bi bi-lock-fill"></i><input id="confirm_password" name="confirm_password" type="password" required autocomplete="new-password"><button class="password-toggle" type="button" data-password-toggle="confirm_password" aria-label="Show password"><i class="bi bi-eye"></i></button></div><button class="btn btn-primary btn-full" type="submit">Create Account <i class="bi bi-arrow-right"></i></button></form><p class="login-hint"><a class="text-link" href="login.php"><i class="bi bi-arrow-left"></i> Back to sign in</a></p></div></section>
<script src="js/script.js"></script></body></html>
