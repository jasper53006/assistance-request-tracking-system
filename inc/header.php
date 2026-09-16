<?php
require_once __DIR__ . '/functions.php';
$page_title = $page_title ?? 'Assistance Request Tracking System';
$active_page = $active_page ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($page_title); ?> | ARTS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/friendly.css">
</head>
<body class="theme-<?= e(current_theme()); ?>">
<div class="app-shell">
    <?php include __DIR__ . '/sidebar.php'; ?>
    <main class="main-content">
        <header class="topbar">
            <button class="mobile-menu" id="menuToggle" type="button" aria-label="Open navigation"><i class="bi bi-list"></i></button>
            <div>
                <p class="eyebrow">Community assistance desk</p>
                <h1><?= e($page_title); ?></h1>
            </div>
            <div class="user-chip"><span class="avatar"><?= e(strtoupper(substr($_SESSION['full_name'] ?? 'A', 0, 1))); ?></span><span><?= e($_SESSION['full_name'] ?? 'Administrator'); ?></span></div>
        </header>
        <div class="page-body">
