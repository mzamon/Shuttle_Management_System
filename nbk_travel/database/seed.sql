-- ============================================
-- NBK Travel Shuttle System - Sample Data
-- ============================================

USE nbk_travel_shuttle;

-- ============================================
-- DEMO USER ACCOUNTS
-- ============================================

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

