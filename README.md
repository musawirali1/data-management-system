# Data Management System

A web-based **Data Management System** built with PHP and MySQL for managing students, teachers, users, fees, roles, profiles, and system settings through an admin dashboard.

## 📌 Project Overview

The Data Management System is designed to provide a centralized platform for managing different types of records in an educational/institutional environment.

The system includes authentication, role management, CRUD operations, user account management, profile management, fee management, and configurable system settings.

## ✨ Features

- 🔐 User Login & Authentication
- 📝 User Registration
- 👤 User Management
- 🎓 Student Management
- 👨‍🏫 Teacher Management
- 💰 Fee Management
- 👥 Role Management
- 🔄 Activate / Deactivate Users
- ⏳ Pending User Approval
- 👤 User Profile
- ✏️ Edit Profile
- 🔑 Change Password
- ⚙️ System Settings
- 📅 Date & Time Settings
- 🔄 AJAX-based Operations
- 📱 Responsive Dashboard
- 🗄️ MySQL Database Integration
- 🔒 Session-based Authentication

## 🛠️ Technologies Used

- **PHP**
- **MySQL**
- **HTML5**
- **CSS3**
- **JavaScript**
- **jQuery**
- **AJAX**
- **Bootstrap 5**
- **Font Awesome**
- **XAMPP**
- **Git & GitHub**

## 📂 Main Modules

### 1. Authentication

The system provides user authentication and protected dashboard access using PHP sessions.

### 2. Student Management

Administrators can manage student records using CRUD operations.

### 3. Teacher Management

The system provides functionality for managing teacher records.

### 4. User Management

Administrators can:

- View users
- Add users
- Edit users
- Delete users
- Activate users
- Deactivate users
- Manage user status

### 5. Fee Management

The fee module allows management of student fee records.

### 6. Role Management

The system supports multiple roles and allows administrators to manage role permissions.

Example roles include:

- Admin
- Teacher
- Student
- Parent
- Accountant
- Staff

### 7. Profile Management

Users can:

- View their profile
- Edit profile information
- Change their password

### 8. Settings

The settings module provides configuration options for:

- General Settings
- Date & Time Settings
- System Settings
- User Roles

## 🗂️ Project Structure

```text
Data Management System
│
├── Auth/
│   ├── login.php
│   ├── check_login.php
│   ├── register.php
│   └── register_process.php
│
├── Model/
│   ├── student/
│   ├── teacher/
│   ├── user/
│   └── fee/
│
├── content-files/
│   ├── students/
│   ├── teachers/
│   ├── users/
│   ├── fees/
│   ├── settings/
│   └── Profile_files/
│
├── assets/
│   ├── css/
│   ├── js/
│   └── dist/
│
├── config/
│
├── images/
│
├── db-connection.php
│
├── index.php
│
└── README.md
