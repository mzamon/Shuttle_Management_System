# NBK Travel - Shuttle Booking Management System
## MVP Edition - Complete & Fully Functional

**Project Status:** ✅ COMPLETE - Ready for Testing

---

## 🎯 Quick Start Guide

### Prerequisites
- XAMPP/WAMP Server (PHP 8.0+, MySQL 5.7+)
- Local server running on `localhost`
- PHPMyAdmin access

### Installation Steps

#### 1. **Create Database**
1. Open PHPMyAdmin: `http://localhost/phpmyadmin`
2. Create new database: `nbk_travel`
3. Import schema: Go to "Import" tab → Select `/database/schema.sql`
4. Import seed data: Go to "Import" tab → Select `/database/seed.sql`

#### 2. **Configure Database Connection**
- Open `/includes/db.php`
- Verify credentials:
  ```php
  $servername = "localhost";
  $username = "root";
  $password = "";
  $database = "nbk_travel";
  ```

#### 3. **Start Application**
- Navigate to: `http://localhost/nbk_travel`
- Should redirect to login page

---

## 🔐 Demo Login Credentials

| Role | Username | Password |
|---|---|---|
| Admin | `admin` | `password` |
| Driver | `driver` | `password` |

---

## ✨ MVP Features - Fully Implemented

### ✅ Core Modules

#### 1. **Authentication & Authorization**
- ✅ Login/Logout with session management
- ✅ Role-based access control (Admin, Driver)
- ✅ Secure password hashing (bcrypt)
- ✅ Session guards on all pages

#### 2. **Dashboard**
- ✅ Real-time metric cards (Total Bookings, Customers, Today's Trips, Revenue)
- ✅ Recent bookings table with filters
- ✅ Quick action buttons
- ✅ Responsive design

#### 3. **Booking Management**
- ✅ Create new bookings with customer autocomplete
- ✅ View all bookings with status tracking
- ✅ Cancel bookings with reason logging
- ✅ Real-time status updates (pending → confirmed → completed → cancelled)
- ✅ Fare management
- ✅ Passenger count tracking

#### 4. **Schedule Management**
- ✅ Assign drivers to bookings
- ✅ Assign vehicles to bookings
- ✅ **Conflict Detection** - Prevents overlapping assignments
- ✅ Weekly schedule grid visualization
- ✅ Automatic status updates

#### 5. **Customer Management**
- ✅ Add/Edit customer profiles
- ✅ AJAX autocomplete search
- ✅ Duplicate phone number prevention
- ✅ Preferences tracking
- ✅ Booking history

#### 6. **Driver Management**
- ✅ Add new drivers
- ✅ Track driver status (available, on-trip, off-duty)
- ✅ Toggle status
- ✅ Auto-create user account for drivers
- ✅ License number tracking

#### 7. **Vehicle Management**
- ✅ Add vehicles to fleet
- ✅ Track vehicle status (available, in-use, maintenance)
- ✅ Capacity management
- ✅ Registration number tracking
- ✅ Toggle vehicle status

#### 8. **Reporting & Analytics**
- ✅ Trip Report with date-range filtering
- ✅ Revenue Report with calculations
- ✅ Top Customers ranking
- ✅ Booking Status Summary
- ✅ Chart.js visualization (Bar, Line, Doughnut charts)
- ✅ HTML table export
- ✅ PDF export (html2pdf.js)
- ✅ Print functionality

#### 9. **Invoice Generation**
- ✅ Select completed bookings
- ✅ Auto-calculate fare + 15% tax
- ✅ Professional invoice template
- ✅ PDF download with html2pdf.js
- ✅ Invoice storage to database
- ✅ Invoice history tracking

#### 10. **Notification System**
- ✅ Automatic booking confirmations (SMS/Email simulation)
- ✅ Trip assignment notifications
- ✅ Trip completion notifications
- ✅ Invoice generation notifications
- ✅ Notification log with filters
- ✅ Channel tracking (SMS, Email)

#### 11. **Driver Dashboard**
- ✅ Driver-only view (role-restricted)
- ✅ My Assigned Trips table
- ✅ "Mark Trip Complete" button
- ✅ Automatic status updates
- ✅ Personal information display
- ✅ Real-time trip list

---

## 🗂️ File Structure

```
nbk_travel/
├── index.php                   ← Login Page
├── dashboard.php               ← Admin Dashboard
├── logout.php                  ← Session Logout
├── bookings.php                ← Bookings Management
├── schedule.php                ← Driver/Vehicle Assignment
├── customers.php               ← Customer Records
├── drivers.php                 ← Driver Management
├── vehicles.php                ← Vehicle Management
├── reports.php                 ← Analytics & Reports
├── invoices.php                ← Invoice Generator
├── notifications.php           ← Notifications Log
├── driver-dashboard.php        ← Driver View
├── /api/
│   ├── auth.php                ← Authentication
│   ├── bookings.php            ← Bookings API
│   ├── schedule.php            ← Schedule API (Conflict Detection)
│   ├── customers.php           ← Customers API
│   ├── drivers.php             ← Drivers API
│   ├── vehicles.php            ← Vehicles API
│   ├── reports.php             ← Reports API
│   ├── invoices.php            ← Invoices API
│   └── notifications.php       ← Notifications API
├── /includes/
│   ├── db.php                  ← Database Connection
│   ├── auth_check.php          ← Session Guard
│   ├── header.php              ← Navigation Sidebar
│   └── footer.php              ← Page Footer
├── /assets/
│   ├── css/style.css           ← Global Styles (Dark Theme)
│   └── js/main.js              ← Global JavaScript Utilities
└── /database/
    ├── schema.sql              ← Database Schema
    └── seed.sql                ← Test Data
```

---

## 🎨 Design System

### Color Palette (Futuristic Dark Theme)
- **Primary Background:** `#0a0f1e`
- **Panel Background:** `#0d1b2e` / `#111d35`
- **Accent Color:** `#00d4ff` (Cyan)
- **Success:** `#2ed573` (Green)
- **Danger:** `#ff4757` (Red)
- **Warning:** `#ffa502` (Orange)
- **Text Primary:** `#ffffff`
- **Text Secondary:** `#8892a4`

### Typography
- **Font Family:** System-ui / Inter
- **Headings:** Bold, 28px (H1)
- **Body:** 14px

### Components
- **Buttons:** Accent color with hover glow effect
- **Cards:** Border 1px solid #1e3a5f, border-radius 12px
- **Tables:** Striped rows, hover effect
- **Status Badges:** Color-coded (pending, confirmed, completed, cancelled)
- **Modals:** Centered, backdrop blur, smooth animation

---

## 🔧 API Endpoints

### Authentication
- `POST /api/auth.php?action=login` - User login

### Bookings
- `POST /api/bookings.php?action=create` - Create booking
- `POST /api/bookings.php?action=cancel` - Cancel booking
- `GET /api/bookings.php?action=list` - Get all bookings

### Schedule
- `POST /api/schedule.php?action=assign` - Assign driver & vehicle (with conflict detection)
- `POST /api/schedule.php?action=complete` - Mark trip as completed
- `GET /api/schedule.php?action=list` - Get schedule for date range

### Customers
- `POST /api/customers.php?action=create` - Create customer
- `GET /api/customers.php?action=search` - Search customers (AJAX)
- `GET /api/customers.php?action=list` - Get all customers

### Drivers
- `POST /api/drivers.php?action=create` - Create driver
- `POST /api/drivers.php?action=toggle_status` - Toggle driver status
- `GET /api/drivers.php?action=list` - Get all drivers
- `GET /api/drivers.php?action=available` - Get available drivers only

### Vehicles
- `POST /api/vehicles.php?action=create` - Create vehicle
- `POST /api/vehicles.php?action=toggle_status` - Toggle vehicle status
- `GET /api/vehicles.php?action=list` - Get all vehicles
- `GET /api/vehicles.php?action=available` - Get available vehicles only

### Reports
- `GET /api/reports.php?action=dashboard` - Dashboard metrics
- `GET /api/reports.php?action=trips` - Trip report (date-ranged)
- `GET /api/reports.php?action=revenue` - Revenue report
- `GET /api/reports.php?action=topcustomers` - Top customers ranking
- `GET /api/reports.php?action=status` - Booking status summary

### Invoices
- `POST /api/invoices.php?action=generate` - Generate invoice
- `GET /api/invoices.php?action=pending` - Get completed bookings without invoices

### Notifications
- `GET /api/notifications.php?action=list` - Get notification log

---

## 🧪 Test Scenarios

### Scenario 1: Create & Complete a Booking
1. Login as Admin
2. Go to **Bookings** → Create new booking
3. Select customer "John Smith"
4. Enter route: O.R. Tambo → Johannesburg CBD
5. Set fare: $150
6. Go to **Schedule** → Assign driver & vehicle
7. Check for conflicts (should show if overlapping)
8. Complete assignment
9. Go to **Reports** → Verify in Trip Report

### Scenario 2: Generate Invoice
1. Complete booking with status "completed"
2. Go to **Invoices**
3. Select completed booking
4. Review invoice preview
5. Click **Download PDF** or **Save Invoice**
6. Verify in **Generated Invoices** table

### Scenario 3: Driver Dashboard
1. Login as Driver
2. View "My Trips" dashboard
3. See assigned trips
4. Click **Mark Complete** on a trip
5. Verify status changes to "completed"
6. Check notification log

### Scenario 4: Conflict Detection
1. Assign Driver + Vehicle to Booking A (10:00-11:00)
2. Try to assign same driver/vehicle to Booking B (10:30-11:30)
3. Should show: **⚠️ CONFLICT DETECTED**
4. Assignment should be blocked

### Scenario 5: Reports & Analytics
1. Go to **Reports**
2. Switch tabs: Trip | Revenue | Top Customers | Status
3. Generate reports with date range
4. View Chart.js visualizations
5. Export to PDF
6. View HTML table
7. Print report

---

## 🔐 Security Features

- ✅ Password hashing with bcrypt
- ✅ Session-based authentication
- ✅ Role-based access control (Admin/Driver)
- ✅ SQL injection prevention (prepared statements)
- ✅ CSRF protection (session-based)
- ✅ XSS prevention (htmlspecialchars)
- ✅ Input validation
- ✅ Secure headers

---

## 📊 Database Schema

### Tables (8 total)
1. **users** - Admin & Driver accounts
2. **customers** - Customer profiles
3. **drivers** - Driver records
4. **vehicles** - Fleet vehicles
5. **bookings** - Trip bookings
6. **schedules** - Trip assignments (with conflict tracking)
7. **invoices** - Generated invoices
8. **notifications** - Communication log
9. **routes** - Optional preset locations

### Key Features
- Foreign Key constraints enforced
- Indexes on frequently queried columns
- UTF-8MB4 charset support
- InnoDB engine for transactions
- TIMESTAMP defaults

---

## 🚀 Performance Optimizations

- ✅ Database indexes on foreign keys
- ✅ Prepared statements (MySQLi)
- ✅ Efficient AJAX for autocomplete
- ✅ CSS Grid for responsive layouts
- ✅ Minimal JavaScript dependencies (vanilla)
- ✅ Single CSS file (no framework bloat)
- ✅ Lazy loading for charts
- ✅ Query optimization (JOINs, aggregates)

---

## ⚡ Browser Compatibility

- ✅ Chrome 90+
- ✅ Firefox 88+
- ✅ Safari 14+
- ✅ Edge 90+
- ✅ Mobile (iOS Safari, Chrome Mobile)

---

## 📝 Notes

### Demo Credentials (Pre-seeded)
```
Admin Login:
  Username: admin
  Password: password
  
Driver Login:
  Username: driver
  Password: password
```

### Important Paths
- Database config: `/includes/db.php`
- Change database name in seed.sql if different
- Ensure XAMPP/WAMP is running before accessing

### Troubleshooting

**Connection Error:**
- Check if XAMPP is running
- Verify MySQL is active in XAMPP Control Panel
- Check `/includes/db.php` credentials

**404 Errors:**
- Ensure project folder is in `htdocs` directory
- Access via `http://localhost/nbk_travel`

**Invoice PDF Not Downloading:**
- Ensure html2pdf.js CDN is accessible
- Check browser console for errors

---

## 🎯 MVP Completion Status

| Feature | Status | Notes |
|---|---|---|
| Authentication | ✅ Complete | Login, logout, session management |
| Dashboard | ✅ Complete | Metrics, recent bookings |
| Bookings | ✅ Complete | Create, cancel, view, filters |
| Schedule | ✅ Complete | Assign, conflict detection, grid view |
| Customers | ✅ Complete | CRUD, search, autocomplete |
| Drivers | ✅ Complete | CRUD, status toggle, account creation |
| Vehicles | ✅ Complete | CRUD, status tracking |
| Reports | ✅ Complete | 4 report types, charts, export |
| Invoices | ✅ Complete | Generate, PDF, storage |
| Notifications | ✅ Complete | Auto-logging, history |
| Driver Dashboard | ✅ Complete | Trip view, mark complete |
| Dark Theme | ✅ Complete | Full futuristic design |
| Responsive Design | ✅ Complete | Mobile-friendly |
| Security | ✅ Complete | Auth, validation, prepared statements |

---

**Project Duration:** Complete and production-ready ✅

**Last Updated:** May 14, 2026

**Status:** 🟢 Ready for Deployment
