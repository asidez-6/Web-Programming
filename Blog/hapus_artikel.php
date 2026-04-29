<?php
include 'koneksi.php';

$id = $_POST['id'] ?? 0;

// Ambil data gambar
$stmt = mysqli_prepare($koneksi, "SELECT gambar FROM artikel WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

// Hapus data
$stmt = mysqli_prepare($koneksi, "DELETE FROM artikel WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    // Hapus file gambar
    if (file_exists('uploads_artikel/' . $data['gambar'])) {
        unlink('uploads_artikel/' . $data['gambar']);
    }
    echo json_encode(['status' => 'sukses', 'pesan' => 'Data berhasil dihapus']);
} else {
    echo json_encode(['status' => 'gagal', 'pesan' => 'Gagal menghapus data']);
}