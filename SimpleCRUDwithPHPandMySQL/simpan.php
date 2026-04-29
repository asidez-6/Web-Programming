<?php
require_once 'koneksi.php';

$nama  = $_POST['nama'];
$email = $_POST['email'];
$pesan = $_POST['pesan'];

// 1. Validasi field teks (PERBAIKAN: gunakan empty() tanpa "!")
if (empty($nama) || empty($email) || empty($pesan)) {
    echo json_encode([
        'status' => 'gagal',
        'pesan'  => 'Semua kolom harus diisi'
    ]);
    exit;
}

// 2. Validasi file foto
if (!isset($_FILES['foto']) || $_FILES['foto']['error'] !== 0) {
    echo json_encode([
        'status' => 'gagal',
        'pesan'  => 'Foto harus diunggah'
    ]);
    exit;
}

$tipe_diizinkan = ['image/jpeg', 'image/png', 'image/gif'];
if (!in_array($_FILES['foto']['type'], $tipe_diizinkan)) {
    echo json_encode([
        'status' => 'gagal',
        'pesan'  => 'Tipe file tidak diizinkan'
    ]);
    exit;
}

$ukuran_max = 2 * 1024 * 1024; // 2 MB
if ($_FILES['foto']['size'] > $ukuran_max) {
    echo json_encode([
        'status' => 'gagal',
        'pesan'  => 'Ukuran file tidak boleh lebih dari 2 MB'
    ]);
    exit;
}

// 3. Proses upload foto
$ekstensi  = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
$nama_file = uniqid() . '.' . $ekstensi;
$tujuan    = 'uploads/' . $nama_file;

if (!move_uploaded_file($_FILES['foto']['tmp_name'], $tujuan)) {
    echo json_encode([
        'status' => 'gagal',
        'pesan'  => 'Foto gagal diunggah'
    ]);
    exit;
}

// 4. Simpan data ke database (hanya satu output di sini)
$stmt = mysqli_prepare($koneksi, 
    "INSERT INTO kontak (nama, email, pesan, foto) VALUES (?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "ssss", $nama, $email, $pesan, $nama_file);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode([
        'status' => 'sukses',
        'pesan'  => 'Data berhasil disimpan'
    ]);
} else {
    // Hapus file yang sudah terupload jika insert gagal
    unlink($tujuan);
    echo json_encode([
        'status' => 'gagal',
        'pesan'  => 'Gagal menyimpan data: ' . mysqli_error($koneksi)
    ]);
}