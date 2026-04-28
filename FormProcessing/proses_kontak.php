<?php
//memanggil kode program koneksi
include 'koneksi.php';
// Menangkap data dari variabel superglobal $_POST
$nama  = $_POST['nama'];
$email = $_POST['email'];
$pesan = $_POST['pesan'];
// Data kini telah tersimpan dalam variabel dan siap untuk diproses

// Menjalankan perintah penyimpanan jika data tidak kosong
if (!empty($nama) && !empty($email) && !empty($pesan)) {
    $simpan = "INSERT INTO kontak (nama, email, pesan) 
               VALUES ('$nama', '$email', '$pesan')";
    
    if (mysqli_query($koneksi, $simpan)) {
        // Mengirim balik data dalam format JSON jika sukses
        echo json_encode([
            'status' => 'sukses',
            'nama'   => $nama,
            'email'  => $email,
            'pesan'  => $pesan
        ]);
    } else {
        echo json_encode(['status' => 'gagal']);
    }
}
?> 