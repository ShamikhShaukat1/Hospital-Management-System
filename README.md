
# Hospital Management System

A web-based **Hospital Management System** designed to manage hospital operations through a centralized and user-friendly platform.

The system helps manage patients, doctors, appointments, departments, medical records, and other hospital-related activities efficiently.

## 📌 Project Overview

The Hospital Management System provides a digital solution for organizing and managing hospital information.

It allows authorized users to manage hospital records and perform day-to-day administrative tasks through a centralized system.

## 🚀 Features

* 🔐 User Authentication

  * Login
  * Registration
  * Logout
  * User access management

* 👨‍⚕️ Doctor Management

  * Add doctors
  * View doctors
  * Update doctor information
  * Delete doctors

* 🧑‍🤝‍🧑 Patient Management

  * Add patients
  * View patient information
  * Update patient information
  * Delete patient records

* 📅 Appointment Management

  * Schedule appointments
  * View appointments
  * Update appointments
  * Cancel appointments

* 🏥 Department Management

  * Add departments
  * View departments
  * Update departments
  * Delete departments

* 📋 Medical Records

  * Maintain patient records
  * View medical history
  * Manage diagnosis and treatment information

* 💊 Medicine Management

  * Add medicines
  * View medicine information
  * Update medicine records
  * Delete medicine records

* 💰 Billing Management

  * Manage patient bills
  * View billing information
  * Track payments

* 📊 Dashboard

  * View important system information
  * Access different hospital management modules
  * Monitor hospital activities

## 🛠️ Technologies Used

* PHP
* Laravel
* MySQL
* HTML
* CSS
* JavaScript
* Blade Templates
* Tailwind CSS / Bootstrap
* Composer
* NPM

## 📋 Requirements

Before running the project, make sure the following are installed:

* PHP
* Composer
* MySQL
* Node.js
* NPM
* Git

## ⚙️ Installation

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/hospital-management-system.git
```

### 2. Open the Project

```bash
cd hospital-management-system
```

### 3. Install Dependencies

```bash
composer install
```

Install frontend dependencies:

```bash
npm install
```

### 4. Configure the Environment

Create your environment configuration file using the provided project configuration template.

Then configure your database connection according to your local MySQL setup.

### 5. Set Up the Database

Create a MySQL database for the project and run:

```bash
php artisan migrate
```

If the project contains sample data:

```bash
php artisan db:seed
```

Or:

```bash
php artisan migrate --seed
```

### 6. Run the Project

Start the application:

```bash
php artisan serve
```

The application will be available at:

```text
http://127.0.0.1:8000
```

## 📁 Main Modules

The system is organized around the following major modules:

```text
Hospital Management System
│
├── Authentication
├── Dashboard
├── Patients
├── Doctors
├── Departments
├── Appointments
├── Medical Records
├── Medicines
└── Billing
```

## 🗄️ Database

The application uses **MySQL** for storing and managing hospital-related information.

The database manages information related to users, patients, doctors, appointments, departments, medical records, medicines, billing, and other system data.

## 👥 User Access

The system provides different levels of access depending on the user's role.

Administrative users can manage hospital information, while other users can access the features relevant to their responsibilities.

## 🔧 Useful Commands

Start the development server:

```bash
php artisan serve
```

Run database migrations:

```bash
php artisan migrate
```

Run database seeders:

```bash
php artisan db:seed
```

Install PHP dependencies:

```bash
composer install
```

Install frontend dependencies:

```bash
npm install
```

## 🚧 Future Improvements

Possible future enhancements include:

* Online appointment booking
* Doctor availability management
* Prescription management
* Pharmacy management
* Laboratory management
* Notifications
* Email and SMS integration
* Advanced reports
* Hospital analytics
* Online payment support


## 📄 License

This project is developed for educational and/or project purposes.

## 👨‍💻 Developer

**Shamikh Shaukat**

Hospital Management System
Built with PHP, Laravel, and MySQL.
