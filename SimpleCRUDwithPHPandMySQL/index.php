<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Data Kontak</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            padding: 40px 20px;
            box-sizing: border-box;
        }
        .container {
            display: flex;
            gap: 30px;
            width: 100%;
            max-width: 1100px;
            align-items: flex-start;
        }
        .form-wrapper {
            background-color: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            flex: 1;
            min-width: 300px;
        }
        .table-wrapper {
            background-color: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            flex: 2.5;
        }
        h2 {
            margin-top: 0;
            color: #333;
            font-size: 1.2rem;
            border-bottom: 2px solid #f4f4f9;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: 600;
            color: #555;
            font-size: 0.9rem;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 14px;
            box-sizing: border-box;
        }
        button {
            margin-top: 20px;
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            font-size: 15px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
        }
        button:hover {
            background-color: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        th, td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #eee;
        }
        th {
            background-color: #fafafa;
            color: #666;
            text-transform: uppercase;
            font-size: 0.8rem;
        }
        img.foto-kontak {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
        }
        .btn-edit {
            background-color: #2196F3;
            padding: 6px 12px;
            font-size: 13px;
            width: auto;
            margin-top: 0;
        }
        .btn-edit:hover {
            background-color: #1976D2;
        }
        .btn-hapus {
            background-color: #f44336;
            padding: 6px 12px;
            font-size: 13px;
            width: auto;
            margin-top: 0;
            margin-left: 5px;
        }
        .btn-hapus:hover {
            background-color: #d32f2f;
        }
        /* Modal */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .modal-overlay.aktif {
            display: flex;
        }
        .modal-box {
            background-color: #fff;
            padding: 25px;
            border-radius: 10px;
            width: 400px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .baris-baru {
            animation: fadeIn 0.5s ease-in-out;
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Form Tambah Kontak -->
    <div class="form-wrapper">
        <h2>Tambah Kontak</h2>
        <form id="formKontak">
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="pesan">Pesan:</label>
            <textarea id="pesan" name="pesan" rows="4" required></textarea>
            <label for="foto">Foto:</label>
            <input type="file" id="foto" name="foto" accept="image/*" required>
            <button type="button" onclick="simpanData()">Simpan Data</button>
        </form>
        <div id="statusPesan" style="margin-top: 15px; font-size: 0.9rem; text-align:
center;"></div>
    </div>
    <!-- Tabel Data Kontak -->
    <div class="table-wrapper">
        <h2>Daftar Pesan Masuk</h2>
        <table>
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Pesan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="isiTabel">
                <tr>
                    <td colspan="5" style="text-align:center; color:#999;
                    font-style:italic;">Memuat data...</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<!-- Modal Edit -->
<div class="modal-overlay" id="modalEdit">
    <div class="modal-box">
        <h2>Edit Kontak</h2>
        <form id="formEdit">
            <input type="hidden" id="editId">
            <label for="editNama">Nama:</label>
            <input type="text" id="editNama" name="nama" required>
            <label for="editEmail">Email:</label>
            <input type="email" id="editEmail" name="email" required>
            <label for="editPesan">Pesan:</label>
            <textarea id="editPesan" name="pesan" rows="4" required></textarea>
            <label for="editFoto">Foto (kosongkan jika tidak ingin mengganti):</label>
            <input type="file" id="editFoto" name="foto" accept="image/*">
            <button type="button" onclick="updateData()">Simpan Perubahan</button>
            <button type="button" onclick="tutupModal()"
                style="background-color:#aaa; margin-top: 10px;">Batal</button>
        </form>
    </div>
</div>
<script>
    window.onload = function() {
        muatData();
    };

    // Fungsi untuk mengambil dan menampilkan data dari database
function muatData() {
    fetch('ambil.php')
        .then(response => response.json())
        .then(data => {
            const tabel = document.getElementById('isiTabel');
            if (data.length === 0) {
                tabel.innerHTML = `
                    <tr>
                        <td colspan="5" style="text-align:center; color:#999;
                        font-style:italic;">Belum ada data.</td>
                    </tr>`;
                return;
            }
            tabel.innerHTML = '';
            data.forEach(baris => {
                const tr = document.createElement('tr');
                tr.classList.add('baris-baru');
                tr.innerHTML = `
                    <td><img src="uploads/${baris.foto}" class="fotokontak"></td>
                   
<td>${baris.nama}</td>
                   
<td>${baris.email}</td>
                   
<td>${baris.pesan}</td>
                   
<td>


                       <button class="btn-edit"
onclick="bukaModeEdit(${baris.id})">Edit</button>
                        <button class="btn-hapus"
onclick="hapusData(${baris.id})">Hapus</button>
                    </td>
                `;
                tabel.appendChild(tr);
            });
        });
}
// Fungsi untuk menyimpan data baru ke database
function simpanData() {
    const form = document.getElementById('formKontak');
    const formData = new FormData(form);
    const statusPesan = document.getElementById('statusPesan');
    fetch('simpan.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'sukses') {
            statusPesan.innerHTML =
                "<span style='color:green;'>Data berhasil disimpan!</span>";
            form.reset();
            muatData();
        } else {
            statusPesan.innerHTML =
                "<span style='color:red;'>" + data.pesan + "</span>";
        }
        setTimeout(() => {
            statusPesan.innerHTML = '';
        }, 3000);
    });
}
// Fungsi untuk membuka modal edit dan mengisi form dengan data dari database
function bukaModeEdit(id) {
    const formData = new FormData();
    formData.append('id', id);
    fetch('ambil_satu.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'sukses') {
            document.getElementById('editId').value   = data.data.id;
            document.getElementById('editNama').value  = data.data.nama;
            document.getElementById('editEmail').value = data.data.email;
            document.getElementById('editPesan').value = data.data.pesan;
            document.getElementById('modalEdit').classList.add('aktif');
        } else {
            alert('Data tidak ditemukan.');
        }
    });
}
// Fungsi untuk menutup modal edit
function tutupModal() {
    document.getElementById('modalEdit').classList.remove('aktif');
    document.getElementById('formEdit').reset();
}
// Fungsi untuk mengirim data yang sudah diubah ke server
function updateData() {
    const formData = new FormData();
    formData.append('id',    document.getElementById('editId').value);
    formData.append('nama',  document.getElementById('editNama').value);
    formData.append('email', document.getElementById('editEmail').value);
    formData.append('pesan', document.getElementById('editPesan').value);
    const foto = document.getElementById('editFoto').files[0];
    if (foto) {
        formData.append('foto', foto);
    }
    fetch('update.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'sukses') {
            tutupModal();
            muatData();
        } else {
            alert(data.pesan);
        }
    });
}
// Fungsi untuk menghapus data dari database
function hapusData(id) {
    const formData = new FormData();
    formData.append('id', id);
    fetch('hapus.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'sukses') {
            muatData();
        } else {
            alert(data.pesan);
        }
    });
}
</script>
</body>
</html>