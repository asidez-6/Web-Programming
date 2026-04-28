<?php
require_once 'koneksi.php';
$nama  = $_POST['nama'];
$email = $_POST['email'];
$pesan = $_POST['pesan'];
if (!empty($nama) && !empty($email) && !empty($pesan)) {
   
    $stmt = mysqli_prepare($koneksi, "INSERT INTO kontak (nama, email, pesan) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sss", $nama, $email, $pesan);
   
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode([
            'status'  => 'sukses',
            'pesan'   => 'Data berhasil disimpan'
        ]);
    } else {
        echo json_encode([
            'status'  => 'gagal',
            'pesan'   => 'Data gagal disimpan'
        ]);
    }
} else {
    echo json_encode([
        'status'  => 'gagal',
        'pesan'   => 'Semua kolom harus diisi'
    ]);
}
?>