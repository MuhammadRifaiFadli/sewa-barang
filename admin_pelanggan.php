<?php
include 'function.php';
$pelanggan = getAllPelanggan();
$nama_barang_options = getAllNamaBarang();
// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['tambah_pelanggan'])) {
        tambahPelanggan($_POST);
    } elseif (isset($_POST['edit_pelanggan'])) {
        editPelanggan($_POST);
    } elseif (isset($_POST[' hapus_pelanggan'])) {
        hapusPelanggan($_POST['hapus_pelanggan']);
    }
    
    // Redirect to prevent form resubmission
    header("Location: admin_pelanggan.php");
    exit();
}

// Get pelanggan data for editing
$edit_pelanggan = null;
if (isset($_GET['edit_pelanggan'])) {
    $edit_pelanggan = getPelangganById($_GET['edit_pelanggan']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Admin - Kelola Pelanggan</title>
    <style>
        .button {
            display: inline-block;
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 3px;
        }
        .button.edit {
            background-color: #2196F3;
        }
        .button.hapus {
            background-color: #f44336;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin - Kelola Pelanggan</h1>

        <!-- Form Tambah/Edit Pelanggan -->
        <form method="POST">
            <h2><?= $edit_pelanggan ? 'Edit' : 'Tambah' ?> Pelanggan</h2>
            <?php if ($edit_pelanggan): ?>
                <input type="hidden" name="pelanggan_id" value="<?= $edit_pelanggan['pelanggan_id'] ?>">
            <?php endif; ?>
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" name="nama" value="<?= $edit_pelanggan ? htmlspecialchars($edit_pelanggan['nama']) : '' ?>" required>
            </div>
            <div class="form-group">
                <label for="kontak">Kontak:</label>
                <input type="text" name="kontak" value="<?= $edit_pelanggan ? htmlspecialchars($edit_pelanggan['kontak']) : '' ?>" required>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat:</label>
                <textarea name="alamat" required><?= $edit_pelanggan ? htmlspecialchars($edit_pelanggan['alamat']) : '' ?></textarea>
            </div>
            <div class="form-group">
                <label for="nama_barang">Nama Barang:</label>
                <select name="nama_barang" required>
                    <option value="">Pilih Barang</option>
                    <?php foreach ($nama_barang_options as $barang): ?>
                        <option value="<?= htmlspecialchars($barang['nama_barang']) ?>" <?= ($edit_pelanggan && $edit_pelanggan['nama_barang'] == $barang['nama_barang']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($barang['nama_barang']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="durasi_sewa">Durasi Sewa (bulan):</label>
                <input type="number" name="durasi_sewa" value="<?= $edit_pelanggan ? htmlspecialchars($edit_pelanggan['durasi_sewa']) : '' ?>" required>
            </div>
            <button type="submit" name="<?= $edit_pelanggan ? 'edit_pelanggan' : 'tambah_pelanggan' ?>" class="button <?= $edit_pelanggan ? 'edit' : '' ?>">
                <?= $edit_pelanggan ? 'Simpan Perubahan' :  'Tambah Pelanggan' ?>
            </button>
        </form>

        <!-- Tabel Pelanggan -->
        <h2>Daftar Pelanggan</h2>
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Kontak</th>
                    <th>Alamat</th>
                    <th>Nama Barang</th>
                    <th>Durasi Sewa</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pelanggan as $i => $pelanggan): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= htmlspecialchars($pelanggan['nama']) ?></td>
                        <td><?= htmlspecialchars($pelanggan['kontak']) ?></td>
                        <td><?= htmlspecialchars($pelanggan['alamat']) ?></td>
                        <td><?= htmlspecialchars($pelanggan['nama_barang']) ?></td>
                        <td><?= htmlspecialchars($pelanggan['durasi_sewa']) ?></td>
                        <td>
                            <a href="admin_pelanggan.php?edit_pelanggan=<?= $pelanggan['pelanggan_id'] ?>" class="button edit">Edit</a>
                            <form method="POST" style="display: inline-block;">
                                <button type="submit" name="hapus_pelanggan" value="<?= $pelanggan['pelanggan_id'] ?>" class="button hapus">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </ tbody>
        </table>
    </div>
</body>
</html>