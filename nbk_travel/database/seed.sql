-- ============================================
-- NBK Travel Shuttle System - Sample Data
-- ============================================

USE nbk_travel;

-- ============================================
-- DEMO DRIVERS (first, since users reference them)
-- ============================================
INSERT INTO drivers (fullName, licenceNumber, phoneNumber, status) VALUES
('James Wilson', 'SA-DL-001-2024', '+27 (0) 765 432 101', 'available'),
('Robert Taylor', 'SA-DL-002-2024', '+27 (0) 765 432 102', 'available'),
('Patricia Anderson', 'SA-DL-003-2024', '+27 (0) 765 432 103', 'available'),
('Christopher Thomas', 'SA-DL-004-2024', '+27 (0) 765 432 104', 'off-duty');

-- ============================================
-- DEMO USER ACCOUNTS
-- ============================================
INSERT INTO users (username, passwordHash, role, driverId) VALUES
('admin', '$2y$10$Y.rD.PZMqp0A5M7S8K3zC.0YPX3zVHJa7cN5qM8wL2xK9jV6hV0N2', 'admin', NULL),
('driver', '$2y$10$Y.rD.PZMqp0A5M7S8K3zC.0YPX3zVHJa7cN5qM8wL2xK9jV6hV0N2', 'driver', 1);

-- ============================================
-- DEMO CUSTOMERS
-- ============================================
INSERT INTO customers (fullName, phoneNumber, emailAddress, preferences) VALUES
('John Smith', '+27 (0) 123 456 001', 'john@email.com', 'Prefers afternoon trips'),
('Jane Johnson', '+27 (0) 123 456 002', 'jane@email.com', 'No preference'),
('Michael Brown', '+27 (0) 123 456 003', 'michael@email.com', 'Early morning trips'),
('Sarah Williams', '+27 (0) 123 456 004', 'sarah@email.com', 'Wheelchair accessible'),
('David Miller', '+27 (0) 123 456 005', 'david@email.com', NULL);

-- ============================================
-- DEMO VEHICLES
-- ============================================
INSERT INTO vehicles (registrationNumber, make, model, capacity, status) VALUES
('JHB-001-A', 'Toyota', 'Hiace', 14, 'available'),
('JHB-002-B', 'Ford', 'Transit', 15, 'available'),
('JHB-003-C', 'Mercedes', 'Sprinter', 12, 'maintenance'),
('JHB-004-D', 'Toyota', 'Quantum', 16, 'available'),
('JHB-005-E', 'Iveco', 'Daily', 14, 'available');

-- ============================================
-- DEMO BOOKINGS
-- ============================================
INSERT INTO bookings (customerId, driverId, vehicleId, pickupLocation, dropoffLocation, bookingDate, passengers, fareAmount, status) VALUES
(1, 1, 1, 'O.R. Tambo Airport', 'Sandton City', '2026-05-15 08:00:00', 4, 150.00, 'completed'),
(2, 2, 2, 'Johannesburg CBD', 'Pretoria', '2026-05-15 14:00:00', 6, 200.00, 'completed'),
(3, 1, 1, 'Melville', 'Midrand', '2026-05-16 09:30:00', 3, 120.00, 'confirmed'),
(4, NULL, NULL, 'Rosebank', 'Bryanston', '2026-05-17 10:00:00', 2, 100.00, 'pending'),
(5, 2, 2, 'Sandton', 'Fourways', '2026-05-18 07:00:00', 5, 180.00, 'pending');

-- ============================================
-- DEMO SCHEDULES
-- ============================================
INSERT INTO schedules (bookingId, driverId, vehicleId, scheduledStart, scheduledEnd, conflictFlag) VALUES
(1, 1, 1, '2026-05-15 08:00:00', '2026-05-15 09:00:00', 0),
(2, 2, 2, '2026-05-15 14:00:00', '2026-05-15 16:00:00', 0),
(3, 1, 1, '2026-05-16 09:30:00', '2026-05-16 11:00:00', 0);

-- ============================================
-- DEMO INVOICES
-- ============================================
INSERT INTO invoices (bookingId, customerId, invoiceDate, subtotal, taxAmount, totalAmount) VALUES
(1, 1, '2026-05-15 09:15:00', 150.00, 22.50, 172.50),
(2, 2, '2026-05-15 16:15:00', 200.00, 30.00, 230.00);

-- ============================================
-- DEMO NOTIFICATIONS
-- ============================================
INSERT INTO notifications (recipientType, recipientId, bookingId, channel, messageBody, status) VALUES
('customer', 1, 1, 'email', 'Booking confirmed for your trip from O.R. Tambo Airport to Sandton City on May 15, 2026 at 08:00', 'logged'),
('driver', 1, 1, 'sms', 'New trip assigned: Pick up from O.R. Tambo Airport on May 15 at 08:00', 'logged'),
('customer', 2, 2, 'email', 'Booking confirmed for your trip from Johannesburg CBD to Pretoria on May 15, 2026 at 14:00', 'logged'),
('customer', 1, 1, 'email', 'Invoice generated for your completed trip. Amount: $172.50', 'logged');

