<?php
include 'koneksi.php';

$id            = $_POST['id'] ?? 0;
$nama_depan    = $_POST['nama_depan'] ?? '';
$nama_belakang = $_POST['nama_belakang'] ?? '';
$user_name     = $_POST['user_name'] ?? '';
$password      = $_POST['password'] ?? '';

if (empty($nama_depan) || empty($nama_belakang) || empty($user_name)) {
    echo json_encode(['status' => 'gagal', 'pesan' => 'Field nama dan username wajib diisi']);
    exit;
}

// Ambil data lama
$stmt = mysqli_prepare($koneksi, "SELECT foto FROM penulis WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data_lama = mysqli_fetch_assoc($result);
$foto = $data_lama['foto'];

// Upload foto baru jika ada
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
    
    // Hapus foto lama jika bukan default
    if ($foto != 'default.png' && file_exists('uploads_penulis/' . $foto)) {
        unlink('uploads_penulis/' . $foto);
    }
    
    $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $foto = uniqid() . '.' . $ext;
    move_uploaded_file($_FILES['foto']['tmp_name'], 'uploads_penulis/' . $foto);
}

// Update data
if (!empty($password)) {
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    $stmt = mysqli_prepare($koneksi, "UPDATE penulis SET nama_depan=?, nama_belakang=?, user_name=?, password=?, foto=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "sssssi", $nama_depan, $nama_belakang, $user_name, $password_hash, $foto, $id);
} else {
    $stmt = mysqli_prepare($koneksi, "UPDATE penulis SET nama_depan=?, nama_belakang=?, user_name=?, foto=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "ssssi", $nama_depan, $nama_belakang, $user_name, $foto, $id);
}

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(['status' => 'sukses', 'pesan' => 'Data berhasil diupdate']);
} else {
    if (mysqli_errno($koneksi) == 1062) {
        echo json_encode(['status' => 'gagal', 'pesan' => 'Username sudah digunakan']);
    } else {
        echo json_encode(['status' => 'gagal', 'pesan' => 'Gagal mengupdate data']);
    }
}