<?php
include 'koneksi.php';

$id = $_POST['id'] ?? 0;

// Cek apakah penulis memiliki artikel
$stmt = mysqli_prepare($koneksi, "SELECT COUNT(*) as jumlah FROM artikel WHERE id_penulis = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

if ($data['jumlah'] > 0) {
    echo json_encode(['status' => 'gagal', 'pesan' => 'Penulis tidak dapat dihapus karena masih memiliki artikel']);
    exit;
}

// Ambil data foto
$stmt = mysqli_prepare($koneksi, "SELECT foto FROM penulis WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

// Hapus data
$stmt = mysqli_prepare($koneksi, "DELETE FROM penulis WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    // Hapus foto jika bukan default
    if ($data['foto'] != 'default.png' && file_exists('uploads_penulis/' . $data['foto'])) {
        unlink('uploads_penulis/' . $data['foto']);
    }
    echo json_encode(['status' => 'sukses', 'pesan' => 'Data berhasil dihapus']);
} else {
    echo json_encode(['status' => 'gagal', 'pesan' => 'Gagal menghapus data']);
}