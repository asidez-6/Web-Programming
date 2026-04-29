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
        <tr>
            <td>
                <img src="uploads_penulis/<?= htmlspecialchars($row['foto']) ?>" 
                     class="foto" 
                     alt="Foto"
                     onerror="this.src='uploads_penulis/default.png'">
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