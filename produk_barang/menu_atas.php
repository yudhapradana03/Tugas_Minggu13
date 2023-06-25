<?php
    // session_start();
    // Periksa role pengguna
	$username = $_SESSION['username'];
	$role = $_SESSION['role'];

	// Fungsi untuk memeriksa apakah role adalah "Super Admin"
	function isSuperAdmin($role)
	{
		return $role === 'Super Admin';
	}

    // Fungsi untuk memeriksa apakah role adalah "Admin"
	function isAdmin($role)
	{
		return $role === 'Admin';
	}

    // Fungsi untuk memeriksa apakah role adalah "User"
	function isUser($role)
	{
		return $role === 'User';
	}


?>

<div class="container-fluid">
	<div class="navbar-collapse">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item">
				<a class="nav-link <?php echo ((!isset($_GET['page']) || $_GET['page'] == 'home') ? 'active' : ''); ?>" href="index.php?page=home">Home</a>
			</li>		
			<?php if (isSuperAdmin($role) || isAdmin($role)): ?>
				<li class="nav-item">
					<a class="nav-link <?php echo ($_GET['page'] == 'produk') ? 'active' : ''; ?>" href="index.php?page=produk">Produk</a>
				</li>
			<?php endif; ?>		
			<?php if (isSuperAdmin($role)): ?>
				<li class="nav-item">
					<a class="nav-link <?php echo ($_GET['page'] == 'user') ? 'active' : ''; ?>" href="index.php?page=user">User</a>
				</li>
			<?php endif; ?>

			<li class="nav-item">
				<a class="nav-link <?php echo ($_GET['page'] == 'user') ? 'active' : ''; ?>" href="index.php?page=transaksi">Transaksi</a>
			</li>
			
		</ul>
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link">Hi, <?php echo $username; ?></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="pages/login/logout.php">Logout?</a>
			</li>
		</ul>
	</div>
</div>

