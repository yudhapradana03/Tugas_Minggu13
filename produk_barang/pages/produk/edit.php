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
			<div class="card-header bg-success text-white ">
				Edit Barang
			</div>
			<div class="card-body">
				<?php
				include('../../db/koneksi.php');
				include('../../lib/uploadFoto.php');

				$id = $_GET['id']; //mengambil id barang yang ingin diubah

				//menampilkan barang berdasarkan id
				$data = mysqli_query($koneksi, "select * from barang where id = '$id'");
				$row = mysqli_fetch_assoc($data);

				?>
				<form action="" method="post" role="form" enctype="multipart/form-data">
					<div class="form-group">
						<label>Nama Barang</label>
						<!--  menampilkan nama barang -->
						<input type="text" name="nama" required="" class="form-control" value="<?= $row['nama']; ?>">

						<!-- ini digunakan untuk menampung id yang ingin diubah -->
						<input type="hidden" name="id" required="" value="<?= $row['id']; ?>">
					</div>
					<div class="form-group">
						<label for="keterangan">Keterangan:</label>
						<input type="text" class="form-control" required="" name="keterangan"  value="<?= $row['keterangan']; ?>" >
					</div>
					<div class="form-group">
						<label>Harga</label>
						<input type="text" name="harga" required="" class="form-control" value="<?= $row['harga']; ?>" >
					</div>

					<div class="form-group">
						<label for="jumlah">jumlah:</label>
						<input type="number" class="form-control" required="" id="jumlah" name="jumlah" value="<?= $row['jumlah']; ?>" >
					</div>
					<div class="form-group">
					    <label for="foto">Foto:</label>
					    <input type="file" name="foto" class="form-control-file" id="foto"></div></br>
					    <img src="../../assets/img/<?= $row['foto']; ?>" width="150px" height="120px" /></br>
					</div>

					<div class="form-check">
					  <input type='hidden' name='foto_lama' value="<?= $foto;?>">

					  <input class="form-check-input" type="checkbox" name="ubah_foto" value="true" id="ubah_foto">
					  <label class="form-check-label" for="ubah_foto">
					    Checklist jika ingin mengubah foto
					  </label></br>
					</div>
					

					<button type="submit" class="btn btn-primary" name="submit" value="simpan">update data</button>
				</form>

				<?php			

				if (isset($_POST['submit'])) {
					$id = $_POST['id'];
					$nama = $_POST['nama'];
					$keterangan = $_POST['keterangan'];
					$harga = $_POST['harga'];
					$jumlah = $_POST['jumlah'];
					$foto = $_POST['foto'];
					$foto_lama=$_POST['foto_lama'];
	  				$flagFoto=true;
					if(isset($_POST['ubah_foto'])){ 	
					    if (upload_foto($_FILES["foto"])){
							$foto=$_FILES["foto"]["name"];
							$result = mysqli_query($koneksi, "update barang set nama='$nama', keterangan='$keterangan', harga='$harga', jumlah='$jumlah', foto='$foto' where id ='$id'") or die(mysqli_error($koneksi));

							echo "<script>alert('data & foto berhasil diupdate.');window.location='../../index.php?page=produk';</script>";
						}	
						else{
							echo "<script>alert('foto gagal diupload.');window.location='../../index.php?page=produk';</script>";
						}			
					 }else{
					 	// UPDATE DATA TANPA GANTI FOTO 						
						$result = mysqli_query($koneksi, "update barang set nama='$nama', keterangan='$keterangan', harga='$harga', jumlah='$jumlah' where id ='$id'") or die(mysqli_error($koneksi));
						$flagFoto=false;
						echo "<script>alert('data berhasil diupdate.');window.location='../../index.php?page=produk';</script>";
					 }

					if(mysqli_affected_rows($koneksi) > 0) {
					    // Kode untuk menghapus file foto lama jika ada dan flagFoto true
					    if(is_file("../../assets/img/".$foto_lama) && ($flagFoto==true)) {
					        unlink("../../assets/img/".$foto_lama);
					        header("location:index.php?page=produk"); 
					    }
					}else{
						$conn->close();
						echo "New records failed";		  	  
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