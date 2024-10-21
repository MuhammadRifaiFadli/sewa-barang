<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$dbname = 'sewa_barang';

$db = new mysqli($hostname, $username, $password, $dbname);

if ($db->connect_error) {
    die("Koneksi gagal: " . $db->connect_error);
}

// Fungsi mengambil semua barang
function getAllBarang() {
    global $db;
    $result = $db->query("SELECT * FROM sewa ORDER BY sewa_id DESC");
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Fungsi tambah barang
function tambahBarang($data, $files) {
    global $db;
    $nama_barang = $db->real_escape_string($data['nama_barang']);
    $harga_sewa = $db->real_escape_string($data['harga_sewa']);
    $stok = $db->real_escape_string($data['stok']);

    // Upload gambar
    $gambar = $files['gambar']['name'];
    $target = "gambar_barang_sewa/" . basename($gambar);

    if (move_uploaded_file($files['gambar']['tmp_name'], $target)) {
        // Simpan data barang ke database
        $query = "INSERT INTO sewa (nama_barang, gambar, harga_sewa, stok) 
                  VALUES ('$nama_barang', '$gambar', '$harga_sewa', '$stok')";

        if ($db->query($query)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}


// Fungsi hapus barang
function hapusBarang($sewa_id) {
    global $db;
    $sewa_id = $db->real_escape_string($sewa_id);
    
    // Hapus gambar terkait
    $result = $db->query("SELECT gambar FROM sewa WHERE sewa_id = $sewa_id");
    if ($row = $result->fetch_assoc()) {
        $gambar = $row['gambar'];
        $file_path = "gambar_barang_sewa/" . $gambar;
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }

    $query = "DELETE FROM sewa WHERE sewa_id = $sewa_id";
    return $db->query($query);
}

// Fungsi untuk mendapatkan data barang berdasarkan ID
function getBarangById($sewa_id) {
    global $db;
    $sewa_id = $db->real_escape_string($sewa_id);
    $result = $db->query("SELECT * FROM sewa WHERE sewa_id = $sewa_id");
    return $result->fetch_assoc();
}

// Tambahkan fungsi ini di function.php
function editBarang($data, $files) {
    global $db;
    $sewa_id = $db->real_escape_string($data['sewa_id']);
    $nama_barang = $db->real_escape_string($data['nama_barang']);
    $harga = $db->real_escape_string($data['harga_sewa']);
    $stok = $db->real_escape_string($data['stok']);

    // Update gambar jika ada
    if ($files['gambar']['size'] > 0) {
        $gambar = uploadGambar($files['gambar']);
    } else {
        $gambar = getBarangById($sewa_id)['gambar'];
    }

    $query = "UPDATE sewa SET nama_barang = '$nama_barang', harga = $harga, stok = $stok, gambar = '$gambar' WHERE sewa_id = $sewa_id";
    $db->query($query);
}

// Fungsi untuk mengambil semua pelanggan
function getAllPelanggan() {
    global $db;
    $result = $db->query("SELECT * FROM pelanggan");
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Fungsi untuk mengambil pelanggan berdasarkan ID
function getPelangganById($pelanggan_id) {
    global $db;
    $pelanggan_id = $db->real_escape_string($pelanggan_id);
    $result = $db->query("SELECT * FROM pelanggan WHERE pelanggan_id = $pelanggan_id");
    return $result->fetch_assoc();
}

// Fungsi untuk menambah pelanggan
function tambahPelanggan($data) {
    global $db;
    $nama = $db->real_escape_string($data['nama']);
    $kontak = $db->real_escape_string($data['kontak']);
    $alamat = $db->real_escape_string($data['alamat']);
    $nama_barang = $db->real_escape_string($data['nama_barang']);
    $durasi_sewa = $db->real_escape_string($data['durasi_sewa']);

    $query = "INSERT INTO pelanggan (nama, kontak, alamat, nama_barang, durasi_sewa) 
              VALUES ('$nama', '$kontak', '$alamat', '$nama_barang', '$durasi_sewa')";
    $db->query($query);
}

// Fungsi untuk mengedit pelanggan
function editPelanggan($data) {
    global $db;
    $pelanggan_id = $db->real_escape_string($data['pelanggan_id']);
    $nama = $db->real_escape_string($data['nama']);
    $kontak = $db->real_escape_string($data['kontak']);
    $alamat = $db->real_escape_string($data['alamat']);
    $nama_barang = $db->real_escape_string($data['nama_barang']);
    $durasi_sewa = $db->real_escape_string($data['durasi_sewa']);

    $query = "UPDATE pelanggan 
              SET nama = '$nama', kontak = '$kontak', alamat = '$alamat', 
                  nama_barang = '$nama_barang', durasi_sewa = '$durasi_sewa' 
              WHERE pelanggan_id = $pelanggan_id";
    $db->query($query);
}

// Fungsi untuk menghapus pelanggan
function hapusPelanggan($pelanggan_id) {
    global $db;
    $pelanggan_id = $db->real_escape_string($pelanggan_id);

    $query = "DELETE FROM pelanggan WHERE pelanggan_id = $pelanggan_id";
    $db->query($query);
}

// Fungsi untuk mengambil semua nama barang dari tabel sewa
function getAllNamaBarang() {
    global $db;
    $result = $db->query("SELECT DISTINCT nama_barang FROM sewa ORDER BY nama_barang ASC");
    return $result->fetch_all(MYSQLI_ASSOC);
}