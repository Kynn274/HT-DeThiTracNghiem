<?php
	require_once("method/database.php");
	ob_start();
	if (session_status() == PHP_SESSION_NONE) {
    	session_start();
	}

	$is_logged_in = isset($_SESSION['user_id']);
	if ($is_logged_in) {
    	$user_id = $_SESSION['user_id'];
    	$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';//Sua thanh cap nhat ten lai neu co thay doi
    	$user_type = $_SESSION['user_type'];
		$user_fullname = $_SESSION['user_fullname'];
    	//$user_type = 'admin';
	}
?>

<div class="site-mobile-menu site-navbar-target">
		<div class="site-mobile-menu-header">
			<div class="site-mobile-menu-close">
				<span class="icofont-close js-menu-toggle"></span>
			</div>
		</div>
		<div class="site-mobile-menu-body">
		</div>
	</div>

	<nav class="site-nav">
		<div class="container">
			<div class="menu-bg-wrap">
				<div class="site-navigation">
					<div class="row g-0 align-items-center">
						<div class="col-2">
							<a href="index.php" class="logo m-0 float-start"><span class="text-primary">ContestOnline</span></a>
						</div>
						<div class="col-8 text-center">
							<ul class="js-clone-nav d-none d-lg-inline-block text-start site-menu mx-auto fw-bold">
								<li class="active"><a href="index.php">Trang Chủ</a></li>
								<li class="has-children">
									<a href="#">Chế độ</a>
									<ul class="dropdown">
										<li class="fw-normal" style="width:fit-content;" ><a href="TaoDeThi.php">Tạo Đề Thi / Cuộc Thi</a></li>
										<li class="fw-normal" style="width:fit-content;"><a href="QuanLyNguoiDung.php">Quản lý Người Dùng</a></li>
										<li class="fw-normal" style="width:fit-content;"><a href="QuanLyThuVienDeThi.php">Quản Lý Thư Viện Đề Thi</a></li>
										<li class="fw-normal" style="width:fit-content;"><a href="QuanLyDeThi.php">Quản Lý Đề Thi</a></li>
										<li class="fw-normal" style="width:fit-content;"><a href="LichSuCuocThi.php">Lịch Sử Cuộc Thi</a></li>
										<li class="fw-normal" style="width:fit-content;"><a href="<?php echo $is_logged_in? 'ThamGiaThi.php' : 'DangNhap.php' ?>">Tham Gia Cuộc Thi</a></li>
									</ul>
								</li>
								<li><a href="LienHe.php">Liên Hệ</a></li>
							
						</div>
						<?php if(!$is_logged_in): ?>
						<div class="col-2 text-end">
							<div class="d-flex justify-content-end align-items-center">
								<a href="DangNhap.php" class="auth-btn login-btn text-decoration-none fw-bold">
									<i class="bi bi-box-arrow-in-right me-1"></i>
									Đăng nhập
								</a>
								<a href="DangKy.php" class="auth-btn register-btn text-decoration-none fw-bold">
									<i class="bi bi-person-plus me-1"></i>
									Đăng ký
								</a>
								<a href="#" class="burger ms-3 float-end site-menu-toggle js-menu-toggle d-inline-block d-lg-none light">
									<span></span>
								</a>
							</div>
						</div>
						<?php endif; ?>
						<?php if($is_logged_in): ?>
							<div class="col-2 text-end">
							<div class="d-flex justify-content-end align-items-center">
								<a href="DangNhap.php" class="auth-btn userInfo-btn text-decoration-none fw-bold">
									<?php echo htmlspecialchars($user_fullname); ?>
								</a>
								<a href="logout.php" class="auth-btn logout-btn text-decoration-none fw-bold">
									<i class="bi bi-door-open-fill me-1"></i>
									Đăng xuất
								</a>
								<a href="#" class="burger ms-3 float-end site-menu-toggle js-menu-toggle d-inline-block d-lg-none light">
									<span></span>
								</a>
							</div>
						</div>
						<?php endif ?>

					</div>
				</div>
			</div>
		</div>
	</nav>