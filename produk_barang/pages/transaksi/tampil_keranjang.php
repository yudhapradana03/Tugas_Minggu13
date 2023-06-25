<?php
session_start();

// Fungsi untuk menambahkan barang ke keranjang
function tambahKeKeranjang($id, $nama, $harga, $jumlah)
{
    // Cek apakah keranjang sudah ada atau belum
    if (isset($_SESSION['keranjang'])) {
        $keranjang = $_SESSION['keranjang'];
    } else {
        $keranjang = [];
    }

    // Cek apakah barang sudah ada di keranjang
    if (isset($keranjang[$id])) {
        // Jika barang sudah ada, tambahkan jumlahnya
        $keranjang[$id]['jumlah'] += $jumlah;
    } else {
        // Jika barang belum ada, tambahkan barang baru ke keranjang
        $keranjang[$id] = [
            'id' => $id,
            'nama' => $nama,
            'harga' => $harga,
            'jumlah' => $jumlah
        ];
    }

    // Simpan keranjang ke dalam session
    $_SESSION['keranjang'] = $keranjang;
}

if (isset($_POST['id']) && isset($_POST['nama']) && isset($_POST['harga']) && isset($_POST['jumlah'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $jumlah = $_POST['jumlah'];

    tambahKeKeranjang($id, $nama, $harga, $jumlah);
    echo 'Barang berhasil ditambahkan ke keranjang.';
} else {
    echo 'Terjadi kesalahan. Barang gagal ditambahkan ke keranjang.';
}