-- ============================================
-- NBK Travel Shuttle Booking Management System
-- Database Schema
-- ============================================

-- Create Database
CREATE DATABASE IF NOT EXISTS nbk_travel_shuttle CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE nbk_travel_shuttle;

-- ============================================
-- USERS TABLE - Authentication
-- ============================================
CREATE TABLE IF NOT EXISTS users (
    userId INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    passwordHash VARCHAR(255) NOT NULL,
    role ENUM('admin', 'driver', 'customer') NOT NULL DEFAULT 'customer',
    firstName VARCHAR(100) NOT NULL,
    lastName VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    phoneNumber VARCHAR(20),
    status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
    lastLoginAt DATETIME NULL,
    createdAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    updatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_username (username),
    INDEX idx_role (role),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- CUSTOMERS TABLE
-- ============================================
CREATE TABLE IF NOT EXISTS customers (
    customerId INT PRIMARY KEY AUTO_INCREMENT,
    fullName VARCHAR(100) NOT NULL,
    phoneNumber VARCHAR(20) NOT NULL,
    emailAddress VARCHAR(100),
    preferences VARCHAR(500),
    totalBookings INT DEFAULT 0,
    totalSpent DECIMAL(10, 2) DEFAULT 0.00,
    createdAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    updatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_phone (phoneNumber),
    INDEX idx_email (emailAddress),
    INDEX idx_created (createdAt)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- DRIVERS TABLE
-- ============================================
CREATE TABLE IF NOT EXISTS drivers (
    driverId INT PRIMARY KEY AUTO_INCREMENT,
    fullName VARCHAR(100) NOT NULL,
    licenceNumber VARCHAR(30) NOT NULL UNIQUE,
    phoneNumber VARCHAR(20) NOT NULL,
    emailAddress VARCHAR(100),
    status ENUM('available', 'on-trip', 'off-duty', 'inactive') DEFAULT 'available',
    totalTrips INT DEFAULT 0,
    totalHours DECIMAL(8, 2) DEFAULT 0.00,
    createdAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    updatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_status (status),
    INDEX idx_phone (phoneNumber),
    INDEX idx_licence (licenceNumber)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- VEHICLES TABLE
-- ============================================
CREATE TABLE IF NOT EXISTS vehicles (
    vehicleId INT PRIMARY KEY AUTO_INCREMENT,
    registrationNumber VARCHAR(20) NOT NULL UNIQUE,
    make VARCHAR(50),
    model VARCHAR(50),
    capacity INT DEFAULT 5,
    status ENUM('available', 'in-use', 'maintenance') DEFAULT 'available',
    lastServiceDate DATE NULL,
    maintenanceNotes VARCHAR(500),
    totalTrips INT DEFAULT 0,
    createdAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    updatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_status (status),
    INDEX idx_registration (registrationNumber)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- BOOKINGS TABLE
-- ============================================
CREATE TABLE IF NOT EXISTS bookings (
    bookingId INT PRIMARY KEY AUTO_INCREMENT,
    bookingReference VARCHAR(20) NOT NULL UNIQUE,
    customerId INT NOT NULL,
    driverId INT NULL,
    vehicleId INT NULL,
    pickupLocation VARCHAR(255) NOT NULL,
    dropoffLocation VARCHAR(255) NOT NULL,
    bookingDate DATETIME NOT NULL,
    passengers INT DEFAULT 1,
    status ENUM('pending', 'confirmed', 'completed', 'cancelled') DEFAULT 'pending',
    cancellationReason VARCHAR(500) NULL,
    fareAmount DECIMAL(10, 2) NOT NULL,
    notes VARCHAR(500),
    createdAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    updatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (customerId) REFERENCES customers(customerId) ON UPDATE CASCADE,
    FOREIGN KEY (driverId) REFERENCES drivers(driverId) ON UPDATE CASCADE ON DELETE SET NULL,
    FOREIGN KEY (vehicleId) REFERENCES vehicles(vehicleId) ON UPDATE CASCADE ON DELETE SET NULL,
    
    INDEX idx_status (status),
    INDEX idx_bookingDate (bookingDate),
    INDEX idx_customerId (customerId),
    INDEX idx_driverId (driverId),
    INDEX idx_vehicleId (vehicleId),
    INDEX idx_reference (bookingReference)
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
    actualStart DATETIME NULL,
    actualEnd DATETIME NULL,
    conflictFlag TINYINT(1) DEFAULT 0,
    createdAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    updatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (bookingId) REFERENCES bookings(bookingId) ON UPDATE CASCADE ON DELETE RESTRICT,
    FOREIGN KEY (driverId) REFERENCES drivers(driverId) ON UPDATE CASCADE,
    FOREIGN KEY (vehicleId) REFERENCES vehicles(vehicleId) ON UPDATE CASCADE,
    
    INDEX idx_driverId (driverId),
    INDEX idx_vehicleId (vehicleId),
    INDEX idx_scheduledStart (scheduledStart),
    INDEX idx_scheduledEnd (scheduledEnd)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- INVOICES TABLE
-- ============================================
CREATE TABLE IF NOT EXISTS invoices (
    invoiceId INT PRIMARY KEY AUTO_INCREMENT,
    invoiceNumber VARCHAR(30) NOT NULL UNIQUE,
    bookingId INT NOT NULL UNIQUE,
    customerId INT NOT NULL,
    invoiceDate DATETIME NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    taxAmount DECIMAL(10, 2) DEFAULT 0.00,
    totalAmount DECIMAL(10, 2) NOT NULL,
    pdfPath VARCHAR(255) NULL,
    status ENUM('draft', 'issued', 'paid', 'cancelled') DEFAULT 'issued',
    createdAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    updatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (bookingId) REFERENCES bookings(bookingId) ON UPDATE CASCADE ON DELETE RESTRICT,
    FOREIGN KEY (customerId) REFERENCES customers(customerId) ON UPDATE CASCADE,
    
    INDEX idx_bookingId (bookingId),
    INDEX idx_customerId (customerId),
    INDEX idx_invoiceNumber (invoiceNumber),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- NOTIFICATIONS TABLE
-- ============================================
CREATE TABLE IF NOT EXISTS notifications (
    notificationId INT PRIMARY KEY AUTO_INCREMENT,
    recipientType ENUM('customer', 'driver', 'admin') DEFAULT 'customer',
    recipientId INT NOT NULL,
    channel ENUM('sms', 'email', 'system') DEFAULT 'email',
    messageBody VARCHAR(500) NOT NULL,
    bookingReference VARCHAR(20) NULL,
    sentAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('logged', 'sent', 'failed') DEFAULT 'logged',
    createdAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_recipientId (recipientId),
    INDEX idx_sentAt (sentAt),
    INDEX idx_status (status),
    INDEX idx_channel (channel)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- AUDIT LOG TABLE
-- ============================================
CREATE TABLE IF NOT EXISTS auditLog (
    auditId INT PRIMARY KEY AUTO_INCREMENT,
    userId INT NULL,
    action VARCHAR(100) NOT NULL,
    tableName VARCHAR(50),
    recordId INT,
    oldValues JSON NULL,
    newValues JSON NULL,
    ipAddress VARCHAR(45),
    createdAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_userId (userId),
    INDEX idx_action (action),
    INDEX idx_created (createdAt)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

