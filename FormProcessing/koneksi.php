<?php
// Membuat jalur koneksi ke server database
$koneksi = mysqli_connect("localhost", "root", "", "db_kontak");
// Cek apakah jalur sudah berhasil dibuat
if (!$koneksi) {
    echo "<script>
            alert('Koneksi ke database gagal: " . mysqli_connect_error() . "');
          </script>";
    die();
}
?>