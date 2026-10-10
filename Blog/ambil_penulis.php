<?php
include 'koneksi.php';

if (isset($_GET['format']) && $_GET['format'] === 'json') {
    $stmt = mysqli_prepare($koneksi, "SELECT id, nama_depan, nama_belakang, user_name, foto FROM penulis ORDER BY id DESC");
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

$stmt = mysqli_prepare($koneksi, "SELECT * FROM penulis ORDER BY id DESC");
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Placeholder inline (SVG) agar tidak bergantung pada file di server
$placeholder = 'data:image/svg+xml,' . rawurlencode(
    '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 45 45">'
    . '<rect width="45" height="45" fill="#dee2e6"/>'
    . '<circle cx="22.5" cy="17" r="8" fill="#adb5bd"/>'
    . '<path d="M6 45c0-10 7-16 16.5-16S39 35 39 45z" fill="#adb5bd"/>'
    . '</svg>'
);
?>

<h2>Data Penulis</h2>
<button class="btn btn-tambah" onclick="openModalTambah()">+ Tambah Penulis</button>

<table>
    <thead>
        <tr>
            <th>Foto</th>
            <th>Nama</th>
            <th>Username</th>
            <th>Password</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <?php
            // Pakai placeholder jika foto kosong, hilang, atau file 0 byte
            $path_foto = 'uploads_penulis/' . $row['foto'];
            $ada_foto = $row['foto'] !== '' && is_file($path_foto) && filesize($path_foto) > 0;
        ?>
        <tr>
            <td>
                <img src="<?= $ada_foto ? htmlspecialchars($path_foto) : $placeholder ?>"
                     class="foto"
                     alt="Foto"
                     onerror="this.onerror=null;this.src='<?= $placeholder ?>'">
            </td>
            <td><?= htmlspecialchars($row['nama_depan'] . ' ' . $row['nama_belakang']) ?></td>
            <td><?= htmlspecialchars($row['user_name']) ?></td>
            <td><span class="password-hash"><?= htmlspecialchars(substr($row['password'], 0, 20)) ?>...</span></td>
            <td>
                <button class="btn btn-edit" onclick="openModalEdit(<?= $row['id'] ?>)">Edit</button>
                <button class="btn btn-hapus" onclick="openModalHapus(<?= $row['id'] ?>)">Hapus</button>
            </td>
        </tr>
        <?php endwhile; ?>
        <?php if (mysqli_num_rows($result) == 0): ?>
        <tr>
            <td colspan="5" style="text-align: center; padding: 30px; color: #888;">Belum ada data penulis</td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>