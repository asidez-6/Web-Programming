<?php
include 'koneksi.php';

$id = $_POST['id'] ?? 0;

// Cek apakah kategori memiliki artikel
$stmt = mysqli_prepare($koneksi, "SELECT COUNT(*) as jumlah FROM artikel WHERE id_kategori = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

if ($data['jumlah'] > 0) {
    echo json_encode(['status' => 'gagal', 'pesan' => 'Kategori tidak dapat dihapus karena masih memiliki artikel']);
    exit;
}

$stmt = mysqli_prepare($koneksi, "DELETE FROM kategori_artikel WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(['status' => 'sukses', 'pesan' => 'Data berhasil dihapus']);
} else {
    echo json_encode(['status' => 'gagal', 'pesan' => 'Gagal menghapus data']);
}