# Sistem Karang Taruna - PHP CRUD

Sistem manajemen konten untuk website Karang Taruna dengan fitur CRUD untuk berita/blog dan kegiatan.

## Fitur

- **Autentikasi Login**: Sistem login dengan 2 role (Admin dan User)
- **CRUD Berita/Blog**: Admin dapat mengelola berita dengan lengkap
- **CRUD Kegiatan**: Admin dapat mengelola kegiatan/agenda
- **Dashboard Admin**: Panel admin dengan statistik dan manajemen konten
- **Frontend Responsif**: Tampilan website yang responsif untuk semua perangkat

## Role & Akses

### Admin
- Login ke sistem
- Mengelola berita/blog (Create, Read, Update, Delete)
- Mengelola kegiatan (Create, Read, Update, Delete)
- Mengatur berita utama (featured)
- Upload gambar untuk berita dan kegiatan

### Pengguna Umum
- Melihat website tanpa perlu login
- Membaca berita dan informasi kegiatan
- Melihat galeri kegiatan

## Instalasi di XAMPP

### 1. Persiapan
- Download dan install XAMPP
- Pastikan Apache dan MySQL sudah berjalan

### 2. Setup Database
1. Buka phpMyAdmin (http://localhost/phpmyadmin)
2. Import file `config/init_database.sql` atau jalankan script SQL berikut:

```sql
CREATE DATABASE IF NOT EXISTS karang_taruna;
USE karang_taruna;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_active BOOLEAN DEFAULT TRUE
);

-- News/Blog table
CREATE TABLE IF NOT EXISTS news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    content TEXT NOT NULL,
    excerpt TEXT,
    image_url VARCHAR(255),
    author_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    is_published BOOLEAN DEFAULT TRUE,
    is_featured BOOLEAN DEFAULT FALSE,
    category VARCHAR(50) DEFAULT 'news',
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Activities table
CREATE TABLE IF NOT EXISTS activities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT NOT NULL,
    image_url VARCHAR(255),
    event_date DATETIME,
    location VARCHAR(200),
    author_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    is_published BOOLEAN DEFAULT TRUE,
    activity_type VARCHAR(50) DEFAULT 'event',
    status ENUM('upcoming', 'ongoing', 'completed') DEFAULT 'upcoming',
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Insert default admin user
INSERT INTO users (username, email, password_hash, role) VALUES 
('admin', 'admin@karangtaruna.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');
-- Password: password
```

### 3. Setup Files
1. Copy semua file ke folder `htdocs/karang_taruna/`
2. Pastikan folder `uploads/` memiliki permission write (777)
3. Edit `config/database.php` jika perlu menyesuaikan konfigurasi database

### 4. Akses Website
- Website: http://localhost/karang_taruna/
- Admin Login: http://localhost/karang_taruna/login.php

## Login Default

**Admin:**
- Username: `admin`
- Password: `password`

## Struktur Folder

```
karang_taruna/
├── config/
│   ├── database.php          # Konfigurasi database
│   └── init_database.sql     # Script inisialisasi database
├── includes/
│   ├── auth.php             # Fungsi autentikasi
│   └── functions.php        # Fungsi utility
├── admin/
│   ├── dashboard.php        # Dashboard admin
│   ├── news_crud.php        # CRUD berita
│   └── activity_crud.php    # CRUD kegiatan
├── assets/
│   ├── css/                 # File CSS
│   ├── js/                  # File JavaScript
│   └── images/              # Gambar website
├── uploads/
│   ├── news/                # Upload gambar berita
│   └── activities/          # Upload gambar kegiatan
├── index.php                # Halaman utama
├── login.php                # Halaman login
└── logout.php               # Logout
```

## Teknologi yang Digunakan

- **Backend**: PHP 7.4+
- **Database**: MySQL
- **Frontend**: HTML5, CSS3, JavaScript
- **Framework CSS**: Bootstrap 5.3
- **Icons**: Bootstrap Icons

## Fitur Keamanan

- Password hashing menggunakan PHP `password_hash()`
- Session management untuk autentikasi
- Role-based access control
- Input validation dan sanitization
- File upload validation

## Pengembangan Lebih Lanjut

Sistem ini dapat dikembangkan lebih lanjut dengan menambahkan:
- Sistem komentar
- Newsletter subscription
- Galeri foto yang dinamis
- Sistem notifikasi
- Export data ke PDF/Excel
- API untuk mobile app

## Support

Jika ada pertanyaan atau masalah, silakan hubungi developer atau buat issue di repository ini.

