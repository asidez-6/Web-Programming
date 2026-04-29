<?php
include 'koneksi.php';

$nama_depan    = $_POST['nama_depan'] ?? '';
$nama_belakang = $_POST['nama_belakang'] ?? '';
$user_name     = $_POST['user_name'] ?? '';
$password      = $_POST['password'] ?? '';

// Validasi input
if (empty($nama_depan) || empty($nama_belakang) || empty($user_name) || empty($password)) {
    echo json_encode(['status' => 'gagal', 'pesan' => 'Semua field wajib diisi']);
    exit;
}

// Enkripsi password
$password_hash = password_hash($password, PASSWORD_BCRYPT);

// Upload foto
$foto = 'default.png';
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $file_info = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($file_info, $_FILES['foto']['tmp_name']);
    finfo_close($file_info);
    
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    
    if (!in_array($mime_type, $allowed_types)) {
        echo json_encode(['status' => 'gagal', 'pesan' => 'Tipe file tidak diizinkan']);
        exit;
    }
    
    if ($_FILES['foto']['size'] > 2 * 1024 * 1024) {
        echo json_encode(['status' => 'gagal', 'pesan' => 'Ukuran file maksimal 2 MB']);
        exit;
    }
    
    $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $foto = uniqid() . '.' . $ext;
    move_uploaded_file($_FILES['foto']['tmp_name'], 'uploads_penulis/' . $foto);
}

// Simpan ke database
$stmt = mysqli_prepare($koneksi, "INSERT INTO penulis (nama_depan, nama_belakang, user_name, password, foto) VALUES (?, ?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "sssss", $nama_depan, $nama_belakang, $user_name, $password_hash, $foto);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(['status' => 'sukses', 'pesan' => 'Data berhasil disimpan']);
} else {
    if (mysqli_errno($koneksi) == 1062) {
        echo json_encode(['status' => 'gagal', 'pesan' => 'Username sudah digunakan']);
    } else {
        echo json_encode(['status' => 'gagal', 'pesan' => 'Gagal menyimpan data']);
    }
}