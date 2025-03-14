CREATE DATABASE IF NOT EXISTS login_system
                DEFAULT CHARACTER SET utf8mb4 
                COLLATE utf8mb4_general_ci


USE login_system;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    group_class VARCHAR(50),
    verified TINYINT(1) DEFAULT 0,
    token VARCHAR(255)
);