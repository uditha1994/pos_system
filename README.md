# Point of Sale (POS) System

![POS System Screenshot](https://via.placeholder.com/800x400?text=POS+System+Screenshot)  
*(Replace with actual screenshot)*

## 📋 Overview
A simple yet powerful Point of Sale (POS) system built using PHP, MySQL, and Bootstrap. This application follows the Model-View-Controller (MVC) architecture for clean code organization and maintainability.

## ✨ Features

- **🔒 User Authentication**: Secure login system for staff members
- **🛍️ Product Management**: Add, edit, and manage products with categories
- **📦 Inventory Tracking**: Monitor stock levels and product availability
- **💳 Sales Processing**: Complete customer transactions with receipt generation
- **🕒 Order History**: View and search past transactions
- **📱 Responsive Design**: Works on desktop and mobile devices
- **📊 Reporting**: Basic sales reports and analytics

## 🛠️ Technologies Used

| Category       | Technologies |
|---------------|-------------|
| **Backend**   | PHP 8.2+    |
| **Database**  | MySQL       |
| **Frontend**  | Bootstrap 5, JavaScript |
| **Architecture** | MVC Pattern |
| **Other**     | HTML5, CSS3 |

## 🚀 Installation

### Prerequisites
- Web server (Apache, Nginx)
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Composer (for dependency management)

### ⚙️ Setup Instructions

1. **Clone the repository**:
   ```bash
   git clone https://github.com/uditha1994/pos_system.git
   cd pos_system

2. **Create database**:
CREATE DATABASE pos_system;

3. **Import database schema**:
Locate the SQL file in the database folder
Import it to your MySQL database

4. **Configure database connection**:
Edit the configuration file at includes/db.php with your database credentials:
define('DB_HOST', 'localhost');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
define('DB_NAME', 'pos_system');
Set up the web server:

5. **Point your web server to the public directory**
Ensure mod_rewrite is enabled for clean URLs

6. **Access the application**:
Open your browser and navigate to:
http://localhost/pos_system/public
