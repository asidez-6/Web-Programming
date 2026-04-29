<?php
include 'koneksi.php';

$stmt = mysqli_prepare($koneksi, "
    SELECT a.*, 
           p.nama_depan, p.nama_belakang,
           k.nama_kategori
    FROM artikel a
    JOIN penulis p ON a.id_penulis = p.id
    JOIN kategori_artikel k ON a.id_kategori = k.id
    ORDER BY a.id DESC
");
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<h2>Data Artikel</h2>
<button class="btn btn-tambah" onclick="openModalTambah()">+ Tambah Artikel</button>

<table>
    <thead>
        <tr>
            <th>Gambar</th>
            <th>Judul</th>
            <th>Kategori</th>
            <th>Penulis</th>
            <th>Tanggal</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td>
                <img src="uploads_artikel/<?= htmlspecialchars($row['gambar']) ?>" 
                     class="gambar" 
                     alt="Gambar">
            </td>
            <td><?= htmlspecialchars($row['judul']) ?></td>
            <td><?= htmlspecialchars($row['nama_kategori']) ?></td>
            <td><?= htmlspecialchars($row['nama_depan'] . ' ' . $row['nama_belakang']) ?></td>
            <td><?= htmlspecialchars($row['hari_tanggal']) ?></td>
            <td>
                <button class="btn btn-edit" onclick="openModalEdit(<?= $row['id'] ?>)">Edit</button>
                <button class="btn btn-hapus" onclick="openModalHapus(<?= $row['id'] ?>)">Hapus</button>
            </td>
        </tr>
        <?php endwhile; ?>
        <?php if (mysqli_num_rows($result) == 0): ?>
        <tr>
            <td colspan="6" style="text-align: center; padding: 30px; color: #888;">Belum ada data artikel</td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>