<h3>TABEL STOK BARANG</h3>
<div class="card">
	<div class="card-header bg-info text-white ">
		DATA BARANG <a href="pages/produk/tambah.php" class="btn btn-sm btn-success float-right">Tambah</a>
		<!-- <a href="pdf_data_barang.php" target="_blank" class="btn btn-sm btn-primary float-right">Download Laporan</a> -->
	</div>
	<!-- <div id="tb-produk_wrapper">
		<div class="dt-buttons">
			<button class="dt-button buttons-excel">Excel</button>
			<button class="dt-button buttons-csv">CSV</button>
			<button class="dt-button buttons-pdf">PDF</button>
			<button class="dt-button buttons-print">Print</button>
		</div>
	</div> -->
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
						<a href="pages/produk/edit.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning" >Edit</a>
						<a href="pages/produk/hapus.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('anda yakin ingin hapus?');">Hapus</a>
				</td>
			</tr>

				<?php $no++; } ?>
			</tbody>
		</table>
		
	</div>
</div>


<script>
	$(document).ready(function () {
		$('#tb-produk').DataTable({
			// "lengthMenu": [2, 5, 50, 100], // Menentukan pilihan jumlah baris per halaman
        	"pageLength": 2, // Jumlah baris per halaman default
			dom: 'Bfrtip',
			// buttons: [
			// 	'excel',
			// 	'csv',
			// 	'pdf',
			// 	'print'
			// ]
			buttons: [
            {
                extend: 'excel',
                exportOptions: {
                    columns: [0, 2, 3, 4] // Kolom yang ingin diexport
                },
                title: "Laporan Data Barang (Excel)"
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: [0, 2, 3, 4] // Kolom yang ingin diexport
                },
                title: "Laporan Data Barang (CSV)"
            },
            {
                extend: 'pdf',
                exportOptions: {
                    columns: [0, 2, 3, 4] // Kolom yang ingin diexport
                },
                title: "Laporan Data Barang (PDF)"
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: [0, 2, 3, 4] // Kolom yang ingin diexport
                },
                title: "Laporan Data Barang (Print)"
            }
        ]
		});
	});
</script>