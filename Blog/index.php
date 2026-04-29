<?php
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Blog (CMS)</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            min-height: 100vh;
        }
        .header {
            margin-inline-start: 30px;
            margin-inline-end: 30px;
            margin-top: 45px;
            border-radius: 10px;
            background: linear-gradient(135deg, #0B2545, #134074);
            color: white;
            padding: 25px 40px;
            font-size: 28px;
            font-weight: bold;
            box-shadow: 0px 0px 5px 5px rgba(0, 0, 0, 0.3);
        }
        .header span {
            font-size: 16px;
            font-weight: normal;
            opacity: 0.9;
            margin-left: 15px;
        }
        .container {
            display: flex;
            min-height: calc(100vh - 80px);
        }
        .sidebar {
            margin-inline-start: 30px;
            margin-top: 30px;
            border-radius: 10px;
            width: 200px;
            height: fit-content;
            background: linear-gradient(135deg, #0B2545, #134074);
            padding-top: 30px;
            padding-bottom: 100px;
            box-shadow: 2px 0 10px rgba(0,0,0,0.3);
        }
        .sidebar h3 {
            padding: 0 25px 20px;
            color: #fff;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .sidebar .menu {
            list-style: none;
        }
        .sidebar .menu li {
            padding: 14px 25px;
            cursor: pointer;
            color: #fff;
            font-size: 15px;
            transition: all 0.3s;
            border-left: 8px solid transparent;
            margin-bottom: px;
        }
        .sidebar .menu li:hover {
            background: #D8E4FF;
            color: #1a73e8;
        }
        .sidebar .menu li.aktif {
            border-radius: 10px;
            background: #D8E4FF;
            color: #1a73e8;
            border-left: 8px solid #1a73e8;
            font-weight: 600;
        }
        .content {
            flex: 1;
            padding: 35px 40px;
            overflow-y: auto;
        }
        .content h2 {
            background: linear-gradient(135deg, #0B2545, #134074);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 25px;
            font-size: 24px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.3);
            margin-bottom: 20px;
        }
        th {
            background: #134074;
            color: #fff;
            font-weight: 600;
            padding: 14px 15px;
            text-align: left;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        td {
            background-color: #D8E4FF;
            padding: 14px 15px;
            color: #0B2545;
            font-size: 14px;
        }
        tr:hover td {
            background: #CAE5FF;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        .btn-tambah {
            background: #134074;
            color: white;
            margin-bottom: 25px;
        }
        .btn-tambah:hover {
            background: #0B2545;
            transform: translateY(-1px);
        }
        .btn-edit {
            background: #ffe676;
            color: #333;
            padding: 6px 14px;
            font-size: 13px;
            margin-right: 5px;
        }
        .btn-edit:hover {
            background: #e0a800;
        }
        .btn-hapus {
            background: #dc3545;
            color: white;
            padding: 6px 14px;
            font-size: 13px;
        }
        .btn-hapus:hover {
            background: #530f15;
            transform: translateY(-1px);
        }
        .btn-batal {
            background: #6c757d;
            color: white;
            margin-right: 10px;
        }
        .btn-batal:hover {
            background: #5a6268;
        }
        .btn-simpan {
            background: #28a745;
            color: white;
        }
        .btn-simpan:hover {
            background: #218838;
        }
        .btn-konfirmasi {
            background: #dc3545;
            color: white;
        }
        .btn-konfirmasi:hover {
            background: #c82333;
        }
        img.foto {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
        }
        img.gambar {
            width: 70px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        .modal.show {
            display: flex;
        }
        .modal-content {
            background: white;
            border-radius: 12px;
            width: 500px;
            max-width: 90%;
            max-height: 80vh;
            overflow-y: auto;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        .modal-header {
            padding: 20px 25px;
            border-bottom: 1px solid #eee;
            font-size: 18px;
            font-weight: 600;
            color: #333;
        }
        .modal-body {
            padding: 25px;
        }
        .modal-footer {
            padding: 15px 25px;
            border-top: 1px solid #eee;
            display: flex;
            justify-content: flex-end;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #444;
            font-size: 14px;
        }
        .form-group input[type="text"],
        .form-group input[type="password"],
        .form-group input[type="file"],
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            transition: border 0.3s;
            font-family: inherit;
        }
        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #1a73e8;
            box-shadow: 0 0 0 3px rgba(26,115,232,0.1);
        }
        .form-group textarea {
            min-height: 120px;
            resize: vertical;
        }
        .error {
            color: #dc3545;
            font-size: 13px;
            margin-top: 5px;
        }
        .loading {
            text-align: center;
            padding: 40px;
            color: #888;
        }
        .password-hash {
            font-family: monospace;
            font-size: 12px;
            color: #888;
            word-break: break-all;
        }
        .konfirmasi-text {
            text-align: center;
            padding: 20px;
            font-size: 15px;
            color: #555;
        }
        .konfirmasi-text .warning {
            color: #dc3545;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="header">
        🌐Sistem Manajemen Blog (CMS)<br>
        <span>Blog Keren</span>
    </div>
    
    <div class="container">
        <div class="sidebar">
            <h3>Menu Utama</h3>
            <ul class="menu">
                <li class="aktif" data-menu="penulis" onclick="loadMenu('penulis', this)">📝 Kelola Penulis</li>
                <li data-menu="artikel" onclick="loadMenu('artikel', this)">📄 Kelola Artikel</li>
                <li data-menu="kategori" onclick="loadMenu('kategori', this)">📂 Kelola Kategori</li>
            </ul>
        </div>
        
        <div class="content" id="content-area">
            <!-- Konten akan dimuat di sini -->
        </div>
    </div>

    <!-- Modal Container -->
    <div id="modal-container" class="modal">
        <!-- Modal akan dimuat dinamis -->
    </div>

    <script>
        let currentMenu = 'penulis';

        document.addEventListener('DOMContentLoaded', function() {
            loadMenu('penulis');
        });

        function loadMenu(menu, element = null) {
            currentMenu = menu;
            
            // Update sidebar active
            document.querySelectorAll('.menu li').forEach(li => li.classList.remove('aktif'));
            if (element) {
                element.classList.add('aktif');
            } else {
                document.querySelector(`[data-menu="${menu}"]`).classList.add('aktif');
            }
            
            // Load content
            fetchContent(menu);
        }

        async function fetchContent(menu) {
            const contentArea = document.getElementById('content-area');
            contentArea.innerHTML = '<div class="loading">Memuat data...</div>';
            
            try {
                const response = await fetch(`ambil_${menu}.php`);
                const data = await response.text();
                contentArea.innerHTML = data;
            } catch (error) {
                contentArea.innerHTML = '<div class="error">Gagal memuat data</div>';
            }
        }

        async function openModalTambah() {
            const modalContainer = document.getElementById('modal-container');
            let formHTML = '';
            
            if (currentMenu === 'penulis') {
                formHTML = `
                    <div class="modal-content">
                        <div class="modal-header">Tambah Penulis</div>
                        <div class="modal-body">
                            <form id="form-tambah" onsubmit="simpanData(event)">
                                <div class="form-group">
                                    <label>Nama Depan</label>
                                    <input type="text" name="nama_depan" required>
                                </div>
                                <div class="form-group">
                                    <label>Nama Belakang</label>
                                    <input type="text" name="nama_belakang" required>
                                </div>
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" name="user_name" required>
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" name="password" required>
                                </div>
                                <div class="form-group">
                                    <label>Foto Profil</label>
                                    <input type="file" name="foto" accept="image/*">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-batal" onclick="closeModal()">Batal</button>
                            <button class="btn btn-simpan" onclick="document.getElementById('form-tambah').requestSubmit()">Simpan Data</button>
                        </div>
                    </div>
                `;
            } else if (currentMenu === 'artikel') {
                // Ambil data penulis dan kategori untuk dropdown
                let penulisOptions = '';
                let kategoriOptions = '';
                
                try {
                    const pResponse = await fetch('ambil_penulis.php?format=json');
                    const penulis = await pResponse.json();
                    penulis.forEach(p => {
                        penulisOptions += `<option value="${p.id}">${p.nama_depan} ${p.nama_belakang}</option>`;
                    });
                    
                    const kResponse = await fetch('ambil_kategori.php?format=json');
                    const kategori = await kResponse.json();
                    kategori.forEach(k => {
                        kategoriOptions += `<option value="${k.id}">${k.nama_kategori}</option>`;
                    });
                } catch(e) {}
                
                formHTML = `
                    <div class="modal-content">
                        <div class="modal-header">Tambah Artikel</div>
                        <div class="modal-body">
                            <form id="form-tambah" onsubmit="simpanData(event)">
                                <div class="form-group">
                                    <label>Judul</label>
                                    <input type="text" name="judul" placeholder="Judul artikel..." required>
                                </div>
                                <div class="form-group">
                                    <label>Penulis</label>
                                    <select name="id_penulis" required>
                                        <option value="">Pilih Penulis</option>
                                        ${penulisOptions}
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <select name="id_kategori" required>
                                        <option value="">Pilih Kategori</option>
                                        ${kategoriOptions}
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Isi Artikel</label>
                                    <textarea name="isi" placeholder="Tulis isi artikel di sini..." required></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Gambar</label>
                                    <input type="file" name="gambar" accept="image/*" required>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-batal" onclick="closeModal()">Batal</button>
                            <button class="btn btn-simpan" onclick="document.getElementById('form-tambah').requestSubmit()">Simpan Data</button>
                        </div>
                    </div>
                `;
            } else if (currentMenu === 'kategori') {
                formHTML = `
                    <div class="modal-content">
                        <div class="modal-header">Tambah Kategori</div>
                        <div class="modal-body">
                            <form id="form-tambah" onsubmit="simpanData(event)">
                                <div class="form-group">
                                    <label>Nama Kategori</label>
                                    <input type="text" name="nama_kategori" placeholder="Nama kategori..." required>
                                </div>
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <textarea name="keterangan" placeholder="Deskripsi kategori..."></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-batal" onclick="closeModal()">Batal</button>
                            <button class="btn btn-simpan" onclick="document.getElementById('form-tambah').requestSubmit()">Simpan Data</button>
                        </div>
                    </div>
                `;
            }
            
            modalContainer.innerHTML = formHTML;
            modalContainer.classList.add('show');
        }

        async function openModalEdit(id) {
            const modalContainer = document.getElementById('modal-container');
            
            try {
                const response = await fetch(`ambil_satu_${currentMenu}.php?id=${id}`);
                const data = await response.json();
                
                let formHTML = '';
                
                if (currentMenu === 'penulis') {
                    formHTML = `
                        <div class="modal-content">
                            <div class="modal-header">Edit Penulis</div>
                            <div class="modal-body">
                                <form id="form-edit" onsubmit="updateData(event, ${id})">
                                    <div class="form-group">
                                        <label>Nama Depan</label>
                                        <input type="text" name="nama_depan" value="${data.nama_depan}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Belakang</label>
                                        <input type="text" name="nama_belakang" value="${data.nama_belakang}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="text" name="user_name" value="${data.user_name}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Password Baru (kosongkan jika tidak diganti)</label>
                                        <input type="password" name="password">
                                    </div>
                                    <div class="form-group">
                                        <label>Foto Profil (kosongkan jika tidak diganti)</label>
                                        <input type="file" name="foto" accept="image/*">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-batal" onclick="closeModal()">Batal</button>
                                <button class="btn btn-simpan" onclick="document.getElementById('form-edit').requestSubmit()">Simpan Perubahan</button>
                            </div>
                        </div>
                    `;
                } else if (currentMenu === 'artikel') {
                    let penulisOptions = '';
                    let kategoriOptions = '';
                    
                    try {
                        const pResponse = await fetch('ambil_penulis.php?format=json');
                        const penulis = await pResponse.json();
                        penulis.forEach(p => {
                            const selected = p.id == data.id_penulis ? 'selected' : '';
                            penulisOptions += `<option value="${p.id}" ${selected}>${p.nama_depan} ${p.nama_belakang}</option>`;
                        });
                        
                        const kResponse = await fetch('ambil_kategori.php?format=json');
                        const kategori = await kResponse.json();
                        kategori.forEach(k => {
                            const selected = k.id == data.id_kategori ? 'selected' : '';
                            kategoriOptions += `<option value="${k.id}" ${selected}>${k.nama_kategori}</option>`;
                        });
                    } catch(e) {}
                    
                    formHTML = `
                        <div class="modal-content">
                            <div class="modal-header">Edit Artikel</div>
                            <div class="modal-body">
                                <form id="form-edit" onsubmit="updateData(event, ${id})">
                                    <div class="form-group">
                                        <label>Judul</label>
                                        <input type="text" name="judul" value="${data.judul}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Penulis</label>
                                        <select name="id_penulis" required>
                                            ${penulisOptions}
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Kategori</label>
                                        <select name="id_kategori" required>
                                            ${kategoriOptions}
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Isi Artikel</label>
                                        <textarea name="isi" required>${data.isi}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Gambar (kosongkan jika tidak diganti)</label>
                                        <input type="file" name="gambar" accept="image/*">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-batal" onclick="closeModal()">Batal</button>
                                <button class="btn btn-simpan" onclick="document.getElementById('form-edit').requestSubmit()">Simpan Perubahan</button>
                            </div>
                        </div>
                    `;
                } else if (currentMenu === 'kategori') {
                    formHTML = `
                        <div class="modal-content">
                            <div class="modal-header">Edit Kategori</div>
                            <div class="modal-body">
                                <form id="form-edit" onsubmit="updateData(event, ${id})">
                                    <div class="form-group">
                                        <label>Nama Kategori</label>
                                        <input type="text" name="nama_kategori" value="${data.nama_kategori}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Keterangan</label>
                                        <textarea name="keterangan">${data.keterangan || ''}</textarea>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-batal" onclick="closeModal()">Batal</button>
                                <button class="btn btn-simpan" onclick="document.getElementById('form-edit').requestSubmit()">Simpan Perubahan</button>
                            </div>
                        </div>
                    `;
                }
                
                modalContainer.innerHTML = formHTML;
                modalContainer.classList.add('show');
            } catch (error) {
                alert('Gagal memuat data');
            }
        }

        function openModalHapus(id) {
            const modalContainer = document.getElementById('modal-container');
            
            const formHTML = `
                <div class="modal-content" style="width: 400px;">
                    <div class="modal-header">Hapus data ini?</div>
                    <div class="modal-body">
                        <div class="konfirmasi-text">
                            <span class="warning">Data yang dihapus tidak dapat dikembalikan.</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-batal" onclick="closeModal()">Batal</button>
                        <button class="btn btn-konfirmasi" onclick="hapusData(${id})">Ya, Hapus</button>
                    </div>
                </div>
            `;
            
            modalContainer.innerHTML = formHTML;
            modalContainer.classList.add('show');
        }

        function closeModal() {
            const modalContainer = document.getElementById('modal-container');
            modalContainer.classList.remove('show');
            modalContainer.innerHTML = '';
        }

        async function simpanData(event) {
            event.preventDefault();
            
            const form = event.target;
            const formData = new FormData(form);
            
            try {
                const response = await fetch(`simpan_${currentMenu}.php`, {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.status === 'sukses') {
                    closeModal();
                    fetchContent(currentMenu);
                } else {
                    alert('Error: ' + result.pesan);
                }
            } catch (error) {
                alert('Gagal menyimpan data');
            }
        }

        async function updateData(event, id) {
            event.preventDefault();
            
            const form = event.target;
            const formData = new FormData(form);
            formData.append('id', id);
            
            try {
                const response = await fetch(`update_${currentMenu}.php`, {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.status === 'sukses') {
                    closeModal();
                    fetchContent(currentMenu);
                } else {
                    alert('Error: ' + result.pesan);
                }
            } catch (error) {
                alert('Gagal mengupdate data');
            }
        }

        async function hapusData(id) {
            try {
                const formData = new FormData();
                formData.append('id', id);
                
                const response = await fetch(`hapus_${currentMenu}.php`, {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.status === 'sukses') {
                    closeModal();
                    fetchContent(currentMenu);
                } else {
                    alert('Error: ' + result.pesan);
                }
            } catch (error) {
                alert('Gagal menghapus data');
            }
        }

        // Tutup modal jika klik di luar
        document.getElementById('modal-container').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</body>
</html>