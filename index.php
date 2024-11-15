<?php
	include 'head.php';
	require_once 'method/init.php';
	require_once 'method/database.php';
?>
<body>
	<?php
		include 'header.php';
	?>

	<div class="hero overlay">
		<img src="images/blob.svg" alt="" class="img-fluid blob">
		<div class="container">
			<div class="row align-items-center justify-content-between pt-5">
				<div class="col-lg-6 text-center text-lg-start pe-lg-5">
					<h1 class="heading text-white mb-3" data-aos="fade-up">MindBridgeInstitute</h1>
					<!-- <div class="align-items-center mb-5 mm" data-aos="fade-up" data-aos-delay="200">
						<a href="LienHe.php" class="btn btn-outline-white-reverse me-4">Liên Hệ</a>
						<a href="#" class="text-white glightbox">Watch the video</a>
					</div> -->
				</div>
				<div class="col-lg-6" data-aos="fade-up" data-aos-delay="300">
					<div class="img-wrap">
						<img src="images/img_7.jpg" alt="Image" class="img-fluid rounded">
					</div>
				</div>
			</div>
		</div>
	</div>


	<div class="section">
	<div class="container">
		<div class="row justify-content-between">
			<div class="col-lg-7 mb-4 mb-lg-0">
				<img src="images/img_8.jpg" alt="Image" class="img-fluid rounded">
			</div>
			<div class="col-lg-4 ps-lg-2">
				<div class="mb-5">
					<h2 class="text-black h4">BẮT ĐẦU NGAY</h2>
					<p>Nền tảng của chúng tôi giúp đơn giản hóa quá trình tạo đề thi, cho phép bạn thiết kế các bài kiểm tra trắc nghiệm tùy chỉnh một cách dễ dàng và hiệu quả.</p>
				</div>

				<!-- Tạo Đề Thi / Cuộc Thi -->
				<div class="d-flex mb-3 service-alt">
					<div>
						<span class="bi-pencil-square me-4"></span>
					</div>
					<div>
						<h3>TẠO ĐỀ THI / CUỘC THI</h3>
						<p>Tạo ra các đề thi hoặc cuộc thi mới với các tính năng linh hoạt và dễ dàng tùy chỉnh.</p>
					</div>
				</div>

				<!-- Quản Lý Đề Thi -->
				<div class="d-flex mb-3 service-alt">
					<div>
						<span class="bi-file-earmark-text-fill me-4"></span>
					</div>
					<div>
						<h3>QUẢN LÝ ĐỀ THI</h3>
						<p>Quản lý các đề thi đã tạo, chỉnh sửa và cập nhật nội dung một cách thuận tiện.</p>
					</div>
				</div>

				<!-- Quản Lý Thư Viện Đề Thi -->
				<div class="d-flex mb-3 service-alt">
					<div>
						<span class="bi-bookmark-fill me-4"></span>
					</div>
					<div>
						<h3>QUẢN LÝ NGÂN HÀNG CÂU HÒI</h3>
						<p>Quản lý và lưu trữ các câu hỏi trong ngân hàng, dễ dàng tìm kiếm và tái sử dụng các câu hỏi cũ.</p>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>


	<div class="section sec-features">
		<div class="container">
			<div class="row g-5">
				<div class="col-12 col-sm-6 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="0">
					<div class="feature d-flex">
						<span class="bi-clipboard-check"></span>
						<div>
							<h3>HỌC SINH</h3>
							<p>Học sinh có thể dễ dàng tự luyện tập với nhiều dạng câu hỏi và bài thi mô phỏng, từ đó đánh giá năng lực của mình, xác định được điểm mạnh và những phần cần cải thiện.</p>
						</div>
					</div>
				</div>
				<div class="col-12 col-sm-6 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
					<div class="feature d-flex">
						<span class="bi-calendar-check-fill"></span>
						<div>
							<h3>GIÁO VIÊN</h3>
							<p>Thao tác tạo đề đơn giản, chính xác cùng phương pháp đánh giá hiệu quả, giúp giáo viên dễ dàng quản lý chất lượng giảng dạy.</p>
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</div>
	
	

	<div class="section">
		<div class="container">
			<div class="row">
				<div class="col-lg-7 order-lg-4 mb-4 mb-lg-0">
					<img src="images/img_9.png" alt="Create Exam" class="img-fluid">
				</div>
				<div class="col-lg-5 pe-lg-5">
					<div class="mb-5">
						<h2 class="text-black h4">CÁCH TẠO ĐỀ THI ĐƠN GIẢN</h2>
					</div>
	
					<!-- Mô tả câu hỏi và đáp án -->
					<div class="d-flex mb-3 service-alt">
						<div>
							<span class="bi-pencil-square me-4"></span>
						</div>
						<div>
							<h3>MÔ TẢ CÂU HỎI VÀ ĐÁP ÁN</h3>
							<p>Nhập câu hỏi và đưa ra các đáp án để tạo đề thi.</p>
						</div>
					</div>
	
					<!-- Chọn môn học -->
					<div class="d-flex mb-3 service-alt">
						<div>
							<s class="bi-bookmark-fill me-4"></s	pan>
						</div>
						<div>
							<h3>CHỌN ĐÁP ÁN ĐÚNG</h3>
							<p>Chọn đáp án đúng của câu hỏi.</p>
						</div>
					</div>
	
					<!-- Chọn dạng câu hỏi
					<div class="d-flex mb-3 service-alt">
						<div>
							<span class="bi-file-earmark-text-fill me-4"></span>
						</div>
						<div>
							<h3>Chọn Dạng Câu Hỏi</h3>
							<p>Chọn dạng câu hỏi như Trắc nghiệm, Điền khuyết, Tự luận, ...</p>
						</div>
					</div> -->
	
					<!-- Chọn độ khó -->
					<div class="d-flex mb-3 service-alt">
						<div>
							<span class="bi-bar-chart-fill me-4"></span>
						</div>
						<div>
							<h3>CHỌN ĐỘ KHÓ</h3>
							<p>Đặt độ khó cho đề thi, từ dễ đến khó để phù hợp với trình độ học sinh.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	
	<?php 
		// Kiểm tra đăng nhập và vai trò
		// session_start();
		// if (!isset($_SESSION['user_id'])) {
		// 	// Nếu chưa đăng nhập, chuyển hướng tới trang đăng nhập
		// 	$redirect_url = "login.php"; // Trang đăng nhập
		// 	$role = '';
		// } else {
		// 	// Nếu đã đăng nhập, lấy vai trò từ session
		// 	$role = $_SESSION['role']; // Vai trò người dùng (admin, teacher, student)
		// }

		// // Hàm để hiển thị các dịch vụ theo vai trò
		// function displayService($role, $service) {
		// 	// Kiểm tra và hiển thị dịch vụ phù hợp
		// 	$servicesForTeacher = ['create_exam', 'library_management', 'manage_exam', 'history_exam'];
		// 	$servicesForStudent = ['history_exam', 'join_exam'];
		// 	$servicesForAdmin = ['create_exam', 'library_management', 'manage_exam', 'history_exam', 'join_exam'];

		// 	if ($role == 'admin') {
		// 		return in_array($service, $servicesForAdmin);
		// 	} elseif ($role == 'teacher') {
		// 		return in_array($service, $servicesForTeacher);
		// 	} elseif ($role == 'student') {
		// 		return in_array($service, $servicesForStudent);
		// 	}
		// 	return false; // Nếu không phải là một vai trò hợp lệ
		// }
	?>

		<div class="section sec-services">
			<div class="container">
				<div class="row mb-5">
					<div class="col-lg-5 mx-auto text-center" data-aos="fade-up">
						<h2 class="heading text-primary">DỊCH VỤ QUẢN LÝ ĐỀ THI TRẮC NGHIỆM</h2>
						<p>Hệ thống cung cấp các tính năng quản lý và tạo đề thi trắc nghiệm một cách nhanh chóng và dễ dàng.</p>
					</div>
				</div>

				<div class="row">
					<!-- Tạo Đề Thi / Cuộc Thi -->
					<?php //if (displayService($role, 'create_exam')): ?>
					<div class="col-12 col-sm-6 col-md-6 col-lg-4" data-aos="fade-up">
						<div class="service text-center">
							<span class="bi-pencil-square"></span>
							<div>
								<h3>TẠO ĐỀ THI</h3>
								<p class="mb-4">Tạo đề thi hoặc cuộc thi mới với các tính năng linh hoạt.</p>
								<p><a href="TaoDeThi.php" class="btn btn-outline-primary py-2 px-3">Bắt Đầu</a></p>
							</div>
						</div>
					</div>
					<?php //endif; ?>

					<!-- Quản Lý Người Dùng -->
					<?php //if ($role == 'admin' && displayService($role, 'manage_user')): ?>
					<div class="col-12 col-sm-6 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
						<div class="service text-center">
							<span class="bi-person-fill"></span>
							<div>
								<h3>QUẢN LÝ NGƯỜI DÙNG</h3>
								<p class="mb-4">Quản lý thông tin người dùng trong hệ thống.</p>
								<p><a href="QuanLyNguoiDung.php" class="btn btn-outline-primary py-2 px-3">Bắt Đầu</a></p>
							</div>
						</div>
					</div>
					<?php //endif; ?>

					<!-- Quản Lý Thư Viện Đề Thi -->
					<?php //if (displayService($role, 'library_management')): ?>
					<div class="col-12 col-sm-6 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
						<div class="service text-center">
							<span class="bi-bookmark-fill"></span>
							<div>
								<h3>QUẢN LÝ THƯ VIỆN ĐỀ THI</h3>
								<p class="mb-4">Quản lý các đề thi trong thư viện.</p>
								<p><a href="QuanLyNganHangCauHoi.php" class="btn btn-outline-primary py-2 px-3">Bắt Đầu</a></p>
							</div>
						</div>
					</div>
					<?php //endif; ?>

					<!-- Quản Lý Đề Thi -->
					<?php //if (displayService($role, 'manage_exam')): ?>
					<div class="col-12 col-sm-6 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
						<div class="service text-center">
							<span class="bi-file-earmark-text-fill"></span>
							<div>
								<h3>QUẢN LÝ ĐỀ THI</h3>
								<p class="mb-4">Quản lý và chỉnh sửa các đề thi đã tạo.</p>
								<p><a href="QuanLyDeThi.php" class="btn btn-outline-primary py-2 px-3">Bắt Đầu</a></p>
							</div>
						</div>
					</div>
					<?php //endif; ?>

					<!-- Lịch Sử Cuộc Thi -->
					<?php //if (displayService($role, 'history_exam')): ?>
					<div class="col-12 col-sm-6 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
						<div class="service text-center">
							<span class="bi-clock-history"></span>
							<div>
								<h3>LỊCH SỬ CUỘC THI</h3>
								<p class="mb-4">Xem lại lịch sử các cuộc thi đã diễn ra.</p>
								<p><a href="LichSuCuocThi.php" class="btn btn-outline-primary py-2 px-3">Bắt Đầu</a></p>
							</div>
						</div>
					</div>
					<?php //endif; ?>

					<!-- Tham Gia Cuộc Thi -->
					<?php //if (displayService($role, 'join_exam')): ?>
					<div class="col-12 col-sm-6 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
						<div class="service text-center">
							<span class="bi-person-check-fill"></span>
							<div>
								<h3>THAM GIA CUỘC THI</h3>
								<p class="mb-4">Tham gia các cuộc thi trắc nghiệm.</p>
								<p><a href="ThamGiaThi.php" class="btn btn-outline-primary py-2 px-3">Bắt Đầu</a></p>
							</div>
						</div>
					</div>
					<?php //endif; ?>
				</div>
			</div>
		</div>



	<div class="section sec-portfolio bg-light pb-5">
		<div class="container">
			<div class="row mb-5">
				<div class="col-lg-5 mx-auto text-center">
					<h2 class="heading text-primary mb-3" data-aos="fade-up" data-aos-delay="0">CÁC ĐỀ THI TRẮC NGHIỆM</h2>
					<p class="mb-4" data-aos="fade-up" data-aos-delay="100">Khám phá và tạo các đề thi trắc nghiệm phù hợp với yêu cầu của bạn. Chọn môn học, loại câu hỏi, và mức độ khó để bắt đầu tạo đề thi ngay.</p>
	
					<div id="post-slider-nav" data-aos="fade-up" data-aos-delay="200">
						<button class="btn btn-primary py-2" class="prev" data-controls="prev">Trở lại</button>
						<button class="btn btn-primary py-2" class="next" data-controls="next">Tiếp theo</button>
					</div>
				</div>
			</div>
		</div>
	
		<div class="post-slider-wrap" data-aos="fade-up" data-aos-delay="300">
			<div id="post-slider" class="post-slider">
				<div class="item">
					<a href="TaoDeThi.php" class="card d-block">
						<img src="images/img_10.jpg" class="card-img-top" alt="Image">
						<div class="card-body">
							<h5 class="card-title">TẠO ĐỀ THI MỚI</h5>
							<p>Chọn môn học và loại câu hỏi để tạo một đề thi trắc nghiệm hoàn chỉnh.</p>
						</div>
					</a>
				</div>
	
				<div class="item">
					<a href="TaoDeThi.php" class="card">
						<img src="images/img_1.jpeg" class="card-img-top" alt="Image">
						<div class="card-body">
							<h5 class="card-title">CHỈNH SỬA ĐỀ THI</h5>
							<p>Chỉnh sửa các câu hỏi hoặc thay đổi cấu trúc đề thi trắc nghiệm đã tạo.</p>
						</div>
					</a>
				</div>
	
				<div class="item">
					<a href="XemDanhSachDeThi.php" class="card">
						<img src="images/img_2.jpg" class="card-img-top" alt="Image">
						<div class="card-body">
							<h5 class="card-title">DANH SÁCH ĐỀ THI</h5>
							<p>Xem lại các đề thi trắc nghiệm đã được tạo và quản lý chúng.</p>
						</div>
					</a>
				</div>
	
				<div class="item">
					<a href="XemDanhSachDeThi.php" class="card">
						<img src="images/img_11.jpg" class="card-img-top" alt="Image">
						<div class="card-body">
							<h5 class="card-title">QUẢN LÝ ĐỀ THI</h5>
							<p>Quản lý, chỉnh sửa và xóa các đề thi trắc nghiệm trong hệ thống.</p>
						</div>
					</a>
				</div>
	
				<!-- <div class="item">
					<a href="TaoDeThi.php" class="card">
						<img src="images/img_3.jpg" class="card-img-top" alt="Image">
						<div class="card-body">
							<h5 class="card-title">Tạo Đề Thi Mới</h5>
							<p>Bắt đầu tạo đề thi trắc nghiệm cho các môn học và các chủ đề khác nhau.</p>
						</div>
					</a>
				</div> -->
			</div>
		</div>
	</div>
</div>

<!-- <div class="site-footer">
	<div class="container">
		<div class="row">
			<div class="col-lg-4">
				<div class="widget">
					<h3>About</h3>
					<p>Nền tảng của chúng tôi giúp đơn giản hóa quá trình tạo đề thi, cho phép bạn thiết kế các bài kiểm tra trắc nghiệm tùy chỉnh một cách dễ dàng và hiệu quả.</p>
				</div> <!-- /.widget --
				<div class="widget">
					<ul class="list-unstyled links">
						<li><a href="tel://11234567890">0967945035</a></li>
						<li><a href="tel://11234567890">0967363153</a></li>
						<li><a href="mailto:support@examplatform.com">duongbaotran018@gmail.com</a></li>
					</ul>
				</div> <!-- /.widget --
			</div> <!-- /.col-lg-4 --
			<div class="col-lg-4">
				<div class="widget">
					<h3 class="widget-title">Category</h3>
					<ul class="list-unstyled links">
						<li><a href="TaoDeThi.php"><span class="icon-arrow-right"></span> Tạo Đề Thi</a></li>
						<li><a href="QuanLyNguoiDung.php"><span class="icon-arrow-right"></span> Quản lý Người Dùng</a></li>
						<li><a href="QuanLyDeThi.php"><span class="icon-arrow-right"></span> Quản Lý Đề Thi</a></li>
						<li><a href="TimKiemCuocThi.php"><span class="icon-arrow-right"></span> Tìm Kiếm Cuộc Thi</a></li>
						<li><a href="LichSuCuocThi.php"><span class="icon-arrow-right"></span> Lịch Sử Cuộc Thi</a></li>
						<li class="has-children">
							<a href="#"><span class="icon-arrow-right"></span> Khác</a>
							<ul class="dropdown">
								<li><a href="QuanLyThuVienDeThi.php">Quản Lý Thư Viện Đề Thi</a></li>
								<li><a href="CheDoThi.php">Chế Độ Thi</a></li>
								<li><a href="ThamGiaThi.php">Tham Gia Thi</a></li>
							</ul>
						</li>
					</ul>
					<ul class="list-unstyled links">
						<li><a href="TaoCuocThi.php"><span class="icon-arrow-right"></span> Tạo Cuộc Thi</a></li>
						<li><a href="LienHe.php"><span class="icon-arrow-right"></span> Liên Hệ</a></li>
					</ul>
				</div> <!-- /.widget --
			</div>
			

			<div class="row mt-5">
				<div class="col-12 text-center">
            	<p>Copyright &copy;<script>document.write(new Date().getFullYear());</script>. All Rights Reserved.
            	</p>
          		</div>
        	</div>
    	</div> 
	</div>
</div> 

    <!-- Preloader --
    <div id="overlayer"></div>
    <div class="loader">
    	<div class="spinner-border text-primary" role="status">
    		<span class="visually-hidden">Loading...</span>
    	</div>
    </div> -->
	<?php
		include 'footer.php';
		include 'javascript.php';
	?>

    <!-- <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/tiny-slider.js"></script>

    <script src="js/flatpickr.min.js"></script>


    <script src="js/aos.js"></script>
    <script src="js/glightbox.min.js"></script>
    <script src="js/navbar.js"></script>
    <script src="js/counter.js"></script>
    <script src="js/custom.js"></script> -->

  </body>
  </html>
