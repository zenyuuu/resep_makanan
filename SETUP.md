# 🍳 MauMasakApa - Setup Guide

Panduan lengkap untuk setup project MauMasakApa di local machine.

## 📋 Prerequisites

- PHP 8.1+
- Composer
- Node.js & npm
- MySQL/MariaDB atau SQLite
- Git

## ⚙️ Setup Steps

### 1. Clone Repository
```bash
git clone <repository-url>
cd resep_makanan
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 3. Setup Environment File
```bash
# Copy .env.example ke .env
cp .env.example .env

# Generate app key (IMPORTANT!)
php artisan key:generate
```

### 4. Database Setup
```bash
# Run migrations
php artisan migrate

# (Optional) Seed database dengan data dummy
php artisan db:seed
```

### 5. Build Frontend Assets
```bash
# Development mode
npm run dev

# Or production build
npm run build
```

### 6. Run Server
```bash
# Option 1: Laravel artisan server
php artisan serve

# Option 2: Custom port
php artisan serve --port=8001
```

Server akan running di `http://127.0.0.1:8000`

## 🔑 Important Notes

### Database Configuration
Edit `.env` file untuk set database connection:

**Untuk SQLite:**
```env
DB_CONNECTION=sqlite
# (Leave DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD commented)
```

**Untuk MySQL:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=resep_makanan
DB_USERNAME=root
DB_PASSWORD=your_password
```

### Test Login Credentials
Default test users dari seeder:
- Email: `test@example.com`
- Password: `password`

Atau daftar user baru via register page.

## 🎨 Theme & Styling

- Primary Color: **#f59e0b** (Amber/Yellow)
- Theme: Modern & Responsive
- CSS Framework: Custom CSS (Vanilla)

## ✅ Fitur Utama

✅ **CRUD Recipes** - Create, Read, Update, Delete resep
✅ **User Auth** - Login, Register, Logout, Profile Edit
✅ **Favorites** - Save resep favorit
✅ **Search** - Cari resep by nama & bahan
✅ **Dashboard** - User dashboard dengan stats
✅ **Image Upload** - Upload gambar resep
✅ **Pagination** - List resep dengan pagination
✅ **Authorization** - Only owner bisa edit/delete own recipes

## 🚨 Troubleshooting

### Error: "No such file or directory"
- Pastikan sudah run `composer install` dan `npm install`

### Error: "SQLSTATE[HY000]"
- Check `.env` database configuration
- Pastikan database sudah created
- Run `php artisan migrate`

### CSS Tidak Muncul
- Run `npm run dev` atau `npm run build`
- Clear cache: `php artisan cache:clear`
- Refresh browser (Ctrl+Shift+R untuk hard refresh)

### Images Tidak Muncul
- Run `php artisan storage:link`
- Check storage/app/public/reseps folder

## 📁 Project Structure

```
resep_makanan/
├── app/
│   ├── Http/Controllers/     # Application Controllers
│   ├── Models/               # Database Models
│   └── Policies/             # Authorization Policies
├── database/
│   ├── migrations/           # Database Migrations
│   ├── factories/            # Model Factories (testing)
│   └── seeders/              # Database Seeders
├── resources/
│   ├── css/                  # Stylesheets (development)
│   ├── js/                   # JavaScript
│   └── views/                # Blade Templates
├── routes/
│   ├── web.php              # Web Routes
│   └── auth.php             # Auth Routes
├── storage/
│   └── app/                 # User uploads & files
├── public/
│   ├── css/                 # Compiled CSS
│   ├── js/                  # Built JS
│   └── storage/             # Symlink to storage
└── tests/                    # Test files
```

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/ResepCrudTest.php

# Run with verbose output
php artisan test --verbose
```

## 📝 Git Workflow

```bash
# Check status
git status

# Add changes
git add .

# Commit changes
git commit -m "feat: Description of changes"

# Push to repository
git push origin main
```

## 🚀 Deployment

Untuk deploy ke production, gunakan hosting yang support:
- PHP 8.1+
- Composer
- Node.js (untuk build assets)
- MySQL/MariaDB database

**Setup commands:**
```bash
git clone <repo>
cd resep_makanan
composer install --no-dev
npm install && npm run build
cp .env.example .env
php artisan key:generate
php artisan migrate --force
php artisan storage:link
```

## 📞 Support

Jika ada error atau pertanyaan, silahkan:
1. Check troubleshooting section
2. Lihat error message di terminal
3. Check application logs: `storage/logs/laravel.log`

---

**Happy Cooking! 🍳**
