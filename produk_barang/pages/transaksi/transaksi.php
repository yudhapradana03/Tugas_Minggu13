<?php

// Fungsi untuk menyimpan transaksi ke tabel transaksi



function simpanTransaksi()
{
    $nama = $_SESSION['username'];
    $totalHarga = hitungTotalHarga();

    include('db/koneksi.php');

    // Mendapatkan tanggal saat ini
    $createdDate = date("Y-m-d H:i:s");

    // Query untuk menyimpan data transaksi ke tabel transaksi
    $query = "INSERT INTO transaksi (username, total_harga, created_by, created_date) 
            VALUES ('$nama', $totalHarga, '$nama', '$createdDate')";
    mysqli_query($koneksi, $query);

    // Mendapatkan ID transaksi yang baru saja disimpan
    $idTransaksi = mysqli_insert_id($koneksi);

    // Looping untuk menyimpan detail transaksi ke tabel transaksi_detail
    if (isset($_SESSION['keranjang'])) {
        foreach ($_SESSION['keranjang'] as $item) {
            $idBarang = $item['id'];
            $jumlah = $item['jumlah'];
            $harga = $item['harga'];
            $diskon = $item['diskon']; // Tambahkan logika untuk menghitung diskon jika diperlukan
            $subtotalHarga = $harga * $jumlah;
            $subtotalHarga = $subtotalHarga - ($subtotalHarga * $diskon /100);

            // Query untuk menyimpan data detail transaksi ke tabel transaksi_detail
            $queryDetail = "INSERT INTO transaksi_detail (id_transaksi, id_barang, jumlah, diskon, subtotal_harga, created_by, created_date) 
                            VALUES ($idTransaksi, $idBarang, $jumlah, $diskon, $subtotalHarga, '$nama','$createdDate')";
            mysqli_query($koneksi, $queryDetail);
        }
    }

    // Tutup koneksi ke database
    mysqli_close($koneksi);
}

// Memeriksa jika ada permintaan untuk selesai belanja
if (isset($_GET['action']) && $_GET['action'] == 'selesai') {
    
    simpanTransaksi();

    // Setelah transaksi disimpan, hapus data keranjang dari session
    unset($_SESSION['keranjang']);
   
    header('Location: index.php?page=transaksi');
    exit;
     

    
}

// Fungsi untuk menambahkan barang ke keranjang
function tambahKeKeranjang($id, $nama, $harga, $jumlah)
{
    // Jika keranjang masih kosong, inisialisasi sebagai array kosong
    if (!isset($_SESSION['keranjang'])) {
        $_SESSION['keranjang'] = array();
    }

    // Cek apakah barang sudah ada di keranjang
    foreach ($_SESSION['keranjang'] as $key => $item) {
        if ($item['id'] == $id) {
            // Jika barang sudah ada, tambahkan jumlahnya
            $_SESSION['keranjang'][$key]['jumlah'] += $jumlah;
            return;
        }
    }

    // Jika barang belum ada, tambahkan ke keranjang
    $barang = array(
        'id' => $id,
        'nama' => $nama,
        'harga' => $harga,
        'jumlah' => $jumlah
    );

    array_push($_SESSION['keranjang'], $barang);
}

// Fungsi untuk menghapus barang dari keranjang
function hapusDariKeranjang($id)
{
    if (isset($_SESSION['keranjang'])) {
        foreach ($_SESSION['keranjang'] as $key => $item) {
            if ($item['id'] == $id) {
                // Hapus barang dari keranjang
                unset($_SESSION['keranjang'][$key]);
                return;
            }
        }
    }
}

// Fungsi untuk menghitung total harga dalam keranjang
function hitungTotalHarga()
{
    $totalHarga = 0;

    if (isset($_SESSION['keranjang'])) {
        foreach ($_SESSION['keranjang'] as $item) {
            $subtotal = $item['harga'] * $item['jumlah'];
            $subtotal = $subtotal - ($item['diskon'] * $subtotal / 100);
            $totalHarga += $subtotal;
        }
    }

    return $totalHarga;
}

// Fungsi untuk memperbarui jumlah barang dalam keranjang
function perbaruiJumlah($id, $jumlah)
{
    if (isset($_SESSION['keranjang'])) {
        foreach ($_SESSION['keranjang'] as $key => $item) {
            if ($item['id'] == $id) {
                $_SESSION['keranjang'][$key]['jumlah'] = $jumlah;
                return;
            }
        }
    }
}

function perbaruiDiskon($id, $diskon)
{
    if (isset($_SESSION['keranjang'])) {
        foreach ($_SESSION['keranjang'] as $key => $item) {
            if ($item['id'] == $id) {
                $_SESSION['keranjang'][$key]['diskon'] = $diskon;
                return;
            }
        }
    }
}

// Memeriksa jika ada permintaan untuk menambahkan barang ke keranjang
if (isset($_GET['action']) && $_GET['action'] == 'tambah') {
    $id = $_GET['id'];
    $nama = $_GET['nama'];
    $harga = $_GET['harga'];
    $jumlah = $_GET['jumlah'];
    tambahKeKeranjang($id, $nama, $harga, $jumlah);
    header('Location: index.php?page=transaksi');
    exit;
}

// Memeriksa jika ada permintaan untuk memperbarui jumlah barang dalam keranjang
if (isset($_GET['action']) && $_GET['action'] == 'perbarui') {
    $id = $_GET['id'];
    $jumlah = $_GET['jumlah'];
    perbaruiJumlah($id, $jumlah);
    header('Location: index.php?page=transaksi');
    exit;
}

if (isset($_GET['action']) && $_GET['action'] == 'perbaruidiskon') {
    $id = $_GET['id'];
    $diskon = $_GET['diskon'];
    perbaruiDiskon($id, $diskon);
    header('Location: index.php?page=transaksi');
    exit;
}

// Memeriksa jika ada permintaan untuk menghapus barang dari keranjang
if (isset($_GET['action']) && $_GET['action'] == 'hapus') {
    $id = $_GET['id'];
    hapusDariKeranjang($id);
    header('Location: index.php?page=transaksi');
    exit;
}
?>

<h3>KERANJANG BELANJA</h3>
<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Diskon(%)</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if (isset($_SESSION['keranjang'])) {
                    foreach ($_SESSION['keranjang'] as $key => $item) {
                        $subtotal = $item['harga'] * $item['jumlah'] ;
                        $subtotal = $subtotal  - ($item["diskon"] * $subtotal / 100)
                ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $item['nama']; ?></td>
                            <td>Rp <?= $item['harga']; ?></td>
                            <td>
                                <form method="get" action="index.php">
                                    <input type="hidden" name="action" value="perbaruidiskon">
                                    <input type="hidden" name="page" value="transaksi">
                                    <input type="hidden" name="id" value="<?= $item['id']; ?>">
                                    <input type="number" name="diskon" value="<?= $item['diskon']; ?>" min="1" onchange="this.form.submit()">
                                </form>
                            </td>
                            <td>
                                <form method="get" action="index.php">
                                    <input type="hidden" name="page" value="transaksi">
                                    <input type="hidden" name="action" value="perbarui">
                                    <input type="hidden" name="id" value="<?= $item['id']; ?>">
                                    <input type="number" name="jumlah" value="<?= $item['jumlah']; ?>" min="1" onchange="this.form.submit()">
                                </form>
                            </td>
                            <td>Rp <?= $subtotal; ?></td>
                            <td>
                                <a href="index.php?page=transaksi&action=hapus&id=<?= $item['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ingin menghapus barang ini?')">Hapus</a>
                            </td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" align="right"><strong>Total:</strong></td>
                    <td colspan="2"><strong>Rp <?= hitungTotalHarga(); ?></strong></td>
                </tr>
            </tfoot>
        </table>

        <a href="index.php?page=transaksi&action=selesai" class="btn btn-primary">Selesai Belanja</a>
    </div>
</div>