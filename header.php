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

<style>
@media (max-width: 992px) {
    #logo-text {
        display: none !important;
    }
}

.site-nav {
    position: fixed;
    width: 100%;
    top: 0;
    z-index: 1000;
    background: transparent;
    transition: all 0.3s ease;
}

.menu-bg-wrap {
    border-bottom-left-radius: 20px;
    border-bottom-right-radius: 20px;
    margin-top: 15px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    background: rgba(255, 255, 255, 0.05);
}

.site-menu > li > a {
    padding: 10px 15px;
    transition: all 0.3s ease;
    position: relative;
}

.site-menu > li > a:after {
    content: '';
    position: absolute;
    width: 0;
    height: 2px;
    bottom: 0;
    left: 50%;
    background: var(--primary);
    transition: all 0.3s ease;
    transform: translateX(-50%);
}

.site-menu > li > a:hover:after {
    width: 80%;
}

.auth-btn {
    padding: 8px 15px;
    border-radius: 5px;
    transition: all 0.3s ease;
    margin: 0 5px;
}

.login-btn {
    background: transparent;
    border: 2px solid #007bff;
    color: #007bff;
}

.login-btn:hover {
    background: #007bff;
    color: white;
}

.register-btn, .logout-btn {
    background: #007bff;
    color: white;
}

.register-btn:hover, .logout-btn:hover {
    background: #0056b3;
    color: white;
}

.userInfo-btn {
    background: #0056b3;
    border: 1px solid #dee2e6;
}

.userInfo-btn:hover {
    background: #e9ecef;
}

.dropdown {
    background: white;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding: 10px 0;
}

.dropdown li a {
    padding: 8px 20px;
    transition: all 0.2s ease;
}

.dropdown li a:hover {
    background: #f8f9fa;
    color: var(--primary);
}

.menu-bg-wrap.scrolled {
    background: #1d42c5;
    box-shadow: 0 5px 30px rgba(0, 0, 0, 0.1);
}
</style>
<script>
	$(window).scroll(function() {
		if ($(this).scrollTop() > 50) {
			$('.menu-bg-wrap').addClass('scrolled');
		} else {
			$('.menu-bg-wrap').removeClass('scrolled');
		}
	});
</script>
<div class="site-mobile-menu site-navbar-target">
		<div class="site-mobile-menu-header">
			<div class="site-mobile-menu-close me-3">
				<span class="close-menu"></span>
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
						<div class="col-3 logo">
							<a href="index.php"><img src="images/logo.png" alt="logo"></a>
							<a href="index.php" class="logo m-0 float-start" id="logo-text"><span class="text-primary">MindBridge <br> Institute</span></a>
						</div>
						<div class="col-5 text-center">
							<ul class="js-clone-nav d-none d-lg-inline-block text-start site-menu mx-auto fw-bold">
								<li class="active"><a href="index.php">TRANG CHỦ</a></li>
								<li><a href="<?php echo $is_logged_in? 'contestZone.php' : 'DangNhap.php' ?>">CUỘC THI</a></li>
								<?php if($is_logged_in): 
									if($user_type == 0 || $user_type == 2): ?>
										<li class="has-children">
											<a href="#">CHẾ ĐỘ</a>
											<ul class="dropdown">
												<?php if($is_logged_in): 
													if($user_type == 0 && $user_type != 2): ?>
														<li class="fw-normal" style="width:fit-content;"><a href="QuanLyNguoiDung.php">Quản lý người dùng</a></li>
													<?php endif; ?>
													<?php if($user_type == 2 || $user_type == 0): ?>
														<li class="fw-normal" style="width:fit-content;"><a href="<?php echo $is_logged_in? 'contest.php' : 'DangNhap.php' ?>">Tạo cuộc thi</a></li>
														<li class="fw-normal" style="width:fit-content;"><a href="<?php echo $is_logged_in? 'test.php' : 'DangNhap.php' ?>">Tạo đề thi</a></li>
														<li class="fw-normal" style="width:fit-content;"><a href="<?php echo $is_logged_in? 'questionsBank.php' : 'DangNhap.php' ?>">Quản lý ngân hàng câu hỏi</a></li>
													<?php endif; ?>
												<?php endif; ?>
											</ul>
										</li>
									<?php endif; ?>
								<?php endif; ?>
							<li><a href="LienHe.php">LIÊN HỆ</a></li>
						</div>
						<?php if(!$is_logged_in): ?>
						<div class="col-4 text-end">
							<div class="d-flex justify-content-end align-items-center">
								<a href="DangNhap.php" class="auth-btn login-btn text-decoration-none fw-bold">
									<i class="bi bi-box-arrow-in-right me-1"></i>
									ĐĂNG NHẬP
								</a>
								<a href="DangKy.php" class="auth-btn register-btn me-3 text-decoration-none fw-bold">
									<i class="bi bi-person-plus me-1"></i>
									ĐĂNG KÝ
								</a>
								<button class="burger border-0 me-3 float-end bg-transparent site-menu-toggle open-menu d-inline-block d-lg-none light">
									<span></span>
								</button>
							</div>
						</div>
						<?php endif; ?>
						<?php if($is_logged_in): ?>
							<div class="col-4 text-end">
							<div class="d-flex justify-content-end align-items-center">
								<a href="ChinhSuaThongTinCaNhan.php" class="auth-btn userInfo-btn text-decoration-none fw-bold" value="<?php echo $user_id; ?>">
									<?php echo htmlspecialchars($user_fullname); ?>
								</a>
								<a href="logout.php" class="auth-btn logout-btn me-3 text-decoration-none fw-bold">
									<i class="bi bi-door-open-fill me-1"></i>
									ĐĂNG XUẤT
								</a>
								<button class="burger border-0 me-3 float-end bg-transparent site-menu-toggle open-menu d-inline-block d-lg-none light" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
									<span></span>
								</button>
							</div>
						</div>
						<?php endif ?>

					</div>
				</div>
			</div>
		</div>
	</nav>