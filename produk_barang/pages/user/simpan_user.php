<?php
include('../../db/koneksi.php');
// Ambil data dari form
$username = $_POST['username'];
$role = $_POST['role'];
$password = $_POST['password'];

$hashedPassword = md5($password);

// Query untuk menyimpan data ke tabel pengguna
$sql = "INSERT INTO user (username, role, password) VALUES ('$username', '$role', '$hashedPassword')";
if ($koneksi->query($sql) === TRUE) {
    echo "<script>alert('data berhasil disimpan.');window.location='../../index.php?page=user';</script>";
} else {
    echo "<script>alert('data gagal disimpan.'); window.location='../../index.php?page=user';</script>";
}

$koneksi->close();
?>
