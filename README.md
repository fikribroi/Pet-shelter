# TemuTeduh – Shelter Management System

> **Aplikasi Web Manajemen Data Hewan Shelter Berbasis Model-View-Controller (MVC) & Pemrograman Berorientasi Objek (OOP) PHP Native**

---

### Proyek Tugas Besar Pemrograman Berorientasi Objek (PBO)

- **Tema 10:** Sistem Manajemen Data Hewan Shelter

---

## 1. Deskripsi Aplikasi

**TemuTeduh** adalah aplikasi web sistem manajemen data hewan shelter yang dibangun untuk membantu pengelola dan relawan penampungan hewan dalam mengelola pendataan satwa, lokasi penampungan (shelter), serta riwayat jenis vaksinasi medis secara terstruktur, aman, dan efisien.

## Aplikasi dirancang dengan memadukan arsitektur **Model-View-Controller (MVC)** dan prinsip **Object-Oriented Programming (OOP)** murni (PHP Native tanpa framework). Desain antarmuka (UI/UX) mengusung tema _Editorial-Modern Naturalist_ (palet hijau hutan, soft mint, aksen amber hangat) yang responsif, interaktif, dan bebas dari tampilan generik

## 2. Fitur Utama Sistem

1. **Dashboard Statistik Aktual & Terpadu:**
   - Ringkasan langsung dari database: Total Hewan Aktif, Total Shelter, dan Jenis Vaksin Tersedia.
   - Tabel data hewan terpadu lengkap dengan nama shelter dan badge jenis-jenis vaksin yang telah diterima.
2. **Pencarian, Filter, & Pengurutan (Sorting):**
   - Pencarian real-time berdasarkan Nama Hewan.
   - Filter data berdasarkan lokasi Shelter.
   - Pengurutan dinamis berdasarkan Nama (A-Z / Z-A), Umur (Termuda / Tertua), atau ID Hewan.
3. **Manajemen Data Hewan (CRUD Lengkap):**
   - Tambah data hewan dengan pemilihan Shelter melalui Dropdown (relasi 1-ke-Banyak).
   - Pemilihan Jenis Vaksin melalui Checkbox interaktif (relasi Banyak-ke-Banyak).
   - Edit data hewan dengan sinkronisasi otomatis tabel relasi menggunakan _Database Transaction_.
   - Hapus data hewan dengan konfirmasi modal yang aman.
4. **Manajemen Data Shelter (CRUD Lengkap):**
   - Menampilkan daftar shelter beserta penghitung jumlah hewan yang dinaungi (`animal_count`).
   - Proteksi penghapusan (_referential integrity_): Shelter yang masih memiliki hewan binaan tidak dapat dihapus sembarangan untuk mencegah data yatim (_orphan records_).
5. **Manajemen Data Vaksin (CRUD Lengkap):**
   - Menampilkan katalog jenis vaksin beserta jumlah hewan yang telah menerima vaksin tersebut.
   - Tambah, edit nama, dan hapus jenis vaksin dengan pembersihan relasi otomatis (_cascade cleanup_).
6. **Interaktivitas & Keamanan:**
   - Konfirmasi modal kustom saat aksi hapus data.
   - Notifikasi toast flash message (sukses/error) yang informatif.
   - Navigasi responsif (Sidebar desktop & Drawer off-canvas mobile).
   - Pengamanan CSRF Token pada setiap form mutasi data (POST).
   - Prepared statements PDO anti SQL Injection dan sanitasi output anti XSS.

---

## 3. Teknologi yang Digunakan

- **Backend:** PHP 8+ Native (OOP Murni, PDO MySQL, Arsitektur MVC)
- **Database:** MySQL / MariaDB (InnoDb Engine, Foreign Key Constraints, Transactions)
- **Frontend:** HTML5, Tailwind CSS (via CDN), Google Fonts (_Manrope_ untuk Heading & _DM Sans_ untuk Body), Lucide Icons (SVG CDN), Vanilla JavaScript.
- **Server:** Apache (XAMPP / Laragon / Standalone PHP Server).

---

## 4. Struktur Database & Relasi Antar Tabel

Database: `temuteduh_db`

### Skema Tabel

```
+---------------------+         +---------------------+
|      shelters       |         |       animals       |
+---------------------+         +---------------------+
| id VARCHAR(10) [PK] |<---+    | id VARCHAR(10) [PK] |<---+
| name VARCHAR(100)   |    |    | name VARCHAR(100)   |    |
+---------------------+    +----| shelter_id (FK)     |    |
                                | age INT             |    |
                                +---------------------+    |
                                                           |
+---------------------+         +---------------------+    |
|      vaccines       |         |   animal_vaccine    |    |
+---------------------+         +---------------------+    |
| id VARCHAR(10) [PK] |<---+    | animal_id (FK) [PK] |----+
| name VARCHAR(100)   |    +----| vaccine_id (FK)[PK] |
+---------------------+         +---------------------+
```

### Penjelasan Relasi

1. **One-to-Many (1 Shelter -> Banyak Hewan):**
   - Satu shelter dapat menampung banyak hewan.
   - Satu hewan hanya terdaftar pada satu shelter penampungan.
   - Kolom penghubung: `animals.shelter_id` mereferensikan `shelters.id`.
   - Aturan Integritas: `ON UPDATE CASCADE ON DELETE RESTRICT` (mencegah penghapusan shelter yang masih menaungi hewan).

2. **Many-to-Many (1 Hewan <-> Banyak Jenis Vaksin):**
   - Satu hewan dapat menerima lebih dari satu jenis vaksin (misalnya Rabies dan Distemper).
   - Satu jenis vaksin dapat diberikan kepada banyak hewan.
   - Diimplementasikan melalui tabel perantara (_pivot table_): `animal_vaccine`.
   - _Composite Primary Key_: `(animal_id, vaccine_id)`.
   - Aturan Integritas: `ON DELETE CASCADE` (menghapus hewan atau jenis vaksin akan otomatis membersihkan relasi terkait tanpa meninggalkan data yatim).

---

## 5. Implementasi 4 Konsep Pemrograman Berorientasi Objek (OOP)

Implementasi OOP dirancang sederhana, elegan, dan mudah dijelaskan di hadapan dosen penguji:

### A. Abstraction (Abstraksi)

- **Implementasi:** Kelas abstrak `BaseModel` dan `BaseController`.
- **Lokasi Kode:** `app/core/BaseModel.php` dan `app/core/BaseController.php`.
- **Fungsi:** Menyembunyikan kompleksitas eksekusi query PDO, koneksi database, dan mekanisme HTTP. Kelas turunan cukup berfokus pada logika bisnis datanya.
- **Contoh di Kode:**
  ```php
  abstract class BaseModel {
      protected PDO $db;
      abstract public function findAll(): array;
      abstract public function findById(string $id): ?array;
      // ...
  }
  ```

### B. Inheritance (Pewarisan)

- **Implementasi:** Semua model dan controller mewarisi fungsionalitas umum dari kelas induk (_Base class_).
- **Hirarki:**
  - `AnimalModel extends BaseModel`
  - `ShelterModel extends BaseModel`
  - `VaccineModel extends BaseModel`
  - `AnimalController extends BaseController`
  - `ShelterController extends BaseController`
  - `VaccineController extends BaseController`
  - `DashboardController extends BaseController`
- **Fungsi:** Mencegah duplikasi kode (_Don't Repeat Yourself_), seperti penggunaan koneksi database bersama, method `query()`, `render()`, `setFlash()`, dan `validateCsrfToken()`.

### C. Polymorphism (Polimorfisme / Method Overriding)

- **Implementasi:** _Method Overriding_ pada method `findAll()` dan `findById()`.
- **Penjelasan:** Method yang sama dideklarasikan pada kelas induk `BaseModel`, namun masing-masing model turunan mengimplementasikannya secara berbeda sesuai kebutuhan relasinya:
  - Pada `AnimalModel`: `findAll()` melakukan `JOIN` ke tabel `shelters` dan `animal_vaccine` serta `GROUP_CONCAT` untuk menggabungkan daftar vaksin.
  - Pada `ShelterModel`: `findAll()` melakukan `LEFT JOIN` ke tabel `animals` dan menghitung `COUNT(animals.id) AS animal_count`.
  - Pada `VaccineModel`: `findAll()` menghitung jumlah hewan yang telah divaksinasi.

### D. Encapsulation (Enkapsulasi)

- **Implementasi:** Pembatasan hak akses properti dengan `private` dan `protected`.
- **Penjelasan:**
  - Properti koneksi database `$db`, nama tabel `$table`, dan `$primaryKey` bersifat `protected` di dalam `BaseModel` sehingga tidak dapat diakses atau dimanipulasi langsung secara sembarangan dari luar model.
  - Akses data dilakukan secara terkontrol melalui method publik (`create()`, `update()`, `delete()`, `findById()`).
  - Mencegah kebocoran struktur internal sistem ke lapisan View.

---

## 6. Struktur Direktori Proyek (MVC)

```
pet shelter/
│
├── app/
│   ├── core/                        # Komponen Fondasi Inti Aplikasi
│   │   ├── Database.php             # Singleton Koneksi PDO MySQL
│   │   ├── Router.php               # Mekanisme Routing HTTP & Helper URL
│   │   ├── BaseModel.php            # Abstract Class Model (Abstraction & Encapsulation)
│   │   └── BaseController.php       # Abstract Class Controller (View Renderer, Flash, CSRF)
│   │
│   ├── models/                      # Lapisan Model (Pengelolaan Data & Query)
│   │   ├── AnimalModel.php          # Query CRUD Hewan & Transaksi Relasi Vaksin
│   │   ├── ShelterModel.php         # Query CRUD Shelter & Pengecekan Relasi Hewan
│   │   └── VaccineModel.php         # Query CRUD Jenis Vaksin
│   │
│   ├── controllers/                 # Lapisan Controller (Penanganan Request & Logika Bisnis)
│   │   ├── DashboardController.php  # Menangani Halaman Utama, Statistik, Filter & Sort
│   │   ├── AnimalController.php     # Menangani Alur CRUD Data Hewan
│   │   ├── ShelterController.php    # Menangani Alur CRUD Data Shelter
│   │   └── VaccineController.php    # Menangani Alur CRUD Data Vaksin
│   │
│   └── views/                       # Lapisan Tampilan Antarmuka (HTML + PHP)
│       ├── layouts/
│       │   └── main.php             # Master Layout (Sidebar, Drawer Mobile, Navbar, Modal)
│       ├── dashboard/
│       │   └── index.php            # View Dashboard Utama & Tabel Hewan
│       ├── animals/
│       │   ├── create.php           # Form Tambah Hewan (Dropdown Shelter & Checkbox Vaksin)
│       │   └── edit.php             # Form Edit Hewan
│       ├── shelters/
│       │   ├── index.php            # Daftar Shelter
│       │   ├── create.php           # Form Tambah Shelter
│       │   └── edit.php             # Form Edit Shelter
│       └── vaccines/
│           ├── index.php            # Daftar Vaksin
│           ├── create.php           # Form Tambah Vaksin
│           └── edit.php             # Form Edit Vaksin
│
├── config/
│   └── database.php                 # Konfigurasi Kredensial Database
│
├── database/
│   └── temuteduh_db.sql             # Skema DDL Database & Sample Data Lengkap
│
├── public/                          # Public Web Root
│   ├── index.php                    # Front Controller Utama
│   └── assets/
│       ├── css/
│       │   └── app.css              # Custom Styling & Desain Token
│       └── js/
│           └── app.js               # Interaktivitas JS (Modal, Drawer, Toast, Icons)
│
├── index.php                        # Root Entry Point (Kompatibilitas Instan XAMPP)
└── README.md                        # Dokumentasi Lengkap Proyek Tugas Besar
```

---

## 7. Panduan Instalasi & Menjalankan Aplikasi

### Langkah 1: Persiapan File

Pastikan folder proyek berada di dalam direktori `htdocs` XAMPP Anda:
`C:\xampp\htdocs\pet shelter`

### Langkah 2: Menjalankan MySQL & Apache

1. Buka **XAMPP Control Panel**.
2. Klik **Start** pada modul **Apache** dan **MySQL**.

### Langkah 3: Impor Database `temuteduh_db`

Ada dua cara mudah:

- **Cara A: Melalui phpMyAdmin (Browser)**
  1. Buka browser dan kunjungi `http://localhost/phpmyadmin/`.
  2. Klik menu **Import**.
  3. Pilih file `database/temuteduh_db.sql` dari folder proyek.
  4. Klik tombol **Go / Kirim** di bagian bawah.

- **Cara B: Melalui Terminal / Command Prompt**
  ```bash
  mysql -u root -p < "C:\xampp\htdocs\pet shelter\database\temuteduh_db.sql"
  ```

### Langkah 4: Membuka Aplikasi di Browser

Buka browser favorit Anda (Google Chrome / Edge / Firefox) dan akses:

```
http://localhost/pet shelter/
```

atau

```
http://localhost/pet shelter/public/
```

Sistem akan langsung terbuka dan siap digunakan untuk demo tugas besar!

---

## 8. Panduan Pengujian Fitur untuk Demo / Presentasi

1. **Demo Relasi One-to-Many (Shelter & Hewan):**
   - Masuk ke menu **Tambah Hewan Baru**.
   - Tunjukkan bahwa kolom **Shelter** berbentuk Dropdown yang datanya otomatis ditarik dari tabel `shelters`.
   - Buka menu **Daftar Shelter**, tunjukkan kolom **Jumlah Hewan** yang terhitung secara otomatis (`COUNT`).
   - Coba hapus shelter yang masih memiliki hewan (misal: _Shelter Melati Harmoni_). Sistem akan menolak penghapusan dengan pesan ramah pengguna untuk menjaga integritas data.

2. **Demo Relasi Many-to-Many (Hewan & Vaksin):**
   - Saat menambah/edit hewan, tunjukkan kolom **Jenis Vaksin** berbentuk Checkbox di mana satu hewan dapat dicentang banyak vaksin (misal: Rabies + Distemper).
   - Simpan data, lalu tunjukkan pada tabel dashboard bahwa vaksin hewan tersebut tampil rapi dalam bentuk pill badges.
   - Buka menu **Daftar Vaksin**, tunjukkan kolom **Jumlah Hewan Tervaksinasi** yang mencerminkan data aktual tabel pivot `animal_vaccine`.

3. **Demo Database Transaction (Keamanan Mutasi Data):**
   - Jelaskan bahwa saat mengedit atau menambahkan hewan, operasi ke tabel `animals` dan tabel perantara `animal_vaccine` dibungkus dalam blok `beginTransaction()`, `commit()`, dan `rollBack()` pada `AnimalModel.php` sehingga data dijamin selalu konsisten.
