# 📚 Perpustakaan Digital (PerpusDigital)

Sistem Informasi Manajemen Perpustakaan berbasis web yang dibangun dengan framework **Laravel 12** dan **PHP 8.3**. Proyek ini dirancang untuk memenuhi kebutuhan digitalisasi perpustakaan dengan fitur sirkulasi buku yang lengkap, sistem denda otomatis, dan keamanan navigasi.

---

## 🛠️ Tech Stack
* **Framework:** Laravel 12
* **Database:** MySQL 8.4
* **Language:** PHP 8.3
* **Frontend:** Bootstrap 5 & Blade Templating
* **Security:** Custom Middleware (PreventBackHistory)

---

## ✨ Fitur Utama
* **Multi-Role Authentication**: Hak akses berbeda untuk Administrator, Petugas, dan Peminjam.
* **Dashboard Statistik**: Ringkasan data total transaksi, status buku, dan estimasi denda secara real-time.
* **Manajemen Koleksi**: CRUD Buku dan Kategori Buku secara dinamis.
* **Sirkulasi Buku**: Sistem peminjaman mandiri bagi user dengan filter tanggal.
* **Fitur Cetak (Print)**: Laporan sirkulasi yang dioptimalkan untuk format cetak fisik (bersih dari navigasi).
* **Security Guard**: Implementasi proteksi history browser untuk mencegah akses kembali setelah logout.

---

## 📸 Preview Halaman

### Welcome Screen
![Welcome Screen](https://github.com/user-attachments/assets/c083f9bc-5df8-4826-a559-892fb775a09b)

### Interface Overview
| Halaman Login | Koleksi Buku (Admin) |
| :---: | :---: |
| ![Login Page](https://github.com/user-attachments/assets/cd578be8-2e33-45a7-80c9-affe0acaa6a9) | ![Data Buku](https://github.com/user-attachments/assets/ee101bf0-8b71-4217-94a7-f8cb8e895cc3) |

| Laporan Peminjaman | Dashboard Peminjam |
| :---: | :---: |
| ![Laporan](https://github.com/user-attachments/assets/46a24c6a-5321-46fb-b812-36b98f93d5aa) | ![Dashboard](https://github.com/user-attachments/assets/e2b4b1db-0732-4231-87e6-322c7e8858d8) |

---

## 📂 Struktur Database
Proyek ini menggunakan skema database relasional sebagai berikut:



* **`users`**: Mengelola data pengguna dan hak akses (`administrator`, `petugas`, `peminjam`).
* **`bukus`**: Menyimpan detail buku, penulis, dan penerbit.
* **`kategoribukus`**: Tabel referensi untuk kategori buku.
* **`peminjamans`**: Mencatat setiap transaksi, tanggal deadline, dan status pengembalian.

---

## 🚀 Instalasi & Konfigurasi

### 1. Clone & Install
```bash
git clone [https://github.com/ReyGHz413/Perpustakaan.git](https://github.com/ReyGHz413/Perpustakaan.git)
cd Perpustakaan
composer install
npm install && npm run dev

```

### 2. Konfigurasi Database

* Buat database baru bernama `perpus` di MySQL.
* Duplikat file `.env.example` menjadi `.env`.
* Sesuaikan kredensial database Anda pada file `.env`.

### 3. Import Data

Gunakan file `perpus (2).sql` yang tersedia di root folder dan import ke database `perpus` Anda menggunakan phpMyAdmin atau command line:

```bash
mysql -u root -p perpus < "perpus (2).sql"

```

### 4. Menjalankan Aplikasi

```bash
php artisan key:generate
php artisan serve

```

---

## 🔑 Akun Uji Coba (Demo)

| Role | Username | Password |
| --- | --- | --- |
| **Administrator** | `admin_perpus` | `password` |
| **Petugas** | `sasa` | `password` |
| **Peminjam** | `rey` | `password` |

---

## 📝 Catatan Penting

* **Kalkulasi Denda**: Denda dihitung otomatis berdasarkan selisih hari keterlambatan dengan tarif **Rp 2.000/hari**.
* **Fix View Error**: Jika muncul pesan `View not found`, jalankan perintah `php artisan view:clear` dan `php artisan route:clear`.

---

**Developed by [ReyGHz413**](https://www.google.com/search?q=https://github.com/ReyGHz413)
