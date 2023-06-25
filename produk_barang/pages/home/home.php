<h3>PILIH BARANG</h3>
<div class="card">
	
	<div class="card-body">
		<!-- <table id="tb-produk" class="table table-bordered display nowrap" style="width:100%"> -->
		<table id="tb-produk" class="table datatable" style="width:100%">
			<thead>
				<tr>
					<th>No</th>
					<th>Foto</th>
					<th>Nama Barang</th>
					<th>Keterangan</th>
					<th>Harga</th>
					<th>Jumlah</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php
					include('db/koneksi.php'); //memanggil file koneksi
					$datas = mysqli_query($koneksi, "select * from barang") or die(mysqli_error($koneksi));
					//script untuk menampilkan data barang

					$no = 1;//untuk pengurutan nomor

					//melakukan perulangan
					while($row = mysqli_fetch_assoc($datas)) {
				?>	

			<tr>
				<td><?= $no; ?></td>
				<td><img src="assets/img/<?= $row['foto'] ?>" style='width:100px;height:100px;'></img></td>
				<td><?= $row['nama']; ?></td>
				<td><?= $row['keterangan']; ?></td>
				<td>Rp <?= $row['harga']; ?></td>
				<td><?= $row['jumlah']; ?></td>
				<td>
					<button class="btn btn-sm btn-success btn-beli" data-id="<?= $row['id']; ?>" data-nama="<?= urlencode($row['nama']); ?>" data-harga="<?= $row['harga']; ?>">Beli</button>
	
					<!-- <a href="pages/transaksi/transaksi.php?action=tambah&id=<?= $row['id']; ?>&nama=<?= urlencode($row['nama']); ?>&harga=<?= $row['harga']; ?>&jumlah=1" class="btn btn-sm btn-success">Beli</a> -->
				</td>
				
			</tr>

				<?php $no++; } ?>
			</tbody>
		</table>
		
	</div>
</div>
<!-- SweetAlert CSS -->
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.min.css"> -->

<!-- SweetAlert JS -->
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.all.min.js"></script> -->

<script>
	$(document).ready(function () {
		$('#tb-produk').DataTable({
			
		});
	});
</script>

<script>
    $(document).ready(function() {
        $('.btn-beli').click(function() {
            var id = $(this).data('id');
            var nama = $(this).data('nama');
            var harga = $(this).data('harga');

            $.ajax({
                url: 'pages/transaksi/tambah_keranjang.php',
                type: 'POST',
                data: {
                    id: id,
                    nama: nama,
                    harga: harga,
                    jumlah: 1
                },
                success: function(response) {
                    console.log(response);
					// alert("Berhasil menambahkan ke Keranjang");
					Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Berhasil menambahkan ke Keranjang'
                    });
                    loadKeranjang();
                }
            });
        });

        function loadKeranjang() {
            $.ajax({
                url: 'pages/transaksi/tampil_keranjang.php',
                type: 'GET',
                success: function(response) {
                    $('#keranjang').html(response);
                }
            });
        }

        loadKeranjang();
    });
</script>