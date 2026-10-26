CREATE DATABASE IF NOT EXISTS alliance_engineers
CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE alliance_engineers;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    username VARCHAR(80) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role VARCHAR(30) NOT NULL DEFAULT 'Engineer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_name VARCHAR(150) NOT NULL,
    building_name VARCHAR(150) DEFAULT '',
    location VARCHAR(255) DEFAULT '',
    engineer_name VARCHAR(150) DEFAULT '',
    inspection_date DATE NOT NULL,
    status VARCHAR(30) DEFAULT 'Draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS photos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    original_name VARCHAR(255) NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS defects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    photo_id INT NOT NULL,
    project_id INT NOT NULL,
    defect_type VARCHAR(150) NOT NULL,
    severity ENUM('High','Medium','Low') NOT NULL DEFAULT 'Low',
    possible_cause TEXT,
    risk_if_untreated TEXT,
    recommendation TEXT,
    suggested_timeline VARCHAR(100),
    engineer_status ENUM('Pending','Reviewed','Approved') DEFAULT 'Pending',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (photo_id) REFERENCES photos(id) ON DELETE CASCADE,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS boq_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    defect_id INT NULL,
    item_code VARCHAR(50) DEFAULT '',
    description VARCHAR(255) NOT NULL,
    quantity DECIMAL(12,2) NOT NULL DEFAULT 1,
    unit VARCHAR(30) NOT NULL DEFAULT 'Nos',
    rate DECIMAL(12,2) NOT NULL DEFAULT 0,
    amount DECIMAL(14,2) GENERATED ALWAYS AS (quantity * rate) STORED,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
    FOREIGN KEY (defect_id) REFERENCES defects(id) ON DELETE SET NULL
);

-- Demo login:
-- username: admin
-- password: admin123
-- Password hash generated for PHP password_hash('admin123', PASSWORD_DEFAULT)
INSERT INTO users (name, username, password_hash, role)
SELECT 'Demo Administrator', 'admin', '$2y$12$5gJ4aKe7Wo.GVbWb4oYxK.yOrlPPoT2kEc8akEqqfG/Us.VCwotp2', 'Administrator'
WHERE NOT EXISTS (SELECT 1 FROM users WHERE username='admin');

INSERT INTO projects (project_name, building_name, location, engineer_name, inspection_date, status)
SELECT 'Demo Society Inspection', 'Sunrise Heights', 'Mumbai', 'Demo Engineer', CURDATE(), 'Draft'
WHERE NOT EXISTS (SELECT 1 FROM projects WHERE project_name='Demo Society Inspection');
