-- ============================================
-- NBK Travel Shuttle Booking Management System
-- Database Schema - MVP Edition
-- ============================================

-- Create Database
CREATE DATABASE IF NOT EXISTS nbk_travel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE nbk_travel;

-- ============================================
-- USERS TABLE - Authentication
-- ============================================
CREATE TABLE IF NOT EXISTS users (
    userId INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    passwordHash VARCHAR(255) NOT NULL,
    role ENUM('admin','driver') NOT NULL,
    driverId INT NULL,
    createdAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (driverId) REFERENCES drivers(driverId) ON DELETE SET NULL,
    INDEX idx_username (username),
    INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- CUSTOMERS TABLE
-- ============================================
CREATE TABLE IF NOT EXISTS customers (
    customerId INT PRIMARY KEY AUTO_INCREMENT,
    fullName VARCHAR(100) NOT NULL,
    phoneNumber VARCHAR(20) NOT NULL UNIQUE,
    emailAddress VARCHAR(100),
    preferences VARCHAR(255),
    createdAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_phone (phoneNumber)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- DRIVERS TABLE
-- ============================================
CREATE TABLE IF NOT EXISTS drivers (
    driverId INT PRIMARY KEY AUTO_INCREMENT,
    fullName VARCHAR(100) NOT NULL,
    licenceNumber VARCHAR(30) NOT NULL UNIQUE,
    phoneNumber VARCHAR(20) NOT NULL,
    status ENUM('available','on-trip','off-duty') DEFAULT 'available',
    createdAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- VEHICLES TABLE
-- ============================================
CREATE TABLE IF NOT EXISTS vehicles (
    vehicleId INT PRIMARY KEY AUTO_INCREMENT,
    registrationNumber VARCHAR(20) NOT NULL UNIQUE,
    make VARCHAR(50) NOT NULL,
    model VARCHAR(50) NOT NULL,
    capacity INT NOT NULL,
    status ENUM('available','in-use','maintenance') DEFAULT 'available',
    createdAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- BOOKINGS TABLE
-- ============================================
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
    FOREIGN KEY (vehicleId) REFERENCES vehicles(vehicleId) ON DELETE SET NULL,
    
    INDEX idx_status (status),
    INDEX idx_bookingDate (bookingDate),
    INDEX idx_customerId (customerId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- SCHEDULES TABLE
-- ============================================
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
    FOREIGN KEY (vehicleId) REFERENCES vehicles(vehicleId) ON DELETE RESTRICT,
    
    INDEX idx_driverId (driverId),
    INDEX idx_vehicleId (vehicleId),
    INDEX idx_scheduledStart (scheduledStart)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- INVOICES TABLE
-- ============================================
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
    FOREIGN KEY (customerId) REFERENCES customers(customerId) ON DELETE RESTRICT,
    
    INDEX idx_bookingId (bookingId),
    INDEX idx_customerId (customerId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- NOTIFICATIONS TABLE
-- ============================================
CREATE TABLE IF NOT EXISTS notifications (
    notificationId INT PRIMARY KEY AUTO_INCREMENT,
    recipientType ENUM('customer','driver') NOT NULL,
    recipientId INT NOT NULL,
    bookingId INT NULL,
    channel ENUM('sms','email') NOT NULL,
    messageBody VARCHAR(500) NOT NULL,
    sentAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('logged','failed') DEFAULT 'logged',
    
    FOREIGN KEY (bookingId) REFERENCES bookings(bookingId) ON DELETE CASCADE,
    
    INDEX idx_recipientId (recipientId),
    INDEX idx_sentAt (sentAt)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- ROUTES TABLE (optional preset locations)
-- ============================================
CREATE TABLE IF NOT EXISTS routes (
    routeId INT PRIMARY KEY AUTO_INCREMENT,
    routeName VARCHAR(100) NOT NULL,
    pickupArea VARCHAR(100) NOT NULL,
    dropoffArea VARCHAR(100) NOT NULL,
    estimatedDuration INT,
    baseFare DECIMAL(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

