-- Create database
CREATE DATABASE IF NOT EXISTS famjisbank;
USE famjisbank;

-- Users table (with weak password storage)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL, -- Stored in plaintext/weak hash
    email VARCHAR(100) NOT NULL,
    account_number VARCHAR(20) NOT NULL UNIQUE,
    balance DECIMAL(15,2) DEFAULT 1000.00,
    is_admin BOOLEAN DEFAULT FALSE,
    profile_pic VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Transactions table
CREATE TABLE transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    from_user VARCHAR(20) NOT NULL,
    to_user VARCHAR(20) NOT NULL,
    amount DECIMAL(15,2) NOT NULL,
    description TEXT,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert admin user (weak credentials)
INSERT INTO users (username, password, email, account_number, is_admin)
VALUES ('admin', '5f4dcc3b5aa765d61d8327deb882cf99', 'admin@famjisbank.com', '00000001', TRUE);

-- Insert regular user
INSERT INTO users (username, password, email, account_number)
VALUES ('john_doe', '5f4dcc3b5aa765d61d8327deb882cf99', 'john@example.com', '10000001');

-- Sample transactions
INSERT INTO transactions (from_user, to_user, amount, description)
VALUES 
('00000001', '10000001', 500.00, 'Initial deposit'),
('10000001', '00000001', 100.00, 'Monthly fee');