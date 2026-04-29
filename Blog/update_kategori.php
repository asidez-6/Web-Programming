<?php
include 'koneksi.php';

$id            = $_POST['id'] ?? 0;
$nama_kategori = $_POST['nama_kategori'] ?? '';
$keterangan    = $_POST['keterangan'] ?? '';

if (empty($nama_kategori)) {
    echo json_encode(['status' => 'gagal', 'pesan' => 'Nama kategori wajib diisi']);
    exit;
}

$stmt = mysqli_prepare($koneksi, "UPDATE kategori_artikel SET nama_kategori=?, keterangan=? WHERE id=?");
mysqli_stmt_bind_param($stmt, "ssi", $nama_kategori, $keterangan, $id);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(['status' => 'sukses', 'pesan' => 'Data berhasil diupdate']);
} else {
    if (mysqli_errno($koneksi) == 1062) {
        echo json_encode(['status' => 'gagal', 'pesan' => 'Nama kategori sudah ada']);
    } else {
        echo json_encode(['status' => 'gagal', 'pesan' => 'Gagal mengupdate data']);
    }
}