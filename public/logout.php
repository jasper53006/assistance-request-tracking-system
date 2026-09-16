<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Logout | ARTS</title><link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"><link rel="stylesheet" href="css/style.css"><link rel="stylesheet" href="css/friendly.css"></head><body class="center-page"><div class="confirm-box"><div class="brand-mark"><i class="bi bi-box-arrow-right"></i></div><h1>Sign out?</h1><p>Are you sure you want to logout?</p><form method="post"><button class="btn btn-primary" type="submit">Logout</button><a class="btn btn-light" href="dashboard.php">Cancel</a></form></div></body></html>
