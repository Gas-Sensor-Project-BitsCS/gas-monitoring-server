Markdown
# 🚨 IoT Gas Monitoring & Alert System

A real-time gas level monitoring dashboard and API system built with Laravel. This platform ingests sensor readings (Gas Level, Temperature, Humidity) from ESP32 microcontrollers, stores data using MySQL, and broadcasts live metric updates to a dynamic dashboard via WebSockets.

---

## 🌟 Key Features

* **IoT Ingestion API:** REST API endpoints designed for ESP32 nodes to send live sensor readings.
* **Real-time WebSockets:** Live dashboard updates using **Laravel Reverb** without page refreshes.
* **Database Architecture:** Tracks Users, Devices, Sensor Readings, and Automated Threshold Alerts.
* **Cross-Platform Tunneling:** Configured for local development and remote testing via `ngrok`.

---

## 🏗️ System Architecture

```text
[ ESP32 Sensor Node ] ──(HTTP POST)──> [ Laravel API ] ──> [ SQLite Database ]
                                              │
                                     (Broadcast Event)
                                              │
                                      [ Laravel Reverb ]
                                              │
                                         (WebSockets)
                                              │
                                              ▼
                                   [ Web Browser Dashboard ]
🚀 Getting Started
Prerequisites
PHP >= 8.2

Composer

Node.js & NPM

MySQL

Installation
Clone the repository:

Bash
git clone [https://github.com/Gas-Sensor-Project-BitsCS/gas-monitoring-server.git](https://github.com/Gas-Sensor-Project-BitsCS/gas-monitoring-server.git)
cd gas-monitoring-server
Install PHP and Node dependencies:

Bash
composer install
npm install
Set up Environment File:

Bash
cp .env.example .env
php artisan key:generate
Prepare the Database:
Ensure configure MySQL in .env, then run migrations:

Bash
php artisan migrate:fresh
Run the Development Services:
Open 3 terminal windows/tabs to run the stack:

Laravel App Server: php artisan serve

Reverb WebSocket Server: php artisan reverb:start

Vite Frontend Compiler: npm run dev

📡 API Endpoint Reference
Store Sensor Reading
HTTP Method: POST

URL: /api/sensor-readings

Headers:

Content-Type: application/json

Accept: application/json

Request Body Example:
JSON
{
    "gas_value": 450.25,
    "temperature": 27.5,
    "humidity": 65.0
}
Success Response (201 Created):
JSON
{
    "status": "success",
    "message": "Sensor reading stored successfully",
    "data": {
        "id": 1,
        "device_id": 1,
        "gas_value": 450.25,
        "temperature": 27.5,
        "humidity": 65,
        "recorded_at": "2026-08-21T13:00:00.000000Z"
    }
}
🛠️ Built With
Backend Framework: Laravel 11

Real-time Server: Laravel Reverb

Database: SQLite / MySQL

Frontend: Blade, Tailwind CSS, Google Charts / Chart.js