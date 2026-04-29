<?php
include 'koneksi.php';

$id          = $_POST['id'] ?? 0;
$judul       = $_POST['judul'] ?? '';
$id_penulis  = $_POST['id_penulis'] ?? 0;
$id_kategori = $_POST['id_kategori'] ?? 0;
$isi         = $_POST['isi'] ?? '';

if (empty($judul) || empty($id_penulis) || empty($id_kategori) || empty($isi)) {
    echo json_encode(['status' => 'gagal', 'pesan' => 'Field wajib diisi']);
    exit;
}

// Ambil data lama
$stmt = mysqli_prepare($koneksi, "SELECT gambar FROM artikel WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data_lama = mysqli_fetch_assoc($result);
$gambar = $data_lama['gambar'];

// Upload gambar baru jika ada
if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
    $file_info = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($file_info, $_FILES['gambar']['tmp_name']);
    finfo_close($file_info);
    
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    
    if (!in_array($mime_type, $allowed_types)) {
        echo json_encode(['status' => 'gagal', 'pesan' => 'Tipe file tidak diizinkan']);
        exit;
    }
    
    if ($_FILES['gambar']['size'] > 2 * 1024 * 1024) {
        echo json_encode(['status' => 'gagal', 'pesan' => 'Ukuran file maksimal 2 MB']);
        exit;
    }
    
    // Hapus gambar lama
    if (file_exists('uploads_artikel/' . $gambar)) {
        unlink('uploads_artikel/' . $gambar);
    }
    
    $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
    $gambar = uniqid() . '.' . $ext;
    move_uploaded_file($_FILES['gambar']['tmp_name'], 'uploads_artikel/' . $gambar);
}

// Update
$stmt = mysqli_prepare($koneksi, "UPDATE artikel SET id_penulis=?, id_kategori=?, judul=?, isi=?, gambar=? WHERE id=?");
mysqli_stmt_bind_param($stmt, "iisssi", $id_penulis, $id_kategori, $judul, $isi, $gambar, $id);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(['status' => 'sukses', 'pesan' => 'Data berhasil diupdate']);
} else {
    echo json_encode(['status' => 'gagal', 'pesan' => 'Gagal mengupdate data']);
}