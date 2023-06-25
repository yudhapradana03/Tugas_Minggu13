	<h3>TABEL USER</h3>
	<div class="card">
		<div class="card-header bg-info text-white ">
			DAFTAR USER 				
			<button type="button" class="btn btn-sm btn-success float-right" data-toggle="modal" data-target="#userModal">
				Tambah
			</button>
		</div>
		

		<div class="card-body">
					
			<!-- <table id="tbUser" class="table table-bordered"> -->
			<table id="tbUser" class="table datatable">
				<thead>
					<tr>
						<th>No</th>
						<th>Username</th>
						<th>Role</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php
						include('db/koneksi.php'); //memanggil file koneksi
						$datas = mysqli_query($koneksi, "select * from user") or die(mysqli_error($koneksi));
						//script untuk menampilkan data barang

						$no = 1;//untuk pengurutan nomor

						//melakukan perulangan
						while($row = mysqli_fetch_assoc($datas)) {
					?>	

				<tr>
					<td><?= $no; ?></td>						
					<td><?= $row['username']; ?></td>
					<td><?= $row['role']; ?></td>						
					<td>
							<!-- <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editUserModal">
								Edit
							</button> -->
							<!-- <button type="button" class="btn btn-sm btn-warning" id="edit-btn" data-userid="<?= $row['id']; ?>">Edit</button> -->
							<button type="button" class="btn btn-sm btn-warning edit-btn" data-userid="<?= $row['id']; ?>">Edit</button>								
							<a href="pages/user/hapus_user.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('anda yakin ingin hapus?');">Hapus</a>
					</td>
				</tr>

					<?php $no++; } ?>
				</tbody>
			</table>
			
		</div>
	</div>
	

	<!-- Modal Tambah -->
	<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="userModalLabel">Tambah User</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<form id="userForm" method="POST" action="pages/user/simpan_user.php">
			<div class="form-group">
				<label for="username">Username</label>
				<input type="text" class="form-control" id="username" name="username" required>
			</div>
			<div class="form-group">
			<label for="role">Select Role:</label>
			<select class="form-control" id="role" name="role" required>
				<option value="Super Admin">Super Admin</option>
				<option value="Admin">Admin</option>
				<option value="User">User</option>
			</select>
			</div>
			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" class="form-control" id="password" name="password" required>
			</div>
			<button type="submit" class="btn btn-primary">Simpan</button>
			</form>
		</div>
		</div>
	</div>
	</div>
	<!-- END of MODAL TAMBAH -->

	
	<div id="seg-modal">

	</div>
	


<script>
$(document).ready(function() {
    $('.edit-btn').on('click', function() {
        var userID = $(this).data('userid'); //userid didapat dari id yang dikirimkan melalui tombol edit
        $('#seg-modal').load('pages/user/editUser_modal.php?id=' + userID, function() {
            $('#myModal').modal('show');
        });	
    });
});

$(document).ready(function () {
	$('#tbUser').DataTable({
		"lengthMenu": [2, 5, 50, 100], // Menentukan pilihan jumlah baris per halaman
		"pageLength": 2 // Jumlah baris per halaman default
	});
	
});



</script>



