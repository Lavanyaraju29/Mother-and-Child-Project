-- Create Database
CREATE DATABASE IF NOT EXISTS HospitalManagementSystem;

-- Use Database
USE HospitalManagementSystem;

-- Create Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE
);

INSERT INTO users (username, password, email) VALUES 
('testuser', '$2y$10$abcdefghijklmnopqrstuv', 'testuser@gmail.com');

CREATE TABLE BirthDetails (
    unique_id VARCHAR(10) PRIMARY KEY,
    child_name VARCHAR(100),
    child_weight FLOAT,
    hospital_name VARCHAR(100),
    location VARCHAR(100),
    birth_time TIME,
    birth_date DATE,
    email VARCHAR(100)
);

CREATE TABLE MedicalRecords (
    id INT AUTO_INCREMENT PRIMARY KEY,
    unique_id VARCHAR(50),
    doctor_name VARCHAR(100),
    diagnosis TEXT,
    treatment TEXT,
    prescription TEXT,
    FOREIGN KEY (unique_id) REFERENCES BirthDetails(unique_id) ON DELETE CASCADE
);

