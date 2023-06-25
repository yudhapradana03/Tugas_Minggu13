<!DOCTYPE html>
<html>

<head>
	<title>PEMROGRAMAN WEB - SI</title>
</head>
<link rel="stylesheet" type="text/css" href="../../assets/css/bootstrap.min.css">

<body>
	<div class="container col-md-6 mt-4">
		<h1>Table Barang</h1>
		<div class="card">
			<div class="card-header bg-success text-white">
				Tambah Barang
			</div>
			<div class="card-body">
				<form action="" method="post" role="form" enctype="multipart/form-data">
					<div class="form-group">
						<label>Nama Barang</label>
						<input type="text" name="nama" required="" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="keterangan">Keterangan:</label>
						<input type="text" class="form-control" name="keterangan" required>
					</div>
					<div class="form-group">
						<label>Harga</label>
						<input type="text" name="harga" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="jumlah">Jumlah:</label>
						<input type="number" class="form-control" id="jumlah" name="jumlah" required>
					</div>
					 <div class="form-group">
					    <label for="foto">Foto</label>
					    <input type="file" name="foto" class="form-control-file" id="foto">
					</div>

					<button type="submit" class="btn btn-primary" name="submit" value="simpan">Simpan data</button>
				</form>

				<?php
				include('../../db/koneksi.php');
				include ('../../lib/uploadFoto.php');
				//melakukan pengecekan jika button submit diklik maka akan menjalankan perintah simpan dibawah ini
				if (isset($_POST['submit'])) {
					if(upload_foto($_FILES['foto'])){
						$foto=$_FILES['foto']['name'];
						//menampung data dari inputan
						$nama = $_POST['nama'];
						$keterangan = $_POST['keterangan'];
						$harga = $_POST['harga'];
						$jumlah = $_POST['jumlah'];

						// echo $foto.$nama.$keterangan.$harga.$jumlah; die();

						//query untuk menambahkan barang ke database, pastikan urutan nya sama dengan di database
						$datas = mysqli_query($koneksi, "insert into barang (keterangan, nama,  harga, jumlah, foto)values('$keterangan','$nama', '$harga', '$jumlah', '$foto')") or die(mysqli_error($koneksi));
						//id barang tidak dimasukkan, karena sudah menggunakan AUTO_INCREMENT, id akan otomatis

						//ini untuk menampilkan alert berhasil dan redirect ke halaman index
						echo "<script>alert('data berhasil disimpan.');window.location='../../index.php?page=produk';</script>";
						// echo "<script>alert('data berhasil disimpan.');";
					}else{
						echo "<script>alert('data gagal disimpan.'); window.location='../../index.php?page=produk';</script>";
						// echo "<script>alert('data gagal disimpan.'); ";
					}
					
				}
				?>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="../../assets/js/jquery-3.5.1.min.js"></script>
	<script type="text/javascript" src="../../assets/js/bootstrap.min.js"></script>
</body>

</html>