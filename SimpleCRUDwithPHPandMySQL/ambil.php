<?php

require_once 'koneksi.php';

$stmt = mysqli_prepare($koneksi, "SELECT id, nama, email, pesan, foto FROM kontak ORDER BY id DESC");

mysqli_stmt_execute($stmt);
$hasil = mysqli_stmt_get_result($stmt);

$data =[];
while ($baris = mysqli_fetch_assoc($hasil)) {
    $data[] = [
        'id'    => $baris['id'],
        'nama'  => htmlspecialchars($baris['nama']),
        'email' => htmlspecialchars($baris['email']),
        'pesan' => htmlspecialchars($baris['pesan']),
        'foto'  => htmlspecialchars($baris['foto'])
    ];
}
echo json_encode($data);