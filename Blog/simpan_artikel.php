<?php
include 'koneksi.php';

$judul       = $_POST['judul'] ?? '';
$id_penulis  = $_POST['id_penulis'] ?? 0;
$id_kategori = $_POST['id_kategori'] ?? 0;
$isi         = $_POST['isi'] ?? '';

// Validasi
if (empty($judul) || empty($id_penulis) || empty($id_kategori) || empty($isi)) {
    echo json_encode(['status' => 'gagal', 'pesan' => 'Semua field wajib diisi']);
    exit;
}

// Upload gambar (wajib)
if (!isset($_FILES['gambar']) || $_FILES['gambar']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['status' => 'gagal', 'pesan' => 'Gambar wajib diupload']);
    exit;
}

$file_info = finfo_open(FILEINFO_MIME_TYPE);
$mime_type = finfo_file($file_info, $_FILES['gambar']['tmp_name']);
finfo_close($file_info);

$allowed_types = ['image/jpeg', 'image/png', 'image/gif'];

if (!in_array($mime_type, $allowed_types)) {
    echo json_encode(['status' => 'gagal', 'pesan' => 'Tipe file tidak diizinkan']);
    exit;
}

if ($_FILES['gambar']['size'] > 2 * 1024 * 1024) {
    echo json_encode(['status' => 'gagal', 'pesan' => 'Ukuran file maksimal 2 MB']);
    exit;
}

$ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
$gambar = uniqid() . '.' . $ext;
move_uploaded_file($_FILES['gambar']['tmp_name'], 'uploads_artikel/' . $gambar);

// Generate hari_tanggal
date_default_timezone_set('Asia/Jakarta');
$hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
$bulan = [
    1=>'Januari', 2=>'Februari', 3=>'Maret',
    4=>'April',   5=>'Mei',      6=>'Juni',
    7=>'Juli',    8=>'Agustus',  9=>'September',
    10=>'Oktober',11=>'November',12=>'Desember'
];
$sekarang    = new DateTime();
$nama_hari   = $hari[$sekarang->format('w')];
$tanggal     = $sekarang->format('j');
$nama_bulan  = $bulan[(int)$sekarang->format('n')];
$tahun       = $sekarang->format('Y');
$jam         = $sekarang->format('H:i');
$hari_tanggal = "$nama_hari, $tanggal $nama_bulan $tahun | $jam";

// Simpan
$stmt = mysqli_prepare($koneksi, "INSERT INTO artikel (id_penulis, id_kategori, judul, isi, gambar, hari_tanggal) VALUES (?, ?, ?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "iissss", $id_penulis, $id_kategori, $judul, $isi, $gambar, $hari_tanggal);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(['status' => 'sukses', 'pesan' => 'Data berhasil disimpan']);
} else {
    echo json_encode(['status' => 'gagal', 'pesan' => 'Gagal menyimpan data']);
}