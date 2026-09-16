USE assistance_request_system;

-- Import database.sql first, then replace the password hash if desired.
INSERT INTO users (username, password, full_name)
VALUES ('admin', '$2y$10$UN0x/JC3PcNREth/iQSYy.PtQ8YqYDt2caL2ix8W5fHtc6HMSEvXy', 'System Administrator')
ON DUPLICATE KEY UPDATE username = username;

INSERT INTO requests (request_id, full_name, address, barangay, contact_number, date_of_visit, purpose, assistance_type, amount_requested, remarks, status)
VALUES
('REQ-2026-0001', 'Maria Santos', '12 Mabini Street', 'Barangay Poblacion', '09171234567', '2026-09-01', 'Support for household food and utility expenses.', 'Financial Assistance', 5000.00, 'Bring valid identification on follow-up.', 'Pending'),
('REQ-2026-0002', 'Juan Dela Cruz', '45 Rizal Avenue', 'Barangay San Isidro', '09181234567', '2026-09-02', 'Help with hospital and medicine expenses.', 'Medical Assistance', 8500.00, 'Medical documents submitted.', 'Approved'),
('REQ-2026-0003', 'Ana Reyes', '8 Bonifacio Road', 'Barangay Mabini', '09191234567', '2026-09-03', 'School supplies and enrollment support.', 'Educational Assistance', 3000.00, 'Completed through education desk.', 'Completed'),
('REQ-2026-0004', 'Pedro Garcia', '77 Luna Street', 'Barangay Maligaya', '09201234567', '2026-09-04', 'Request for community event support.', 'Solicitation', 2500.00, 'For review by the community committee.', 'Pending'),
('REQ-2026-0005', 'Liza Navarro', '19 Quezon Street', 'Barangay San Roque', '09211234567', '2026-09-05', 'Emergency transportation assistance.', 'Other', 1800.00, 'Urgent request.', 'Rejected')
ON DUPLICATE KEY UPDATE request_id = request_id;
