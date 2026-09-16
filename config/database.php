<?php
// Database connection for the whole application.
// This file is included in pages that need to read or save data.
$host = '127.0.0.1';
$dbname = 'assistance_request_system';
$username = 'root';
$password = '';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        )
    );

    // Older database versions may not have the theme column yet.
    // This keeps the appearance setting working without changing the app structure.
    $theme_column = $pdo->query(
        "SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'users' AND COLUMN_NAME = 'theme'"
    )->fetchColumn();

    if (!$theme_column) {
        $pdo->exec("ALTER TABLE users ADD COLUMN theme VARCHAR(20) NOT NULL DEFAULT 'green'");
    }
} catch (PDOException $error) {
    exit('Database connection failed. Please check that MySQL is running and the database exists.');
}
?>
