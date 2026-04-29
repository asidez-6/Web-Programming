<?php
require_once 'koneksi.php';
$id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
if ($id <= 0) {
    echo json_encode([
        'status' => 'gagal',
        'pesan'  => 'ID tidak valid'
    ]);
    exit;
}
$stmt = mysqli_prepare($koneksi,
    "SELECT id, nama, email, pesan, foto FROM kontak WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$hasil = mysqli_stmt_get_result($stmt);
$baris = mysqli_fetch_assoc($hasil);
if ($baris) {
    echo json_encode([
        'status' => 'sukses',
        'data'   => [
            'id'    => $baris['id'],
            'nama'  => htmlspecialchars($baris['nama']),
            'email' => htmlspecialchars($baris['email']),
            'pesan' => htmlspecialchars($baris['pesan']),
            'foto'  => htmlspecialchars($baris['foto'])
        ]
    ]);
} else {
    echo json_encode([
        'status' => 'gagal',
        'pesan'  => 'Data tidak ditemukan'
    ]);
}