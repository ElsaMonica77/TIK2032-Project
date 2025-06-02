-- Create database
CREATE DATABASE IF NOT EXISTS portfolio_elsa CHARACTER SET utf8 COLLATE utf8_unicode_ci;

-- Use the database
USE portfolio_elsa;

-- Create contacts table
CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(200) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('unread', 'read', 'replied') DEFAULT 'unread',
    INDEX idx_created_at (created_at),
    INDEX idx_status (status),
    INDEX idx_email (email)
);

-- Sample data for testing
INSERT INTO contacts (name, email, subject, message) VALUES 
('Elsa', 'elsa@example.com', 'Test Subject', 'This is a test message.'),
('Monica', 'monica@example.com', 'Collaboration Inquiry', 'I would like to discuss a potential collaboration.')
ON DUPLICATE KEY UPDATE name = name;
