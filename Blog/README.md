# Sistem Manajemen Blog (CMS)

Aplikasi web sederhana untuk mengelola penulis, artikel, dan kategori blog. Semua operasi tambah, edit, dan hapus berjalan tanpa memuat ulang halaman.

## Fitur
- **Kelola Penulis**: tambah, edit, dan hapus penulis beserta foto profil. Password disimpan dalam bentuk hash (bcrypt).
- **Kelola Artikel**: tambah, edit, dan hapus artikel dengan gambar, kategori, dan penulis. Hari dan tanggal diisi otomatis (zona waktu Asia/Jakarta).
- **Kelola Kategori**: tambah, edit, dan hapus kategori artikel.
- **Gambar cadangan**: jika foto penulis atau gambar artikel kosong atau hilang, tabel menampilkan gambar pengganti.
- **Pengaman hapus**: penulis dan kategori yang masih memiliki artikel tidak bisa dihapus.

## Teknologi
- PHP 7.4+ (ekstensi `mysqli` dan `fileinfo`)
- MySQL / MariaDB
- HTML, CSS, dan JavaScript (Fetch API)

## Cara Menjalankan
1. Pasang XAMPP (atau server lokal lain), lalu jalankan Apache dan MySQL.
2. Letakkan folder repo di `htdocs`.
3. Buka phpMyAdmin dan impor `db_blog.sql`. File ini membuat database `db_blog` beserta ketiga tabelnya.
4. Sesuaikan `koneksi.php` jika pengaturan MySQL kamu berbeda. Bawaannya: host `localhost`, user `root`, password kosong.
5. Buka `http://localhost/Web-Programming/Blog` di browser.

Tambahkan penulis dan kategori terlebih dahulu, karena artikel membutuhkan keduanya.

## Struktur Database
| Tabel | Isi | Relasi |
|---|---|---|
| `penulis` | nama depan, nama belakang, username (unik), password, foto | |
| `kategori_artikel` | nama kategori (unik), keterangan | |
| `artikel` | judul, isi, gambar, hari dan tanggal | `id_penulis` ke `penulis`, `id_kategori` ke `kategori_artikel` |

## Struktur File
| File | Fungsi |
|---|---|
| `index.php` | Halaman utama: menu, tabel, form modal, dan JavaScript |
| `koneksi.php` | Koneksi ke database |
| `db_blog.sql` | Skrip pembuatan database dan tabel |
| `ambil_*.php` | Menampilkan tabel data (penulis dan kategori juga menyediakan `?format=json`) |
| `ambil_satu_*.php` | Mengambil satu data untuk form edit |
| `simpan_*.php` | Menyimpan data baru |
| `update_*.php` | Memperbarui data |
| `hapus_*.php` | Menghapus data |
| `uploads_penulis/` | Foto profil penulis |
| `uploads_artikel/` | Gambar artikel |

Tanda `*` berarti `penulis`, `artikel`, atau `kategori`.

## Aturan Upload Gambar
- Tipe file: JPEG, PNG, atau GIF (diperiksa dari isi file, bukan dari ekstensinya).
- Ukuran maksimal 2 MB.
- Foto penulis boleh dikosongkan, sedangkan gambar artikel wajib diisi.
- File `.htaccess` di kedua folder upload mencegah file PHP dijalankan dari sana.

## Catatan
Aplikasi ini dibuat untuk tugas kuliah Web Programming dan belum memiliki fitur login, jadi jangan dipasang di server publik.
