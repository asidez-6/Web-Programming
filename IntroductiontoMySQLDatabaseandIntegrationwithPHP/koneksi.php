<?php
$koneksi = mysqli_connect("localhost", "root", "", "db_kontak");
if(!$koneksi){
    die("koneksiGagal: ". mysqli_connect_error());
}
?>