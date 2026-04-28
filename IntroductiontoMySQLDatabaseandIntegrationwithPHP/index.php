<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajement Data Kontak</title>
    <style>
        body{
            font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            display:flex;
            justify-content: center;
            align-items: flex-start;
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
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .baris-baru {
            animation: fadeIn 0.5s ease-in-out;
        }
    </style>
</head>
<body>
    <div class="container">
    <div class="form-wrapper">
        <h2>Tambah Kontak</h2>
        <form id="formKontak">
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="pesan">Pesan:</label>
            <textarea id="pesan" name="pesan" rows="4" required></textarea>
            <button type="button" onclick="simpanData()">Simpan Data</button>
        </form>
        <div id="statusPesan" style="margin-top: 15px; font-size: 0.9rem;
        text-align: center;"></div>
    </div>
    <div class="table-wrapper">
        <h2>Daftar Pesan Masuk</h2>
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Pesan</th>
                </tr>
            </thead>
            <tbody id="isiTabel">
                <tr>
                    <td colspan="3" style="text-align:center; color:#999; 
                    font-style:italic;">Memuat data...</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<script>
// Memuat data dari database saat halaman pertama kali dibuka
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
                        <td colspan="3" style="text-align:center; color:#999;
                        font-style:italic;">Belum ada data.</td>
                    </tr>`;
                return;
            }
            tabel.innerHTML = '';
            data.forEach(baris => {
                const tr = document.createElement('tr');
                tr.classList.add('baris-baru');
                tr.innerHTML = `
                    <td>${baris.nama}</td>
                    <td>${baris.email}</td>
                    <td>${baris.pesan}</td>
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
            muatData(); // Memuat ulang data dari database setelah penyimpanan
        } else {
            statusPesan.innerHTML =
                "<span style='color:red;'>" + data.pesan + "</span>";
        }
        setTimeout(() => {
            statusPesan.innerHTML = '';
        }, 3000);
    });
}
</script>
</body>
</html>
