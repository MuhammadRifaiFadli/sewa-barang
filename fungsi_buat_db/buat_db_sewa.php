<?php
$hostname = 'localhost';
$username = 'root';
$password = '';

$db = new mysqli($hostname, $username, $password);

if ($db->connect_error) {
    die("Gagal koneksi: " . $db->connect_error);
}

// Buat database jika belum ada
$sql_buat_db = "CREATE DATABASE IF NOT EXISTS sewa_barang";
if ($db->query($sql_buat_db) === TRUE) {
    echo "Buat database 'sewa_barang' berhasil<br>";
} else {
    echo "Gagal buat database: " . $db->error . "<br>";
}

$db->select_db('sewa_barang');

// Buat tabel pelanggan
$sql_pelanggan = "CREATE TABLE IF NOT EXISTS pelanggan (
    pelanggan_id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    kontak VARCHAR(50),
    alamat TEXT
)";
if ($db->query($sql_pelanggan) === TRUE) {
    echo "Tabel 'pelanggan' berhasil dibuat<br>";
} else {
    echo "Gagal buat tabel 'pelanggan': " . $db->error . "<br>";
}

// Buat tabel sewa dengan kolom 'harga_sewa', 'stok', dan gambar
$sql_sewa = "CREATE TABLE IF NOT EXISTS sewa (
    sewa_id INT AUTO_INCREMENT PRIMARY KEY,
    tanggal_sewa DATETIME NOT NULL,
    pelanggan_id INT,
    nama_barang VARCHAR(255) NOT NULL,
    durasi_sewa INT NOT NULL, -- dalam hari
    harga_sewa DECIMAL(10, 2) NOT NULL, -- Harga sewa per bulan
    gambar VARCHAR(255), -- Lokasi file gambar
    stok ENUM('tersedia', 'tidak tersedia') NOT NULL, -- Stok barang
    FOREIGN KEY (pelanggan_id) REFERENCES pelanggan(pelanggan_id) ON DELETE CASCADE
)";
if ($db->query($sql_sewa) === TRUE) {
    echo "Tabel 'sewa' berhasil dibuat<br>";
} else {
    echo "Gagal buat tabel 'sewa': " . $db->error . "<br>";
}

$db->close();
?>
