# 🛒 Product Management System

A full-featured **Product Management System** built with Laravel 13, featuring a RESTful API with JWT Authentication, Admin Dashboard, multi-language support (Arabic/English), and media management.


---

## ✨ Features

- ✅ JWT Authentication (Register, Login, Logout, Profile)
- ✅ Multi-level nested Categories with Tree View
- ✅ Products with Search, Filters & Pagination
- ✅ Product Attributes (unlimited key/value pairs)
- ✅ Multiple Gallery Images & PDF Files via Spatie Media Library
- ✅ Favorites System
- ✅ Multi-language Support (Arabic / English)
- ✅ Admin Dashboard with full CRUD
- ✅ Product Caching
- ✅ Soft Deletes
- ✅ Service Pattern & Clean Architecture
- ✅ Form Request Validation
- ✅ API Resources

---

## 🔧 Requirements

| Requirement | Version |
|---|---|
| PHP | ^8.2 |
| Laravel | ^13.x |
| MySQL | ^8.0 |
| Composer | ^2.x |
| Node.js | ^18.x |
| NPM | ^9.x |

---

## 📦 Packages Used

| Package | Purpose |
|---|---|
| `php-open-source-saver/jwt-auth` | JWT Authentication |
| `spatie/laravel-translatable` | Multi-language (AR/EN) |
| `spatie/laravel-medialibrary` | Images & Files Management |
| `mcamara/laravel-localization` | Localization |
| `laravel/breeze` | Admin Auth Scaffolding |

---

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/product-management.git
cd product-management
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Node Dependencies

```bash
npm install
```

### 4. Copy Environment File

```bash
cp .env.example .env
```

---

## ⚙️ Environment Setup

Open `.env` and configure the following:

```env
APP_NAME="Product Management"
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=product_management
DB_USERNAME=root
DB_PASSWORD=

CACHE_STORE=file

JWT_SECRET=  # will be generated in next step
```

### Enable Sodium Extension (Required for JWT)

Open your `php.ini` file and uncomment:

```ini
extension=sodium
```

---

## 🗄️ Database

### 1. Create Database

```sql
CREATE DATABASE product_management;
```

### 2. Generate Application Key

```bash
php artisan key:generate
```

### 3. Generate JWT Secret

```bash
php artisan jwt:secret
```

### 4. Run Migrations

```bash
php artisan migrate
```

### 5. Run Seeders

```bash
php artisan db:seed
```

Or fresh migration with seeders:

```bash
php artisan migrate:fresh --seed
```

### 6. Create Storage Link

```bash
php artisan storage:link
```

---

## ▶️ Running the Project

### Start the Backend Server

```bash
php artisan serve
```

### Start the Frontend (Vite)

```bash
npm run dev
```

The application will be available at: `http://127.0.0.1:8000`

---

## 📡 API Documentation

### Base URL
```
http://127.0.0.1:8000/api
```

### Authentication Header
```
Authorization: Bearer {token}
```

### Language Header
```
Accept-Language: ar   (Arabic)
Accept-Language: en   (English)
```

---

### 🔐 Auth Endpoints

| Method | Endpoint | Description | Auth Required |
|---|---|---|---|
| POST | `/api/register` | Register new user | ❌ |
| POST | `/api/login` | Login | ❌ |
| POST | `/api/logout` | Logout | ✅ |
| GET | `/api/profile` | Get user profile | ✅ |

#### Register
```json
POST /api/register
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "12345678",
    "password_confirmation": "12345678"
}
```

#### Login
```json
POST /api/login
{
    "email": "john@example.com",
    "password": "12345678"
}
```

---

### 📂 Categories Endpoints

| Method | Endpoint | Description | Auth Required |
|---|---|---|---|
| GET | `/api/categories` | Get all categories | ❌ |
| GET | `/api/categories/tree` | Get categories tree | ❌ |
| GET | `/api/show/category/{id}` | Get single category | ❌ |
| POST | `/api/create/category` | Create category | ✅ |
| PUT | `/api/update/category/{id}` | Update category | ✅ |
| DELETE | `/api/delete/category/{id}` | Delete category | ✅ |

#### Create Category (form-data)
```
name[en]   = Electronics
name[ar]   = إلكترونيات
status     = 1
parent_id  = (optional)
image      = (file, optional)
```

---

### 🛍️ Products Endpoints

| Method | Endpoint | Description | Auth Required |
|---|---|---|---|
| GET | `/api/products` | Get all products | ❌ |
| GET | `/api/show/product/{id}` | Get single product | ❌ |
| POST | `/api/create/product` | Create product | ✅ |
| PUT | `/api/update/product/{id}` | Update product | ✅ |
| DELETE | `/api/delete/product/{id}` | Delete product | ✅ |

#### Query Parameters for Products
```
GET /api/products?search=iphone
GET /api/products?category_id=1
GET /api/products?min_price=100&max_price=500
GET /api/products?brand=Apple
```

#### Create Product (form-data)
```
title[en]        = iPhone 15 Pro
title[ar]        = آيفون 15 برو
description[en]  = Latest iPhone model
description[ar]  = أحدث موديل آيفون
sku              = IPH-15P-BLK
price            = 999.99
sale_price       = 899.99  (optional)
stock            = 50
brand            = Apple
status           = 1
category_id      = 1
main-image       = (file, optional)
gallery[]        = (files, optional, multiple)
files[]          = (pdf files, optional, multiple)
```

---

### ❤️ Favorites Endpoints

| Method | Endpoint | Description | Auth Required |
|---|---|---|---|
| GET | `/api/favorites` | Get my favorites | ✅ |
| POST | `/api/favorites/{product}` | Add to favorites | ✅ |
| DELETE | `/api/favorites/{product}` | Remove from favorites | ✅ |

---

## 🖥️ Admin Dashboard

Access the admin dashboard at: `http://127.0.0.1:8000/dashboard`

### Default Admin Account

To create an admin user, run:

```bash
php artisan tinker
```

```php
App\Models\User::create([
    'name'     => 'Admin',
    'email'    => 'admin@admin.com',
    'password' => bcrypt('password'),
    'role'     => 'admin',
]);
```

### Dashboard Features

| Section | Features |
|---|---|
| Categories | Create, Edit, Delete, Tree View, Image Upload |
| Products | Create, Edit, Delete, Gallery, PDF Files |

---

## 🌍 Localization

The API supports Arabic and English responses via the `Accept-Language` header:

```
Accept-Language: en  →  English response
Accept-Language: ar  →  Arabic response
```

Translatable fields:
- Category: `name`
- Product: `title`, `description`

---

## 🏗️ Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/          # Admin Dashboard Controllers
│   │   ├── Api/            # API Controllers (Auth, Favorites)
│   │   ├── Category/       # Category API Controller
│   │   └── Products/       # Product API Controller
│   ├── Middleware/
│   │   ├── IsAdmin.php     # Admin role check
│   │   └── SetLocale.php   # Language detection
│   ├── Requests/           # Form Request Validation
│   └── Resources/          # API Resources
├── Models/
│   ├── Category.php
│   ├── Product.php
│   ├── ProductAttribute.php
│   ├── Favorite.php
│   └── User.php
├── Services/
│   ├── CategoryService.php
│   ├── ProductsService.php
│   └── MediaService.php
└── Exports/
    └── ProductsExport.php
```

---

## 🗃️ Database Tables

| Table | Description |
|---|---|
| `users` | Users & Admins (with role column) |
| `categories` | Nested categories with translations |
| `products` | Products with translations |
| `product_attributes` | Unlimited key/value attributes |
| `favorites` | User favorite products |
| `media` | All images & files (Spatie) |

---

## 👨‍💻 Author

Kareem Mohamed ElKamah
