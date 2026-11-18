### Proyek Tugas Besar Pemrograman Berorientasi Objek (PBO)
# TemuTeduh – Shelter Management System

> **Aplikasi Web Manajemen Data Hewan Shelter Berbasis Model-View-Controller (MVC) & Pemrograman Berorientasi Objek (OOP) PHP Native**

---

### Proyek Tugas Besar Pemrograman Berorientasi Objek (PBO)

**Program Studi Sistem Informasi — Fakultas Teknik — Universitas Bengkulu**  
**Tahun Akademik 2024/2025**
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
   - Menampilkan daftar shelter beserta penghitung jumlah hewan yang dinaungi.
   - Proteksi penghapusan (_referential integrity_): Shelter yang masih memiliki hewan binaan tidak dapat dihapus sembarangan untuk mencegah orphan records.
5. **Manajemen Data Vaksin (CRUD Lengkap):**
   - Menampilkan katalog jenis vaksin beserta jumlah hewan yang telah menerima vaksin tersebut.
   - Tambah, edit nama, dan hapus jenis vaksin dengan pembersihan relasi otomatis (_cascade cleanup_).
6. **Interaktivitas & Keamanan:**
   - Konfirmasi modal kustom saat aksi hapus data.
   - Notifikasi toast flash message (sukses/error) yang informatif.
   - Navigasi responsif (Sidebar desktop & Drawer off-canvas mobile).
   - Pengamanan CSRF Token pada setiap form mutasi data (POST).
   - Prepared statements PDO anti SQL Injection dan sanitasi output anti XSS.


## Goals (Tujuan Proyek)

Proyek ini dibuat untuk mencapai beberapa tujuan:

1. **Mempermudah Pengelolaan Shelter:** Membantu petugas atau relawan mendata satwa binaan, memantau kapasitas lokasi shelter, dan mencatat riwayat vaksinasi setiap hewan agar tidak tercecer.
2. **Penerapan Konsep PBO Secara Nyata:** Mengimplementasikan 4 pilar Pemrograman Berorientasi Objek (Abstraction, Inheritance, Polymorphism, dan Encapsulation) secara langsung pada kode PHP Native tanpa bantuan framework.
3. **Penerapan Pola Desain MVC:** Memisahkan struktur kode menjadi Model (kelola query database), View (tampilan antarmuka), dan Controller (pengatur alur logika) agar rapi dan mudah dikembangkan.
4. **Menjaga Integritas Relasi Database:** Menerapkan relasi antar-tabel yang aman (One-to-Many antara shelter dan hewan, serta Many-to-Many antara hewan dan vaksin melalui tabel pivot) menggunakan database transaction agar data selalu konsisten.
