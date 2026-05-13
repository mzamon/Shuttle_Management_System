````md
# NBK Travel — Shuttle Booking Management System

![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?style=for-the-badge&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql)
![JavaScript](https://img.shields.io/badge/JavaScript-ES6-F7DF1E?style=for-the-badge&logo=javascript)
![HTML5](https://img.shields.io/badge/HTML5-Markup-E34F26?style=for-the-badge&logo=html5)
![CSS3](https://img.shields.io/badge/CSS3-Styling-1572B6?style=for-the-badge&logo=css3)
![Chart.js](https://img.shields.io/badge/Charts-Chart.js-FF6384?style=for-the-badge)
![License](https://img.shields.io/badge/License-Academic-blue?style=for-the-badge)

---

## Module Information

| Item | Details |
|---|---|
| **Module** | XISD5319 — Work Integrated Learning 3A |
| **Institution** | Rosebank College — The Independent Institute of Education (IIE) |
| **Client** | [NBK Travel](https://nbktravel.co.za?utm_source=chatgpt.com) |
| **Project Type** | Academic WIL Full-Stack Development Project |
| **System Name** | Shuttle Booking Management System |

---

# Project Overview

The **NBK Travel Shuttle Booking Management System** is a full-stack web-based transport management platform developed to modernise and digitise the operational workflow of NBK Travel, a shuttle and transportation service provider.

The system replaces manual business operations such as:
- telephone reservations
- paper booking registries
- spreadsheet scheduling
- handwritten invoices
- fragmented customer records

with a secure, scalable, and centralised digital platform.

The application provides:
- booking management
- automated scheduling
- customer relationship management
- vehicle and driver allocation
- invoice generation
- reporting and analytics
- operational dashboards
- notification logging

This repository forms part of the academic submission requirements for the Diploma in Information Technology in Software Development.

---

# Team Members

| Full Name | Student Number | Role |
|---|---|---|
| Shenice Wood | ST10447209 | Project Manager / Team Leader |
| Murendeni Makhavhu | ST10377430 | Database Administrator |
| Thandiwe Sibeko | ST10446961 | System Analyst |
| Matome Maopye | ST10341694 | UI/UX Designer & QA Tester |
| Mzamo Richmond Ndlovu | ST10455453 | Full-Stack Software Developer |

---

# System Objectives

The system was designed to achieve the following business objectives:

- Digitise shuttle booking operations
- Improve scheduling efficiency
- Reduce administrative overhead
- Improve customer management
- Automate reporting processes
- Enhance operational visibility
- Improve data integrity and security
- Automate invoice generation
- Improve driver and vehicle allocation
- Provide business intelligence dashboards

---

# Core Features

## Booking Management Module
- Create, update, cancel, and manage bookings
- Real-time booking status tracking
- Passenger management
- Fare management
- Booking history

## Scheduling System
- Automated driver assignment
- Vehicle allocation
- Conflict detection
- Weekly schedule visualisation
- Driver and vehicle availability tracking

## Customer Management
- Centralised customer records
- AJAX-powered customer search
- Duplicate prevention validation
- Customer booking history
- Customer preferences tracking

## Driver Management
- Driver profile management
- Driver status tracking
- Automated driver account creation
- Trip assignment monitoring

## Vehicle Management
- Fleet management
- Vehicle maintenance tracking
- Vehicle availability management
- Capacity management

## Reporting & Analytics
- Revenue reports
- Trip reports
- Driver utilisation reports
- Top customer analytics
- Booking status analytics
- Dashboard metrics using Chart.js

## Invoice Generation
- Automated invoice creation
- PDF invoice downloads
- Tax calculation
- Invoice storage and tracking

## Notification Logging
- Booking notifications
- Cancellation logs
- Invoice notifications
- Driver communication records

## Role-Based Authentication
- Secure login system
- Admin dashboard
- Driver dashboard
- Session validation
- Access control restrictions

---

# Technology Stack

| Layer | Technology |
|---|---|
| Frontend | HTML5, CSS3, JavaScript ES6 |
| Backend | PHP 8.x |
| Database | MySQL |
| Database Management | phpMyAdmin |
| Local Environment | XAMPP / WAMP |
| Charts & Analytics | Chart.js |
| PDF Generation | html2pdf.js |
| Version Control | Git & GitHub |
| UI/UX Prototyping | Figma |
| Diagram Design | Draw.io |

---

# System Architecture

The application follows a layered architecture structure:

- Presentation Layer (Frontend UI)
- Business Logic Layer (PHP APIs)
- Data Access Layer (MySQL Database)

The system uses:
- PHP session authentication
- MySQLi prepared statements
- AJAX asynchronous requests
- REST-style API endpoints
- JSON-based API responses

---

# Database Design

The system uses a relational MySQL database:

```sql
CREATE DATABASE nbk_travel;
````

## Database Tables

| Table         | Purpose                       |
| ------------- | ----------------------------- |
| users         | Authentication and user roles |
| customers     | Customer records              |
| drivers       | Driver management             |
| vehicles      | Fleet management              |
| bookings      | Booking transactions          |
| schedules     | Driver and vehicle scheduling |
| invoices      | Invoice records               |
| notifications | Notification logs             |
| routes        | Preset shuttle routes         |

## Database Features

* InnoDB storage engine
* UTF8MB4 charset support
* Foreign key constraints
* Prepared statement compatibility
* Normalised relational structure
* Referential integrity enforcement

---

# File Structure

```text
/nbk-travel/
├── index.php
├── logout.php
├── dashboard.php
├── bookings.php
├── schedule.php
├── customers.php
├── reports.php
├── invoices.php
├── drivers.php
├── vehicles.php
├── notifications.php
├── driver-dashboard.php
│
├── /api/
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
├── /includes/
│   ├── db.php
│   ├── auth_check.php
│   ├── header.php
│   └── footer.php
│
├── /assets/
│   ├── /css/
│   │   └── style.css
│   └── /js/
│       └── main.js
│
└── /database/
    └── schema.sql
```

---

# Design System

The system uses a futuristic dark-themed design language.

## Colour Palette

| Element            | Colour    |
| ------------------ | --------- |
| Primary Background | `#0a0f1e` |
| Panels             | `#0d1b2e` |
| Cards              | `#111d35` |
| Accent Colour      | `#00d4ff` |
| Text Colour        | `#ffffff` |
| Secondary Text     | `#8892a4` |

## UI Features

* Responsive layout
* Fixed sidebar navigation
* Interactive tables
* Status badges
* Dashboard metric cards
* Animated hover effects
* Chart visualisations
* Modal forms
* Mobile responsive grids and flex layouts

---

# Dashboard Features

The admin dashboard provides:

| Metric           | Description                               |
| ---------------- | ----------------------------------------- |
| Total Bookings   | Total number of bookings                  |
| Active Customers | Total registered customers                |
| Today's Trips    | Trips scheduled for the current day       |
| Total Revenue    | Revenue generated from completed bookings |

Additional features:

* Recent bookings table
* Quick action buttons
* Booking status analytics
* Interactive charts

---

# Reporting System

The application includes advanced reporting functionality using Chart.js.

## Available Reports

* Trip Reports
* Revenue Reports
* Driver Utilisation Reports
* Booking Status Reports
* Top Customer Reports

## Dashboard Analytics

* Booking distribution charts
* Revenue tracking graphs
* Driver activity monitoring
* Customer activity summaries

---

# Invoice Generation

Invoices are generated using:

```javascript
html2pdf.js
```

## Invoice Features

* Downloadable PDF invoices
* Automated tax calculations
* Invoice preview panel
* Invoice history storage
* Booking-linked invoices

---

# Security Features

The system implements multiple security mechanisms.

## Authentication & Security

* `password_hash()` password encryption
* `password_verify()` login verification
* MySQLi prepared statements
* Session-based authentication
* Role-based access control
* Protected API endpoints
* Input sanitisation using `htmlspecialchars()`

## Access Restrictions

| Role   | Access                |
| ------ | --------------------- |
| Admin  | Full system access    |
| Driver | Driver dashboard only |

---

# API Endpoints

The application uses modular API endpoints.

```text
/api/
```

## Available APIs

| Endpoint          | Purpose               |
| ----------------- | --------------------- |
| bookings.php      | Booking management    |
| schedule.php      | Scheduling operations |
| customers.php     | Customer operations   |
| reports.php       | Reporting & analytics |
| invoices.php      | Invoice generation    |
| drivers.php       | Driver management     |
| vehicles.php      | Fleet management      |
| notifications.php | Notification logging  |

All APIs:

* validate sessions
* enforce role permissions
* return JSON responses
* use prepared statements

---

# Development Environment

## Requirements

* PHP 8.x
* MySQL 8.x
* Apache Server
* XAMPP or WAMP
* Modern web browser

---

# Installation & Setup

## 1. Clone Repository

```bash
git clone <repository-url>
```

---

## 2. Move Project Folder

### XAMPP

```text
htdocs/
```

### WAMP

```text
www/
```

---

## 3. Import Database

Import:

```text
/database/schema.sql
```

into phpMyAdmin.

---

## 4. Configure Database

Update:

```text
/includes/db.php
```

with local database credentials.

---

## 5. Start Services

Start:

* Apache
* MySQL

using XAMPP/WAMP Control Panel.

---

## 6. Launch Application

Open:

```text
http://localhost/nbk-travel/
```

---

# Build Order

The project was developed in the following order:

1. Database Schema
2. Authentication System
3. Dashboard
4. Customer Module
5. Booking Module
6. Driver & Vehicle Management
7. Scheduling System
8. Reporting System
9. Invoice Generator
10. Notification System
11. Driver Dashboard
12. UI/UX Refinement
13. End-to-End Testing

---

# Testing Focus Areas

* Authentication validation
* Booking workflows
* Schedule conflict detection
* Invoice generation
* Reporting accuracy
* Dashboard analytics
* Role restrictions
* Database integrity
* Responsive design testing

---

# Academic Purpose

This repository was developed as part of:

**XISD5319 — Work Integrated Learning 3A**

The project demonstrates:

* systems analysis
* software engineering
* database design
* frontend development
* backend development
* UI/UX implementation
* business problem solving
* documentation standards
* enterprise system development

---

# Contributors

Developed collaboratively by the NBK Travel WIL Project Team.

---

# License

This repository is intended strictly for academic and educational purposes.

```
```
