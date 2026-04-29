<?php
require_once 'koneksi.php';
$id    = isset($_POST['id']) ? (int) $_POST['id'] : 0;
$nama  = $_POST['nama'];
$email = $_POST['email'];
$pesan = $_POST['pesan'];
// Validasi id
if ($id <= 0) {
    echo json_encode([
        'status' => 'gagal',
        'pesan'  => 'ID tidak valid'
    ]);
    exit;
}
// Validasi field teks
if (empty($nama) || empty($email) || empty($pesan)) {
    echo json_encode([
        'status' => 'gagal',
        'pesan'  => 'Semua kolom harus diisi'
    ]);
    exit;
}
// Cek apakah pengguna mengganti foto
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
    // Validasi tipe file
    $tipe_diizinkan = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($_FILES['foto']['type'], $tipe_diizinkan)) {
        echo json_encode([
            'status' => 'gagal',
            'pesan'  => 'Tipe file tidak diizinkan'
        ]);
        exit;
    }
    // Validasi ukuran file
    $ukuran_maks = 2 * 1024 * 1024; // 2 MB
    if ($_FILES['foto']['size'] > $ukuran_maks) {
        echo json_encode([
            'status' => 'gagal',
            'pesan'  => 'Ukuran file tidak boleh lebih dari 2 MB'
        ]);
        exit;
    }
    // Ambil nama file foto lama dari database
    $stmt = mysqli_prepare($koneksi,
        "SELECT foto FROM kontak WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $hasil = mysqli_stmt_get_result($stmt);
    $baris = mysqli_fetch_assoc($hasil);
    $foto_lama = $baris['foto'];
    // Upload foto baru
    $ekstensi  = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $nama_file = uniqid() . '.' . $ekstensi;
    $tujuan    = 'uploads/' . $nama_file;
    if (!move_uploaded_file($_FILES['foto']['tmp_name'], $tujuan)) {
        echo json_encode([
            'status' => 'gagal',
            'pesan'  => 'Foto gagal diunggah'
        ]);
        exit;
    }
    // Update data dengan foto baru
    $stmt = mysqli_prepare($koneksi,
        "UPDATE kontak SET nama=?, email=?, pesan=?, foto=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "ssssi", $nama, $email, $pesan, $nama_file,
$id);
    if (mysqli_stmt_execute($stmt)) {
        // Hapus foto lama dari server
        if (file_exists('uploads/' . $foto_lama)) {
            unlink('uploads/' . $foto_lama);
        }
        echo json_encode([
            'status' => 'sukses',
            'pesan'  => 'Data berhasil diperbarui'
        ]);
    } else {
        // Hapus foto baru jika update gagal
        unlink($tujuan);
        echo json_encode([
            'status' => 'gagal',
            'pesan'  => 'Data gagal diperbarui'
        ]);
    }
} else {
    // Update data tanpa mengganti foto
    $stmt = mysqli_prepare($koneksi,
        "UPDATE kontak SET nama=?, email=?, pesan=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "sssi", $nama, $email, $pesan, $id);
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode([
            'status' => 'sukses',
            'pesan'  => 'Data berhasil diperbarui'
        ]);
    } else {
        echo json_encode([
            'status' => 'gagal',
            'pesan'  => 'Data gagal diperbarui'
        ]);
    }
}