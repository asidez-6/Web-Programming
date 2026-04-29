# Sistem Manajemen Blog (CMS)

Aplikasi web untuk mengelola blog dengan fitur CRUD penulis, artikel, dan kategori secara asynchronous.

## Fitur Utama

- 📝 **Kelola Penulis** - Tambah, edit, hapus penulis dengan foto profil dan enkripsi password
- 📄 **Kelola Artikel** - Tambah, edit, hapus artikel dengan upload gambar dan timestamp otomatis
- 📂 **Kelola Kategori** - Tambah, edit, hapus kategori artikel
- ⚡ **Asynchronous** - Semua operasi berjalan tanpa reload halaman (Fetch API)
- 🔒 **Keamanan** - Prepared statements, validasi file, proteksi folder upload

## Teknologi

- PHP 7.4+
- MySQL / MariaDB
- JavaScript (Vanilla)
- Fetch API

## Instalasi

1. **Clone atau download file "/Blog" dalam repository ini**

2. **Import database**
   Buka phpMyAdmin → Import file db_blog.sql
   Atau jalankan SQL di `db_blog.sql` melalui tab SQL phpMyAdmin

3. **Konfigurasi koneksi database**
   Edit file `koneksi.php`:
   $host = "localhost";  // host database
   $user = "root";       // username database
   $pass = "";           // password database
   $db   = "db_blog";    // nama database
4. **Pindahkan folder ke web server**
   
   Copy folder blog/ ke htdocs (XAMPP) atau www (Laragon)
5. **Jalankan aplikasi**
   
   Buka browser → http://localhost/blog/
   

## Struktur Folder

blog/
├── index.php              # Halaman utama aplikasi
├── koneksi.php            # Konfigurasi koneksi database
├── db_blog.sql            # File SQL database
│
├── ambil_penulis.php      # API - Menampilkan data penulis
├── simpan_penulis.php     # API - Menambah penulis baru
├── update_penulis.php     # API - Mengupdate penulis
├── hapus_penulis.php      # API - Menghapus penulis
├── ambil_satu_penulis.php # API - Mengambil satu penulis
│
├── ambil_artikel.php      # API - Menampilkan data artikel
├── simpan_artikel.php     # API - Menambah artikel baru
├── update_artikel.php     # API - Mengupdate artikel
├── hapus_artikel.php      # API - Menghapus artikel
├── ambil_satu_artikel.php # API - Mengambil satu artikel
│
├── ambil_kategori.php      # API - Menampilkan data kategori
├── simpan_kategori.php     # API - Menambah kategori baru
├── update_kategori.php     # API - Mengupdate kategori
├── hapus_kategori.php      # API - Menghapus kategori
├── ambil_satu_kategori.php # API - Mengambil satu kategori
│
├── uploads_penulis/       # Folder upload foto penulis
│   ├── .htaccess          # Proteksi akses file PHP
│   └── default.png        # Foto default penulis
│
└── uploads_artikel/       # Folder upload gambar artikel
    └── .htaccess          # Proteksi akses file PHP

## Penggunaan

1. **Kelola Penulis** - Klik menu "Kelola Penulis" di sidebar kiri
2. **Kelola Artikel** - Klik menu "Kelola Artikel" di sidebar kiri
3. **Kelola Kategori** - Klik menu "Kelola Kategori" di sidebar kiri

Setiap menu memiliki tombol **Tambah**, **Edit**, dan **Hapus** data.

## Catatan Penting

- Password penulis dienkripsi menggunakan **BCRYPT**
- Gambar artikel **wajib diupload** saat menambah data baru
- Penulis/kategori **tidak bisa dihapus** jika masih memiliki artikel
- Ukuran file upload **maksimal 2 MB**
- Format file yang diizinkan: **JPG, PNG, GIF**
- Folder `uploads_penulis/` dan `uploads_artikel/` harus **writable**

## Lisensi

Proyek ini dibuat untuk keperluan UTS Pemrograman Web. Bebas digunakan dan dimodifikasi.

Simpan file tersebut dengan nama `README.md` di root folder `blog/`. README ini mencakup semua informasi penting yang dibutuhkan untuk menjalankan aplikasi CMS Anda.