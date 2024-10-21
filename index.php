<?php
include 'function.php';
$barang = getAllBarang(); // Mengambil semua barang dari database
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Daftar Barang Sewa</title>
</head>
<body>
    <div class="container">
        <h1>Sewa barang computer</h1>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Gambar</th>
                        <th>Harga Sewa (Per Bulan)</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; foreach ($barang as $b): ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $b['nama_barang']; ?></td>
                        <td><img class="buku-gambar" src="gambar_barang_sewa/<?= $b['gambar']; ?>" alt="<?= $b['nama_barang']; ?>"></td>
                        <td>Rp. <?= number_format($b['harga_sewa'], 2, ',', '.'); ?></td>
                        <td><?= $b['stok'] == 'tersedia' ? 'Tersedia' : 'Tidak Tersedia'; ?></td>
                        <td>
                            <?php if ($b['stok'] == 'tersedia'): ?>
                            <form action="transaksi.php" method="POST">
                                <button type="submit" name="sewa_barang" value="<?= $b['sewa_id']; ?>">Sewa Sekarang</button>
                            </form>
                            <?php else: ?>
                            <button disabled>Tidak Tersedia</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
