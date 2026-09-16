CREATE DATABASE IF NOT EXISTS assistance_request_system CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE assistance_request_system;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    theme VARCHAR(20) NOT NULL DEFAULT 'green',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    request_id VARCHAR(20) NOT NULL UNIQUE,
    full_name VARCHAR(120) NOT NULL,
    address VARCHAR(255) NOT NULL,
    barangay VARCHAR(100) NOT NULL,
    contact_number VARCHAR(30) NOT NULL,
    date_of_visit DATE NOT NULL,
    purpose TEXT NOT NULL,
    assistance_type VARCHAR(60) NOT NULL,
    amount_requested DECIMAL(12,2) NOT NULL DEFAULT 0,
    remarks TEXT,
    status ENUM('Pending', 'Approved', 'Completed', 'Rejected') NOT NULL DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS transaction_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    request_id INT NOT NULL,
    action VARCHAR(100) NOT NULL,
    previous_status VARCHAR(30),
    new_status VARCHAR(30),
    processed_by VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_history_request FOREIGN KEY (request_id) REFERENCES requests(id) ON DELETE CASCADE
);
