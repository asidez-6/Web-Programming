<?php
require_once 'koneksi.php';
$id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
// Validasi id
if ($id <= 0) {
    echo json_encode([
        'status' => 'gagal',
        'pesan'  => 'ID tidak valid'
    ]);
    exit;
}
// Ambil nama file foto dari database sebelum data dihapus
$stmt = mysqli_prepare($koneksi,
    "SELECT foto FROM kontak WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$hasil = mysqli_stmt_get_result($stmt);
$baris = mysqli_fetch_assoc($hasil);
if (!$baris) {
    echo json_encode([
        'status' => 'gagal',
        'pesan'  => 'Data tidak ditemukan'
    ]);
    exit;
}
$foto = $baris['foto'];
// Hapus data dari database
$stmt = mysqli_prepare($koneksi,
    "DELETE FROM kontak WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
if (mysqli_stmt_execute($stmt)) {
    // Hapus file foto dari folder uploads/
    if (file_exists('uploads/' . $foto)) {
        unlink('uploads/' . $foto);
    }
    echo json_encode([
        'status' => 'sukses',
        'pesan'  => 'Data berhasil dihapus'
    ]);
} else {
    echo json_encode([
        'status' => 'gagal',
        'pesan'  => 'Data gagal dihapus'
    ]);
}