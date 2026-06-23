# 🚀 NBK Travel – Complete Futuristic Application  

A full-stack web application for next-generation shuttle booking and fleet management. It features a professional **Hertz-inspired landing page** for customers and a futuristic **"Command Center"** dashboard for administrators.

---

## 📁 Complete File Tree

```text
/nbk_travel/
├── index.php                # Hertz-style Landing page (Hero + Booking form)
├── login.php                # Login processor (Full Access Override)
├── register.php             # Sign-up page (Driver role default)
├── logout.php               # Session destroy
├── dashboard.php            # Admin Command Center (Metrics & Overview)
├── bookings.php             # Booking management (List & Create)
├── schedule.php             # Scheduling & driver assignment
├── customers.php            # Customer CRM
├── drivers.php              # Driver management
├── vehicles.php             # Fleet vehicle management
├── reports.php              # Analytics & Business Intelligence
├── invoices.php             # Financial records
├── notifications.php        # System activity log
├── driver-dashboard.php     # Restricted Driver portal
│
├── /api/                    # Backend AJAX/JSON Endpoints
│   ├── auth.php
│   ├── bookings.php
│   ├── schedule.php
│   ├── customers.php
│   ├── reports.php
│   ├── invoices.php
│   ├── drivers.php
│   ├── vehicles.php
│   └── notifications.php
│
├── /includes/               # Shared PHP Core
│   ├── db.php               # MySQLi connection
│   ├── auth_check.php       # Security guard (Auto-login Override)
│   ├── header.php           # Global sidebar navigation
│   └── footer.php           # Scripts & closing tags
│
├── /assets/                 # Static Assets
│   ├── /css/style.css       # Futuristic Design System v3.0
│   ├── /js/main.js          # NBKTravel utility library
│   └── /images/nbk.jpeg     # Company branding
│
└── /database/
    └── schema.sql           # DB structure + Demo seed data
```

---

## ✨ Key Features

- **Hertz-Style Landing Page**: A clean, professional entry point with a functional booking search form.
- **Full Access Mode**: Security overrides in `login.php` and `auth_check.php` allow for seamless demonstration without login friction.
- **Futuristic UI**: High-tech admin aesthetic with neon accents, glassmorphism, and animated backgrounds.
- **Fleet Intelligence**: Real-time scheduling with conflict detection to prevent overlapping assignments.
- **Automated Invoicing**: Instant PDF-ready invoice generation upon trip completion.
- **Advanced Analytics**: Interactive data visualization using Chart.js for revenue and trip trends.

## 🛠 Tech Stack

- **Backend**: PHP 8.x
- **Database**: MySQL (MySQLi)
- **Frontend**: HTML5, CSS3 (Grid/Flexbox), JavaScript (ES6)
- **Visualization**: Chart.js
- **Icons**: Optimized SVG paths

## 🚀 Setup & Installation

1. **Deployment**: Clone the repository into your web server root (e.g., `C:/xampp/htdocs/nbk_travel/`).
2. **Database**: Import `database/schema.sql` into your MySQL server via phpMyAdmin.
3. **Configuration**: Ensure `includes/db.php` has the correct credentials (default is `root` with no password).
4. **Access**: Navigate to `http://localhost/nbk_travel/`.

## 🎨 Design System

The system utilizes a dual-design approach:
1. **Public**: Clean, high-contrast, professional layout.
2. **Internal**: Sci-fi inspired "Command Center" using **Orbitron** and **Space Grotesk** typefaces with a deep navy and neon cyan palette.

---
**Academic Use Only**  
*WIL Project for Rosebank College – XISD5319*
