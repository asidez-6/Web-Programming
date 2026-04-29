<?php
include 'koneksi.php';

if (isset($_GET['format']) && $_GET['format'] === 'json') {
    $stmt = mysqli_prepare($koneksi, "SELECT id, nama_kategori, keterangan FROM kategori_artikel ORDER BY id DESC");
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

$stmt = mysqli_prepare($koneksi, "SELECT * FROM kategori_artikel ORDER BY id DESC");
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<h2>Data Kategori Artikel</h2>
<button class="btn btn-tambah" onclick="openModalTambah()">+ Tambah Kategori</button>

<table>
    <thead>
        <tr>
            <th>Nama Kategori</th>
            <th>Keterangan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= htmlspecialchars($row['nama_kategori']) ?></td>
            <td><?= htmlspecialchars($row['keterangan'] ?? '-') ?></td>
            <td>
                <button class="btn btn-edit" onclick="openModalEdit(<?= $row['id'] ?>)">Edit</button>
                <button class="btn btn-hapus" onclick="openModalHapus(<?= $row['id'] ?>)">Hapus</button>
            </td>
        </tr>
        <?php endwhile; ?>
        <?php if (mysqli_num_rows($result) == 0): ?>
        <tr>
            <td colspan="3" style="text-align: center; padding: 30px; color: #888;">Belum ada data kategori</td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>