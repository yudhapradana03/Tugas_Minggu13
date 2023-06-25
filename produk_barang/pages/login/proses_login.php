<?php
session_start();

include('../../db/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']); 

    // Mengenkripsi password menggunakan MD5
    $hashedPassword = md5($password);

    // Query untuk mendapatkan data pengguna
    $query = "SELECT * FROM user WHERE username = '$username' AND password = '$hashedPassword'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        // Login berhasil
        $user = mysqli_fetch_assoc($result);
        $_SESSION['role'] = htmlspecialchars($user['role']);
        $_SESSION['username'] = htmlspecialchars($username);
        // header('Location: ../../index.php?page=welcome');
        header('Location: ../../index.php?page=home');
        exit();
    } else {
        // Login gagal
        echo "Username atau password salah.";
    }

    mysqli_close($koneksi);
}
?>
