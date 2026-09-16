<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../inc/functions.php';

if (isset($_SESSION['user_id'])) {
    redirect('dashboard.php');
}

$error = '';
$account_created = $_SESSION['account_created'] ?? '';
unset($_SESSION['account_created']);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $statement = $pdo->prepare('SELECT * FROM users WHERE username = ? LIMIT 1');
    $statement->execute(array($username));
    $user = $statement->fetch();

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['theme'] = normalize_theme($user['theme'] ?? 'green');
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        redirect('dashboard.php');
    }
    $error = 'The username or password is incorrect.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | ARTS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"><link rel="stylesheet" href="css/style.css"><link rel="stylesheet" href="css/friendly.css">
</head>
<body class="login-page">
    <section class="login-panel"><div class="login-brand"><span class="brand-mark"><i class="bi bi-heart-fill"></i></span><div><strong>ARTS</strong><small>Assistance Request Tracking System</small></div></div><div class="login-copy"><p class="eyebrow">Welcome back</p><h1>Serve every request with clarity.</h1><p>Record, review, and follow up on community assistance requests in one calm workspace.</p></div><div class="login-footer"><i class="bi bi-shield-check"></i> Secure staff access</div></section>
    <section class="login-form-wrap"><div class="login-form-card"><p class="eyebrow">Staff portal</p><h2>Sign in to your account</h2><p class="muted">Use your staff credentials to continue.</p><?php if ($account_created): ?><div class="alert alert-success"><i class="bi bi-check-circle"></i><?= e($account_created); ?></div><?php endif; ?><?php if ($error): ?><div class="alert alert-error"><i class="bi bi-exclamation-circle"></i><?= e($error); ?></div><?php endif; ?><form method="post"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()); ?>"><label for="username">Username</label><div class="input-icon"><i class="bi bi-person"></i><input id="username" name="username" required autocomplete="username"></div><label for="password">Password</label><div class="input-icon"><i class="bi bi-lock"></i><input id="password" name="password" type="password" required autocomplete="current-password"><button class="password-toggle" type="button" data-password-toggle="password" aria-label="Show password"><i class="bi bi-eye"></i></button></div><button class="btn btn-primary btn-full" type="submit">Sign In <i class="bi bi-arrow-right"></i></button></form><p class="login-hint"><a class="text-link" href="create_account.php">Create an account</a><br>Default local account: <strong>admin</strong> / <strong>password</strong></p></div></section>
<script src="js/script.js"></script></body></html>
