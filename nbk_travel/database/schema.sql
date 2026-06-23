-- ============================================
-- NBK Travel Shuttle Booking Management System
-- Database Schema + Demo Data
-- ============================================

CREATE DATABASE IF NOT EXISTS nbk_travel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE nbk_travel;

-- DRIVERS
CREATE TABLE IF NOT EXISTS drivers (
    driverId INT PRIMARY KEY AUTO_INCREMENT,
    fullName VARCHAR(100) NOT NULL,
    licenceNumber VARCHAR(30) NOT NULL UNIQUE,
    phoneNumber VARCHAR(20) NOT NULL,
    status ENUM('available','on-trip','off-duty') DEFAULT 'available',
    createdAt DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- USERS
CREATE TABLE IF NOT EXISTS users (
    userId INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    passwordHash VARCHAR(255) NOT NULL,
    role ENUM('admin','driver') NOT NULL,
    driverId INT NULL,
    createdAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (driverId) REFERENCES drivers(driverId) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- CUSTOMERS
CREATE TABLE IF NOT EXISTS customers (
    customerId INT PRIMARY KEY AUTO_INCREMENT,
    fullName VARCHAR(100) NOT NULL,
    phoneNumber VARCHAR(20) NOT NULL UNIQUE,
    emailAddress VARCHAR(100),
    preferences VARCHAR(255),
    createdAt DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- VEHICLES
CREATE TABLE IF NOT EXISTS vehicles (
    vehicleId INT PRIMARY KEY AUTO_INCREMENT,
    registrationNumber VARCHAR(20) NOT NULL UNIQUE,
    make VARCHAR(50) NOT NULL,
    model VARCHAR(50) NOT NULL,
    capacity INT NOT NULL,
    status ENUM('available','in-use','maintenance') DEFAULT 'available',
    createdAt DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- BOOKINGS
CREATE TABLE IF NOT EXISTS bookings (
    bookingId INT PRIMARY KEY AUTO_INCREMENT,
    customerId INT NOT NULL,
    driverId INT NULL,
    vehicleId INT NULL,
    pickupLocation VARCHAR(100) NOT NULL,
    dropoffLocation VARCHAR(100) NOT NULL,
    bookingDate DATETIME NOT NULL,
    passengers INT NOT NULL,
    fareAmount DECIMAL(8,2) NOT NULL,
    status ENUM('pending','confirmed','completed','cancelled') DEFAULT 'pending',
    cancellationReason VARCHAR(255) NULL,
    createdAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customerId) REFERENCES customers(customerId) ON DELETE RESTRICT,
    FOREIGN KEY (driverId) REFERENCES drivers(driverId) ON DELETE SET NULL,
    FOREIGN KEY (vehicleId) REFERENCES vehicles(vehicleId) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- SCHEDULES
CREATE TABLE IF NOT EXISTS schedules (
    scheduleId INT PRIMARY KEY AUTO_INCREMENT,
    bookingId INT NOT NULL UNIQUE,
    driverId INT NOT NULL,
    vehicleId INT NOT NULL,
    scheduledStart DATETIME NOT NULL,
    scheduledEnd DATETIME NOT NULL,
    conflictFlag TINYINT(1) DEFAULT 0,
    createdAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (bookingId) REFERENCES bookings(bookingId) ON DELETE CASCADE,
    FOREIGN KEY (driverId) REFERENCES drivers(driverId) ON DELETE RESTRICT,
    FOREIGN KEY (vehicleId) REFERENCES vehicles(vehicleId) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- INVOICES
CREATE TABLE IF NOT EXISTS invoices (
    invoiceId INT PRIMARY KEY AUTO_INCREMENT,
    bookingId INT NOT NULL UNIQUE,
    customerId INT NOT NULL,
    invoiceDate DATETIME DEFAULT CURRENT_TIMESTAMP,
    subtotal DECIMAL(8,2) NOT NULL,
    taxAmount DECIMAL(8,2) NOT NULL,
    totalAmount DECIMAL(8,2) NOT NULL,
    pdfPath VARCHAR(255),
    FOREIGN KEY (bookingId) REFERENCES bookings(bookingId) ON DELETE CASCADE,
    FOREIGN KEY (customerId) REFERENCES customers(customerId) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- NOTIFICATIONS
CREATE TABLE IF NOT EXISTS notifications (
    notificationId INT PRIMARY KEY AUTO_INCREMENT,
    recipientType ENUM('customer','driver') NOT NULL,
    recipientId INT NOT NULL,
    bookingId INT NULL,
    channel ENUM('sms','email') NOT NULL,
    messageBody VARCHAR(500) NOT NULL,
    sentAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('logged','failed') DEFAULT 'logged',
    FOREIGN KEY (bookingId) REFERENCES bookings(bookingId) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- DEMO DATA
INSERT INTO drivers (fullName, licenceNumber, phoneNumber, status) VALUES
('James Wilson', 'SA-DL-001-2024', '+27 (0) 765 432 101', 'available'),
('Robert Taylor', 'SA-DL-002-2024', '+27 (0) 765 432 102', 'available');

INSERT INTO users (username, passwordHash, role, driverId) VALUES
('admin', '$2y$10$Y.rD.PZMqp0A5M7S8K3zC.0YPX3zVHJa7cN5qM8wL2xK9jV6hV0N2', 'admin', NULL),
('driver', '$2y$10$Y.rD.PZMqp0A5M7S8K3zC.0YPX3zVHJa7cN5qM8wL2xK9jV6hV0N2', 'driver', 1);

INSERT INTO customers (fullName, phoneNumber, emailAddress, preferences) VALUES
('John Smith', '+27 (0) 123 456 001', 'john@email.com', 'Prefers afternoon trips'),
('Jane Johnson', '+27 (0) 123 456 002', 'jane@email.com', 'No preference');

INSERT INTO vehicles (registrationNumber, make, model, capacity, status) VALUES
('JHB-001-A', 'Toyota', 'Hiace', 14, 'available'),
('JHB-002-B', 'Ford', 'Transit', 15, 'available');

INSERT INTO bookings (customerId, driverId, vehicleId, pickupLocation, dropoffLocation, bookingDate, passengers, fareAmount, status) VALUES
(1, 1, 1, 'O.R. Tambo Airport', 'Sandton City', '2026-05-15 08:00:00', 4, 150.00, 'completed'),
(2, 2, 2, 'Johannesburg CBD', 'Pretoria', '2026-05-15 14:00:00', 6, 200.00, 'completed');

INSERT INTO schedules (bookingId, driverId, vehicleId, scheduledStart, scheduledEnd) VALUES
(1, 1, 1, '2026-05-15 08:00:00', '2026-05-15 09:00:00'),
(2, 2, 2, '2026-05-15 14:00:00', '2026-05-15 16:00:00');

INSERT INTO invoices (bookingId, customerId, invoiceDate, subtotal, taxAmount, totalAmount) VALUES
(1, 1, '2026-05-15 09:15:00', 150.00, 22.50, 172.50),
(2, 2, '2026-05-15 16:15:00', 200.00, 30.00, 230.00);
