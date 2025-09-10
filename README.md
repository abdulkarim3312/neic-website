# 🚀 Laravel Ecommerce Project

A powerful and scalable **Ecommerce Web Application** built with **Laravel 12**, featuring role-based access, product management, order processing, and more.

---

## 🔥 Features

- **Custom session-based login system**
- **Role-based access control** (Admin, Manager, Sales)
- Product management (Add, Edit, Delete, View)
- Order management with status tracking
- Interactive dashboard with analytics & reports
- Responsive UI built with **Bootstrap 5**
- Custom middlewares for access control & performance optimization

---

## ⚙️ Requirements

- PHP >= 8.1  
- Composer  
- Laravel 12  
- MySQL or compatible database  
- Node.js & npm (for frontend assets)

---

## 🔐 Demo User Access

| Role    | Email               | Password   |
|---------|---------------------|------------|
| Admin   | admin@example.com    | 123456789  |
| Manager | manager@example.com  | 123456789  |
| Sales   | sales@example.com    | 123456789  |

---

## 📦 Installation

```bash
# Clone the repository
git clone https://github.com/imtanvir70/ecommerce-bd.git

# Navigate to project
cd Ecommerce-bd

# Install dependencies
composer install
npm install && npm run dev

# Setup environment
cp .env.example .env
php artisan key:generate

# Run migrations & seeders
php artisan migrate --seed

# Start local server
php artisan serve
