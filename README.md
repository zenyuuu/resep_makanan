# 🍳 MauMasakApa - Recipe Sharing Platform

Platform resep online modern untuk berbagi, mencari, dan menyimpan resep favorit dengan komunitas global.

<p align="center">
  <strong>Built with Laravel | Modern UI | Full CRUD | Search Features</strong>
</p>

---

## 🎯 Fitur Utama

✅ **CRUD Recipes** - Create, Read, Update, Delete resep dengan mudah  
✅ **User Authentication** - Login, Register, Logout dengan aman  
✅ **Favorites System** - Simpan resep favorit dengan star button  
✅ **Advanced Search** - Cari resep by nama & bahan-bahan  
✅ **User Dashboard** - Dashboard dengan stats & menu navigasi  
✅ **Image Upload** - Upload & manage gambar resep  
✅ **Responsive Design** - Optimized untuk desktop & mobile  
✅ **Authorization** - Hanya owner bisa edit/delete resep sendiri  
✅ **Modern UI** - Yellow/Amber theme yang menarik  
✅ **Pagination** - List resep dengan pagination  

---

## 🛠️ Tech Stack

| Layer | Technology |
|-------|-----------|
| **Backend** | Laravel 10+ |
| **Frontend** | Blade Templates + Custom CSS |
| **Database** | MySQL/SQLite |
| **Styling** | Vanilla CSS (Yellow Theme) |
| **Build Tool** | Vite |
| **Package Manager** | Composer + npm |

---

## 📋 System Requirements

- PHP 8.1 atau lebih tinggi
- Composer
- Node.js & npm
- MySQL 5.7+ atau SQLite
- Git

---

## 🚀 Quick Start

### 1️⃣ Clone Repository
```bash
git clone https://github.com/zenyuuu/resep_makanan.git
cd resep_makanan
```

### 2️⃣ Install Dependencies
```bash
composer install
npm install
```

### 3️⃣ Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 4️⃣ Database Setup
```bash
# Edit .env untuk set database connection
# Kemudian jalankan:
php artisan migrate

# (Optional) Seed dengan data dummy:
php artisan db:seed
```

### 5️⃣ Build Assets
```bash
npm run dev
```

### 6️⃣ Run Server
```bash
php artisan serve
```

Server running di: **http://127.0.0.1:8000**

> **Untuk detail lengkap, baca [SETUP.md](SETUP.md)**

---

## 📁 Project Structure

```
resep_makanan/
├── app/
│   ├── Http/Controllers/ResepController.php      # Resep logic
│   ├── Models/
│   │   ├── User.php
│   │   └── Resep.php
│   └── Policies/ResepPolicy.php                  # Authorization
├── database/
│   ├── migrations/
│   │   └── *_create_reseps_table.php
│   └── seeders/
│       └── ResepSeeder.php
├── resources/
│   ├── css/                    # Stylesheets
│   │   ├── auth.css
│   │   ├── home.css
│   │   ├── dashboard.css
│   │   ├── reseps.css
│   │   └── profile.css
│   ├── views/                  # Blade templates
│   │   ├── reseps/
│   │   │   ├── index.blade.php
│   │   │   ├── create.blade.php
│   │   │   ├── edit.blade.php
│   │   │   ├── show.blade.php
│   │   │   └── favorites.blade.php
│   │   └── ...
│   └── js/
├── routes/
│   ├── web.php                 # Web routes
│   └── auth.php                # Auth routes
├── storage/
│   └── app/reseps/             # Upload resep images
├── public/
│   ├── css/                    # Compiled CSS
│   └── storage/                # Symlink to storage
└── tests/                      # Test files
```

---

## 🔐 User Roles & Permissions

| Action | Anonymous | User | Owner |
|--------|-----------|------|-------|
| View Resep | ✅ | ✅ | ✅ |
| Create Resep | ❌ | ✅ | ✅ |
| Edit Resep | ❌ | ❌ | ✅ |
| Delete Resep | ❌ | ❌ | ✅ |
| Add to Favorite | ❌ | ✅ | ✅ |
| Search Resep | ✅ | ✅ | ✅ |

---

## 🎨 Design System

### Colors
- **Primary**: `#f59e0b` (Amber-500)
- **Primary Dark**: `#d97706` (Amber-600)
- **Accent**: `#fbbf24` (Amber-400)
- **Light BG**: `#fef3c7` (Amber-100)

### Typography
- **Font**: Segoe UI, Tahoma, Geneva, Verdana, sans-serif
- **Headings**: Bold (700-900 weight)
- **Body**: Regular (400-600 weight)

### Spacing
- **Border Radius**: 12px - 20px
- **Shadows**: 0 10px 40px rgba(0,0,0,0.1)
- **Gaps**: 1.5rem - 3rem

---

## 🔄 Database Schema

### Tabel: `reseps`
```sql
- id (PK)
- user_id (FK) - Pembuat resep
- judul (string) - Nama resep
- bahan (text) - Daftar bahan
- langkah (text) - Cara memasak
- gambar (string) - Path gambar
- created_at, updated_at
```

### Tabel: `favorites`
```sql
- user_id (PK)
- resep_id (PK)
- Relationship: Many-to-Many antara User & Resep
```

---

## 📍 API Routes

| Method | Route | Purpose |
|--------|-------|---------|
| GET | `/` | Landing page |
| GET | `/home` | Home (authenticated) |
| GET | `/dashboard` | User dashboard |
| GET | `/reseps` | Daftar resep |
| GET | `/reseps/create` | Form buat resep |
| POST | `/reseps` | Store resep |
| GET | `/reseps/{id}` | Detail resep |
| GET | `/reseps/{id}/edit` | Form edit resep |
| PUT | `/reseps/{id}` | Update resep |
| DELETE | `/reseps/{id}` | Hapus resep |
| POST | `/reseps/{id}/favorite` | Toggle favorite |
| GET | `/favorites` | List favorit user |
| GET | `/profile` | Profile user |

---

## 🧪 Testing

```bash
# Run semua tests
php artisan test

# Run specific test
php artisan test tests/Feature/ResepCrudTest.php

# With verbose
php artisan test --verbose
```

---

## 🐛 Troubleshooting

### "SQLSTATE[HY000]" Error
```bash
# Check database configuration di .env
# Pastikan database sudah created
php artisan migrate
```

### CSS Tidak Muncul
```bash
npm run dev
npm run build  # untuk production
php artisan cache:clear
# Kemudian hard refresh di browser (Ctrl+Shift+R)
```

### Images Tidak Muncul
```bash
php artisan storage:link
# Check folder storage/app/public/reseps
```

### Composer Error
```bash
composer install --no-dev  # untuk production
composer update            # update dependencies
```

---

## 📚 Documentation

- [Setup Guide](SETUP.md) - Panduan instalasi detail
- [Laravel Docs](https://laravel.com/docs) - Official Laravel documentation
- [Database Migrations](database/migrations) - Schema definitions

---

## 🔄 Git Workflow

```bash
# Clone
git clone <repo-url>

# Create branch untuk fitur
git checkout -b feature/nama-fitur

# Commit changes
git add .
git commit -m "feat: Deskripsi singkat"

# Push ke GitHub
git push origin feature/nama-fitur

# Create Pull Request di GitHub
```

---

## 🚀 Deployment

Untuk deploy ke production:

```bash
git clone <repo>
cd resep_makanan
composer install --no-dev
npm install && npm run build
cp .env.example .env
# Setup .env dengan database production
php artisan key:generate
php artisan migrate --force
php artisan storage:link
```

**Recommended Hosting:**
- Heroku, Railway, Vercel (untuk PHP apps)
- Shared Hosting dengan PHP 8.1+
- VPS (Ubuntu/Debian)
- Docker

---

## 📄 License

MIT License - See LICENSE file for details

---

## 👥 Contributors

- ALDI
- Maikel Jeremiah Tampa
- Agus Permana
- Wisnu Pradana
- Cienly

---

## 💬 Support & Questions

Jika ada pertanyaan atau error:
1. Check [SETUP.md](SETUP.md) Troubleshooting section
2. Lihat error message di terminal
3. Check application logs: `storage/logs/laravel.log`
4. Open issue di GitHub

---

## 🎉 Acknowledgments

- Laravel Framework
- Font Awesome Icons
- Blade Templating Engine

---

<p align="center">
  Made with ❤️ for food lovers<br>
  <strong>MauMasakApa 2026</strong>
</p>
