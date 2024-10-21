<?php
include 'function.php';
$barang = getAllBarang();
$pelanggan = getAllPelanggan();

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['tambah_barang'])) {
        tambahBarang($_POST, $_FILES);
    } elseif (isset($_POST['edit_barang'])) {
        editBarang($_POST, $_FILES);
    } elseif (isset($_POST['hapus_barang'])) {
        hapusBarang($_POST['hapus_barang']);
    } elseif (isset($_POST['tambah_pelanggan'])) {
        tambahPelanggan($_POST);
    } elseif (isset($_POST['edit_pelanggan'])) {
        editPelanggan($_POST);
    } elseif (isset($_POST['hapus_pelanggan'])) {
        hapusPelanggan($_POST['hapus_pelanggan']);
    }
    
    // Redirect to prevent form resubmission
    header("Location: admin_barang.php");
    exit();
}

// Get barang data for editing
$edit_barang = null;
if (isset($_GET['edit_barang'])) {
    $edit_barang = getBarangById($_GET['edit_barang']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Admin - Sewa Barang</title>
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
        <h1>Admin - Kelola Sewa Barang</h1>

        <!-- Form Tambah/Edit Barang -->
        <form method="POST" enctype="multipart/form-data">
            <h2><?= $edit_barang ? 'Edit' : 'Tambah' ?> Barang</h2>
            <?php if ($edit_barang): ?>
                <input type="hidden" name="sewa_id" value="<?= $edit_barang['sewa_id'] ?>">
            <?php endif; ?>
            <div class="form-group">
                <label for="nama_barang">Nama Barang:</label>
                <input type="text" name="nama_barang" value="<?= $edit_barang ? htmlspecialchars($edit_barang['nama_barang']) : '' ?>" required>
            </div>
            <div class="form-group">
                <label for="gambar">Gambar:</label>
                <input type="file" name="gambar" accept="image/*">
            </div>
            <div class="form-group">
                <label for="harga_sewa">Harga Sewa:</label>
                <input type="number" name="harga_sewa" value="<?= $edit_barang ? htmlspecialchars($edit_barang['harga_sewa']) : '' ?>" required>
            </div>
            <div class="form-group">
                <label for="stok">Stok:</label>
                <input type="number" name="stok" value="<?= $edit_barang ? htmlspecialchars($edit_barang['stok']) : '' ?>" required>
            </div>
            <button type="submit" name="<?= $edit_barang ? 'edit_barang' : 'tambah_barang' ?>" class="button <?= $edit_barang ? 'edit' : '' ?>"><?= $edit_barang ? 'Simpan Perubahan' : 'Tambah Barang' ?></button>
        </form>

        <!-- Tabel Barang -->
        <h2>Daftar Barang</h2>
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Barang</th>
                    <th>Gambar</th>
                    <th>Harga Sewa</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($barang as $i => $item): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= htmlspecialchars($item['nama_barang']) ?></td>
                        <td><img src="gambar_barang_sewa/<?= htmlspecialchars($item['gambar']) ?>" alt="<?= htmlspecialchars($item['nama_barang']) ?>"></td>
                        <td>
                            <?php
                            if (isset($item['harga_sewa'])) {
                                echo 'Rp ' . number_format($item['harga_sewa'], 2, ',', '.');
                            } else {
                                echo "Rp 0,00";
                            }
                            ?>
                        </td>
                        <td><?= htmlspecialchars($item['stok']) ?></td>
                        <td>
                            <a href="admin_barang.php?edit_barang=<?= $item['sewa_id'] ?>" class="button edit">Edit</a>
                            <form method="POST" style="display: inline-block;">
                                <button type="submit" name="hapus_barang" value="<?= $item['sewa_id'] ?>" class="button hapus">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>