<?php
	session_start();

	// Periksa apakah session username sudah di-set
	if (!isset($_SESSION['username'])) {
		// Redirect kembali ke halaman login
		header('Location: pages/login/login.php');
		exit();
	}

	if(!isset($_GET['page'])){
		// header("Location: index.php?page=welcome");
		header("Location: index.php?page=home");
		exit();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>PEMROGRAMAN WEB - SI</title>
</head>
<!-- BOOTSTRAP 4 -->
<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
<script type="text/javascript" src="assets/js/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>

<!-- DATA TABLES -->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">

<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"> -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">

<script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>

<!-- SweetAlert CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.min.css">

<!-- SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.all.min.js"></script>

<body>
	
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<!-- Tampilkan Menu Bar -->
		<?php include("menu_atas.php");?>
	</nav>

	<div class="container col-md-6 mt-4">	
		<div id="isi-content">
			<!-- Load halaman per page di sini -->
			<?php
				if(isset($_GET['page'])){
					$title = $_GET['page'];
				
					// Validasi nilai $title
					$allowedPages = ['welcome', 'home', 'produk', 'user', 'transaksi']; // Daftar halaman yang diizinkan
				
					if(in_array($title, $allowedPages)){
						$filename = "pages/".$title."/".$title . ".php";
				
						// Pastikan file ada sebelum memasukkan
						if(file_exists($filename)){
							include($filename);
						} else {
							echo "Halaman tidak ditemukan";
						}
					} else {
						echo "Halaman tidak valid";
					}
				}
				
			?>
		</div>
	</div>


</body>
</html>