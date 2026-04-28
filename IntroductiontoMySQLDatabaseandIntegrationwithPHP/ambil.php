<?php
require_once 'koneksi.php';
$stmt = mysqli_prepare($koneksi,
    "SELECT nama, email, pesan FROM kontak ORDER BY id DESC");
mysqli_stmt_execute($stmt);
$hasil = mysqli_stmt_get_result($stmt);
$data = [];
while ($baris = mysqli_fetch_assoc($hasil)) {
    $data[] = [
        'nama'  => htmlspecialchars($baris['nama']),
        'email' => htmlspecialchars($baris['email']),
        'pesan' => htmlspecialchars($baris['pesan'])
    ];
}
echo json_encode($data);
?>