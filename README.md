### Proyek Tugas Besar Pemrograman Berorientasi Objek (PBO)
# TemuTeduh – Shelter Management System

TemuTeduh adalah aplikasi web sederhana untuk mengelola pendataan hewan di shelter atau rumah penampungan satwa. Aplikasi ini dibangun menggunakan PHP murni (tanpa framework) dengan menerapkan arsitektur MVC (Model-View-Controller) dan konsep Pemrograman Berorientasi Objek (PBO).


Aplikasi ini mencakup beberapa fungsi utama:

1. **Dashboard & Ringkasan Data**
   - Memantau total hewan yang sedang dirawat, jumlah shelter aktif, dan jenis vaksin yang tersedia secara langsung dari database.
   - Menampilkan tabel data hewan lengkap dengan lokasi shelter dan daftar vaksin yang sudah diterima.

2. **Pencarian, Filter, & Urutan Data**
   - Mencari data hewan berdasarkan nama.
   - Menyaring (filter) daftar hewan berdasarkan lokasi shelter tertentu.
   - Mengurutkan tabel berdasarkan nama hewan (A-Z / Z-A) atau umur (termuda / tertua).

3. **Kelola Data Hewan (CRUD)**
   - Menambahkan hewan baru: memilih lokasi shelter lewat dropdown dan mencentang satu atau lebih jenis vaksin yang sudah diterima (relasi banyak-ke-banyak).
   - Mengedit identitas hewan, lokasi penempatan, serta memperbarui riwayat vaksinnya.
   - Menghapus data hewan yang sudah keluar atau diadopsi.

4. **Kelola Data Shelter**
   - Menambahkan lokasi shelter baru dan mengubah namanya.
   - Melihat jumlah hewan yang sedang ditampung di setiap shelter secara otomatis.
   - Menghapus shelter (dilengkapi proteksi keamanan: shelter yang masih menampung hewan tidak bisa dihapus sembarangan).

5. **Kelola Katalog Vaksin**
   - Menambahkan jenis vaksin medis satwa ke dalam sistem (misal: Rabies, Distemper, Parvovirus).
   - Melihat berapa ekor hewan yang sudah menerima vaksin tersebut.
   - Mengubah nama vaksin atau menghapus jenis vaksin dari katalog.

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
