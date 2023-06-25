<?php
include('../../db/koneksi.php');
// Ambil data dari form

$id = $_POST['id'];
$username = $_POST['username'];
$role = $_POST['role'];
$password = $_POST['password'];

$hashedPassword = md5($password);

// Query untuk menyimpan data ke tabel pengguna
$sql = "UPDATE user SET username='$username', role='$role', password='$hashedPassword' WHERE id='$id'";
if ($koneksi->query($sql) === TRUE) {
    echo "<script>alert('data berhasil disimpan.');window.location='../../index.php?page=user';</script>";
} else {
    echo "<script>alert('data gagal disimpan.'); window.location='../../index.php?page=user';</script>";
}

$koneksi->close();
?>
