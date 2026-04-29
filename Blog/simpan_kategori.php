<?php
include 'koneksi.php';

$nama_kategori = $_POST['nama_kategori'] ?? '';
$keterangan    = $_POST['keterangan'] ?? '';

if (empty($nama_kategori)) {
    echo json_encode(['status' => 'gagal', 'pesan' => 'Nama kategori wajib diisi']);
    exit;
}

$stmt = mysqli_prepare($koneksi, "INSERT INTO kategori_artikel (nama_kategori, keterangan) VALUES (?, ?)");
mysqli_stmt_bind_param($stmt, "ss", $nama_kategori, $keterangan);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(['status' => 'sukses', 'pesan' => 'Data berhasil disimpan']);
} else {
    if (mysqli_errno($koneksi) == 1062) {
        echo json_encode(['status' => 'gagal', 'pesan' => 'Nama kategori sudah ada']);
    } else {
        echo json_encode(['status' => 'gagal', 'pesan' => 'Gagal menyimpan data']);
    }
}