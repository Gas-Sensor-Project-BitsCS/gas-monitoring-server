# 🚨 IoT Gas Monitoring & Alert System

A web-based IoT gas monitoring and alert system built with **Laravel 13**. The system receives sensor data from **ESP32** devices through REST APIs, stores readings in **MySQL**, processes threshold-based alerts, and provides a dashboard for monitoring gas levels, temperature, humidity, devices, and alerts.

The application also includes custom user authentication, role-based access control, user management, and configurable device thresholds.

---

## 🌟 Features

### 📡 IoT Sensor Integration

* ESP32 devices send sensor readings to the Laravel backend using REST APIs.
* Supports:

  * Gas level
  * Temperature
  * Humidity
* Each device is identified using a unique `device_uid`.
* Sensor readings are stored in MySQL for historical analysis.

### 🚨 Alert Management

* Automatically checks incoming sensor readings against configured thresholds.
* Creates alerts when sensor values exceed configured limits.
* Supports alert severity levels.
* Active alerts can be resolved when sensor values return to safe levels.
* Alerts are associated with the device and sensor reading that triggered them.

### 🎚️ Device Threshold Management

Thresholds can be configured from the dashboard.

Supported thresholds include:

* Gas threshold
* Temperature threshold
* Humidity threshold
* Moderate gas threshold
* Moderate temperature threshold
* Moderate humidity threshold

Thresholds can be updated through the web dashboard and API.

### 👤 Authentication & User Management

* Custom user authentication
* User registration and login
* Secure password hashing
* Session-based authentication
* User roles
* Admin-only user management
* Active/inactive user accounts
* Inactive users are prevented from accessing protected areas

### 🖥️ Dashboard

The dashboard provides an overview of:

* Current gas level
* Temperature
* Humidity
* Connected devices
* Active and resolved alerts
* Sensor readings
* Device thresholds

Dashboard data is retrieved from Laravel API endpoints.

### ⚡ Livewire Integration

The project uses **Laravel Livewire** for interactive server-driven UI components.

Livewire is currently used for features such as:

* User management
* User search
* User filtering
* User activation/deactivation
* Threshold management
* Interactive dashboard pages

---

## 🗄️ Database

The application uses **MySQL** as its primary database.

The main entities include:

```text
Users
  │
  ├── Authentication
  ├── Roles
  └── Active/Inactive Status

Devices
  │
  ├── Device UID
  ├── Device Information
  └── Configurable Thresholds
       │
       ▼
Sensor Readings
  │
  ├── Gas Value
  ├── Temperature
  ├── Humidity
  └── Recorded At
       │
       ▼
Alerts
  ├── Severity
  ├── Status
  ├── Triggered At
  └── Resolved At
```

---

## 🔄 Data Flow

### Sensor Data

```text
ESP32
  │
  │ POST /api/sensor-readings
  ▼
Laravel API
  │
  ├── Validate sensor data
  │
  ├── Identify device
  │
  ├── Store sensor reading
  │
  ├── Compare values with thresholds
  │
  └── Create/resolve alert
          │
          ▼
        MySQL
```

### Dashboard

```text
Browser
   │
   │ API Request
   ▼
Laravel API
   │
   ▼
MySQL
   │
   ▼
JSON Response
   │
   ▼
Dashboard
```

---

# 🚀 Getting Started

## Prerequisites

Make sure the following are installed:

* PHP >= 8.2
* Composer
* Node.js
* NPM
* MySQL
* Git

---

## Installation

### 1. Clone the repository

```bash
git clone https://github.com/Gas-Sensor-Project-BitsCS/gas-monitoring-server.git

cd gas-monitoring-server
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Install frontend dependencies

```bash
npm install
```

### 4. Configure environment

Copy the example environment file:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

### 5. Configure MySQL

Update the database section in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gas_monitoring
DB_USERNAME=root
DB_PASSWORD=
```

Make sure the database exists before running migrations.

### 6. Run migrations

```bash
php artisan migrate
```

To recreate the database and run seeders during development:

```bash
php artisan migrate:fresh --seed
```

### 7. Start the Laravel server

```bash
php artisan serve
```

### 8. Start Vite

In another terminal:

```bash
npm run dev
```

The application will normally be available at:

```text
http://127.0.0.1:8000
```

---

# 📡 API

## Store Sensor Reading

### Endpoint

```http
POST /api/sensor-readings
```

### Headers

```http
Content-Type: application/json
Accept: application/json
```

### Request

```json
{
    "device_uid": "ESP32-001",
    "gas_value": 450.25,
    "temperature": 27.5,
    "humidity": 65.0
}
```

### Example Response

```json
{
    "status": "success",
    "message": "Sensor reading stored successfully",
}
```

---


# 🔐 Authentication & Authorization

The application uses session-based authentication.

### Authentication flow

```text
Login
  │
  ▼
Validate credentials
  │
  ▼
Check user status
  │
  ├── Inactive → Reject login
  │
  └── Active
       │
       ▼
    Create session
       │
       ▼
    Dashboard
```

### User Roles

The application currently supports:

* `admin`
* `user`

Administrative routes are protected using role middleware.

For example:

```php
Route::middleware(['auth', 'active', 'role:admin'])
    ->prefix('admin')
    ->group(function () {
        // Admin routes
    });
```

---

# 📊 Main Application Pages

| Page            | Description                           | Access              |
| --------------- | ------------------------------------- | ------------------- |
| Dashboard       | Monitor sensor and device information | Authenticated users |
| Thresholds      | View and update device thresholds     | Authenticated users |
| Devices         | Manage/view connected devices         | Authenticated users |
| Alerts          | View and manage alerts                | Authenticated users |
| Users           | Manage users and active status        | Admin               |
| Admin Dashboard | Administrative dashboard              | Admin               |

---

# 🛠️ Technology Stack

### Backend

* **Laravel 13**
* **PHP**
* **MySQL**
* **REST APIs**

### Frontend

* **Blade**
* **Livewire**
* **Tailwind CSS**
* **JavaScript**
* **Lucide Icons**

### Hardware

* **ESP32**
* Gas Sensor
* Temperature Sensor
* Humidity Sensor
* Buzzer

### Development Tools

* Composer
* NPM
* Vite
* Postman
* Git / GitHub

---

# 🧪 API Testing

The REST APIs can be tested using **Postman** before connecting the ESP32.

Recommended testing flow:

```text
Postman
   │
   ▼
Laravel API
   │
   ├── Validate Request
   │
   ├── Store Data
   │
   └── Process Alert
        │
        ▼
      MySQL
```

This allows the API to be verified independently before troubleshooting the ESP32 HTTP client.

---

# 🚧 Current Development Status

The project currently includes:

* ✅ Laravel backend
* ✅ MySQL database
* ✅ ESP32 sensor API
* ✅ Sensor data storage
* ✅ Threshold management
* ✅ Alert creation and resolution
* ✅ Custom authentication
* ✅ Role-based authorization
* ✅ Active/inactive user management
* ✅ User management page
* ✅ Threshold management page
* ✅ Livewire integration
* ✅ API-based dashboard data
* ✅ Blade-based frontend
* ✅ Tailwind CSS UI

Real-time WebSocket functionality is **Development**. Dashboard data is currently retrieved through HTTP API endpoints.

---

# 👥 Project

**IoT Gas Monitoring & Alert System**

Developed as a Computer Science project using Laravel, MySQL, ESP32, and sensor hardware.

Repository:

[Gas-Sensor-Project-BitsCS/gas-monitoring-server](https://github.com/Gas-Sensor-Project-BitsCS/gas-monitoring-server?utm_source=chatgpt.com)
