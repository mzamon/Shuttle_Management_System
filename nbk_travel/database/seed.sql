-- ============================================
-- NBK Travel Shuttle System - Sample Data
-- ============================================

USE nbk_travel;

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
-- DEMO DRIVERS
-- ============================================
INSERT INTO drivers (fullName, licenceNumber, phoneNumber, status) VALUES
('James Wilson', 'SA-DL-001-2024', '+27 (0) 765 432 101', 'available'),
('Robert Taylor', 'SA-DL-002-2024', '+27 (0) 765 432 102', 'available'),
('Patricia Anderson', 'SA-DL-003-2024', '+27 (0) 765 432 103', 'available'),
('Christopher Thomas', 'SA-DL-004-2024', '+27 (0) 765 432 104', 'off-duty');

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

-- Admin User: admin / Admin@123
INSERT INTO users (username, passwordHash, role, firstName, lastName, email, phoneNumber, status) VALUES
('admin', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5ESLvjJg5nZDK', 'admin', 'Admin', 'User', 'admin@nbktravel.co.za', '+27114025555', 'active');

-- Driver User: john.driver / Driver@123
INSERT INTO users (username, passwordHash, role, firstName, lastName, email, phoneNumber, status) VALUES
('john.driver', '$2y$12$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36P4/TVm', 'driver', 'John', 'Driver', 'john@nbktravel.co.za', '+27821234567', 'active');

-- ============================================
-- SAMPLE CUSTOMERS
-- ============================================

INSERT INTO customers (fullName, phoneNumber, emailAddress, preferences) VALUES
('Sarah Johnson', '+27711234567', 'sarah.johnson@email.com', 'Window seat preferred, frequent business traveller'),
('Michael Chen', '+27821234567', 'michael.chen@email.com', 'Early morning pickups, reliable service'),
('Amara Okonkwo', '+27731234567', 'amara.okonkwo@email.com', 'Corporate account, invoice billing'),
('David Martinez', '+27741234567', 'david.martinez@email.com', 'Airport transfers weekly'),
('Linda Thompson', '+27751234567', 'linda.thompson@email.com', 'Wheelchair accessible vehicle');

-- ============================================
-- SAMPLE DRIVERS
-- ============================================

INSERT INTO drivers (fullName, licenceNumber, phoneNumber, emailAddress, status) VALUES
('John Smith', 'LIC001/2023', '+27821234567', 'john.smith@nbktravel.co.za', 'available'),
('Thabo Mkhize', 'LIC002/2023', '+27821234568', 'thabo.mkhize@nbktravel.co.za', 'available'),
('Patricia Ndlela', 'LIC003/2023', '+27821234569', 'patricia.ndlela@nbktravel.co.za', 'on-trip'),
('Marcus Williams', 'LIC004/2023', '+27821234570', 'marcus.williams@nbktravel.co.za', 'available'),
('Keziah Mapela', 'LIC005/2023', '+27821234571', 'keziah.mapela@nbktravel.co.za', 'off-duty');

-- ============================================
-- SAMPLE VEHICLES
-- ============================================

INSERT INTO vehicles (registrationNumber, make, model, capacity, status, lastServiceDate, maintenanceNotes) VALUES
('NBK-001-JHB', 'Toyota', 'Hiace', 13, 'available', '2026-04-15', 'Regular maintenance completed'),
('NBK-002-JHB', 'Mercedes', 'Sprinter', 15, 'available', '2026-04-10', 'New air filter installed'),
('NBK-003-JHB', 'Iveco', 'Daily', 10, 'in-use', '2026-03-20', 'Waiting for brake service'),
('NBK-004-JHB', 'Ford', 'Transit', 12, 'available', '2026-04-01', 'All systems operational'),
('NBK-005-JHB', 'Toyota', 'Hiace', 8, 'maintenance', '2026-02-28', 'Engine diagnostic in progress');

-- ============================================
-- SAMPLE BOOKINGS
-- ============================================

INSERT INTO bookings (bookingReference, customerId, driverId, vehicleId, pickupLocation, dropoffLocation, bookingDate, passengers, status, fareAmount) VALUES
('NBK-202600001', 1, 1, 1, 'OR Tambo International Airport', '15 Baker Street, Midrand', '2026-05-15 08:00:00', 3, 'confirmed', 385.00),
('NBK-202600002', 2, 2, 2, 'Sandton City Shopping Centre', 'Johannesburg General Hospital', '2026-05-15 09:30:00', 2, 'confirmed', 285.00),
('NBK-202600003', 3, 3, 3, 'Parktown Hotel', 'OR Tambo International Airport', '2026-05-15 10:00:00', 4, 'completed', 420.00),
('NBK-202600004', 4, 1, 1, 'Sunrise Business Park', 'Pretoria CBD', '2026-05-15 14:00:00', 1, 'pending', 325.00),
('NBK-202600005', 5, NULL, NULL, 'Jan Smuts Avenue', 'Fourways Mall', '2026-05-16 11:00:00', 2, 'pending', 285.00);

-- ============================================
-- SAMPLE SCHEDULES
-- ============================================

INSERT INTO schedules (bookingId, driverId, vehicleId, scheduledStart, scheduledEnd, conflictFlag) VALUES
(1, 1, 1, '2026-05-15 08:00:00', '2026-05-15 08:45:00', 0),
(2, 2, 2, '2026-05-15 09:30:00', '2026-05-15 10:15:00', 0),
(3, 3, 3, '2026-05-15 10:00:00', '2026-05-15 10:50:00', 0),
(4, 1, 1, '2026-05-15 14:00:00', '2026-05-15 14:45:00', 0);

-- ============================================
-- SAMPLE INVOICES
-- ============================================

INSERT INTO invoices (invoiceNumber, bookingId, customerId, invoiceDate, subtotal, taxAmount, totalAmount) VALUES
('INV-2026-0001', 3, 3, '2026-05-15 10:50:00', 420.00, 63.00, 483.00);

-- ============================================
-- SAMPLE NOTIFICATIONS
-- ============================================

INSERT INTO notifications (recipientType, recipientId, channel, messageBody, bookingReference, status) VALUES
('customer', 1, 'email', 'Your booking NBK-202600001 has been confirmed. Driver: John Smith. Vehicle: NBK-001-JHB', 'NBK-202600001', 'logged'),
('driver', 1, 'sms', 'Trip assigned: OR Tambo to Midrand. Pickup 08:00. Passenger: Sarah Johnson. +27711234567', 'NBK-202600001', 'logged'),
('customer', 3, 'email', 'Your trip has been completed. Invoice available. Amount: R483.00', 'NBK-202600003', 'logged'),
('driver', 3, 'sms', 'Trip completed: Parktown Hotel to OR Tambo. Time: 50 mins', 'NBK-202600003', 'logged');

