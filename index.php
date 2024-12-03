<?php
	include 'head.php';
	require_once 'method/init.php';
?>
<body>
	<?php
		include 'header.php';
	?>

	<div class="hero overlay position-relative">
		<div class="hero-background-animation"></div>
		<img src="images/blob.svg" alt="" class="img-fluid blob">
		<div class="container position-relative">
			<div class="row align-items-center justify-content-between pt-5">
				<div class="col-lg-6 text-center text-lg-start pe-lg-5">
					<span class="text-gradient d-block mb-3 aos-init" data-aos="fade-up">
						Nền Tảng Thi Trắc Nghiệm Trực Tuyến
					</span>
					<h1 class="heading text-white mb-3 display-4 fw-bold aos-init" data-aos="fade-up">
						MindBridge Institute
					</h1>
					<p class="lead text-white-50 mb-4 aos-init" data-aos="fade-up" data-aos-delay="100">
						Khám phá cách học và kiểm tra kiến thức hiện đại. Tạo, quản lý và tham gia các bài thi trắc nghiệm một cách dễ dàng.
					</p>
					<div class="hero-buttons aos-init" data-aos="fade-up" data-aos-delay="200">
						<?php if(!$is_logged_in): ?>
							<a href="DangNhap.php" class="btn btn-primary me-3 mb-3">
								Bắt đầu ngay
								<i class="bi bi-arrow-right ms-2"></i>
							</a>
						<?php else: ?>
							<a href="<?php echo $is_logged_in? 'contestZone.php' : 'DangNhap.php' ?>" class="btn btn-primary me-3 mb-3">
								Tham gia thi
								<i class="bi bi-arrow-right ms-2"></i>
							</a>
						<?php endif; ?>
					</div>
					
					<!-- Stats -->
					<div class="row mt-5 g-3 stats-container aos-init" data-aos="fade-up" data-aos-delay="300">
						<div class="col-4">
							<div class="stats-item">
								<h3 class="text-gradient mb-1">1000+</h3>
								<p class="text-white-50 mb-0">Học sinh</p>
							</div>
						</div>
						<div class="col-4">
							<div class="stats-item">
								<h3 class="text-gradient mb-1">500+</h3>
								<p class="text-white-50 mb-0">Đề thi</p>
							</div>
						</div>
						<div class="col-4">
							<div class="stats-item">
								<h3 class="text-gradient mb-1">50+</h3>
								<p class="text-white-50 mb-0">Giáo viên</p>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-5" data-aos="fade-up" data-aos-delay="300">
					<div class="img-wrap">
						<img src="images/img_7.jpg" alt="Image" class="img-fluid rounded shadow-lg">
						<!-- Floating elements -->
						<div class="floating-card card-1">
							<i class="bi bi-check-circle-fill text-success"></i>
							<span>Dễ dàng sử dụng</span>
						</div>
						<div class="floating-card card-2">
							<i class="bi bi-shield-check text-primary"></i>
							<span>An toàn & Bảo mật</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<style>
		.hero {
			min-height: 100vh;
			background: linear-gradient(140deg, var(--bs-dark) 0%, #3038e8 100%);
			overflow: hidden;
		}

		.hero-background-animation {
			position: absolute;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			background: url('images/grid.png');
			opacity: 0.1;
			animation: backgroundMove 20s linear infinite;
		}

		@keyframes backgroundMove {
			0% { background-position: 0 0; }
			100% { background-position: 100% 100%; }
		}

		.text-gradient {
			background: linear-gradient(to right, #4facfe 0%, #00f2fe 100%);
			-webkit-background-clip: text;
			-webkit-text-fill-color: transparent;
			font-weight: 600;
			font-size: 1.2rem;
		}

		.hero-buttons .btn {
			padding: 12px 30px;
			border-radius: 50px;
			font-weight: 500;
			transition: all 0.3s ease;
		}

		.hero-buttons .btn:hover {
			transform: translateY(-2px);
			box-shadow: 0 5px 15px rgba(0,0,0,0.3);
		}

		.stats-container {
			padding: 20px;
			border-radius: 15px;
			background: rgba(255,255,255,0.1);
			backdrop-filter: blur(10px);
		}

		.stats-item {
			text-align: center;
			padding: 10px;
		}

		.stats-item h3 {
			font-size: 2rem;
			font-weight: 700;
		}

		.img-wrap {
			position: relative;
			z-index: 1;
		}

		.floating-card {
			position: absolute;
			background: white;
			padding: 15px 25px;
			border-radius: 10px;
			box-shadow: 0 10px 30px rgba(0,0,0,0.1);
			display: flex;
			align-items: center;
			gap: 10px;
			animation: float 3s ease-in-out infinite;
		}

		.floating-card i {
			font-size: 1.5rem;
		}

		.card-1 {
			top: -20px;
			left: -20px;
			animation-delay: 0s;
		}

		.card-2 {
			bottom: -20px;
			right: -20px;
			animation-delay: 1.5s;
		}

		@keyframes float {
			0%, 100% { transform: translateY(0); }
			50% { transform: translateY(-20px); }
		}

		@media (max-width: 991.98px) {
			.hero {
				padding: 100px 0;
				min-height: auto;
			}
			
			.stats-container {
				margin-bottom: 40px;
			}
			
			.floating-card {
				display: none;
			}
		}
	</style>

	<div class="section features-section position-relative overflow-hidden">
		<div class="container">
			<div class="row justify-content-between align-items-center">
				<div class="col-lg-6 mb-4 mb-lg-0">
					<div class="features-image position-relative">
						<img src="images/img_8.jpg" alt="Features" class="img-fluid rounded-4 shadow-lg">
						<!-- Decorative elements -->
						<div class="feature-shape-1"></div>
						<div class="feature-shape-2"></div>
						<!-- Experience badge -->
						<div class="experience-badge">
							<span class="number">5+</span>
							<span class="text">Năm<br>Kinh nghiệm</span>
						</div>
					</div>
				</div>
				<div class="col-lg-5">
					<div class="features-content">
						<div class="section-tag mb-3" data-aos="fade-up">TÍNH NĂNG NỔI BẬT</div>
						<h2 class="section-title mb-4" data-aos="fade-up" data-aos-delay="100">
							Nền Tảng Giáo Dục <span class="text-primary">Thông Minh</span>
						</h2>
						<p class="section-description mb-4" data-aos="fade-up" data-aos-delay="200">
							Chúng tôi cung cấp giải pháp toàn diện cho việc tạo lập, quản lý và tham gia các bài kiểm tra trực tuyến.
						</p>

						<!-- Feature cards -->
						<div class="feature-cards">
							<!-- Card 1 -->
							<div class="feature-card" data-aos="fade-up" data-aos-delay="300">
								<div class="icon-box bg-primary-soft">
									<i class="bi bi-pencil-square text-primary"></i>
								</div>
								<div class="feature-content">
									<h4>Tạo đề thi dễ dàng</h4>
									<p>Giao diện trực quan, dễ sử dụng, tạo đề thi chỉ trong vài phút</p>
								</div>
							</div>

							<!-- Card 2 -->
							<div class="feature-card" data-aos="fade-up" data-aos-delay="400">
								<div class="icon-box bg-success-soft">
									<i class="bi bi-shield-check text-success"></i>
								</div>
								<div class="feature-content">
									<h4>Bảo mật tuyệt đối</h4>
									<p>Hệ thống bảo mật cao, đảm bảo tính công bằng trong kiểm tra</p>
								</div>
							</div>

							<!-- Card 3 -->
							<div class="feature-card" data-aos="fade-up" data-aos-delay="500">
								<div class="icon-box bg-info-soft">
									<i class="bi bi-graph-up text-info"></i>
								</div>
								<div class="feature-content">
									<h4>Thống kê chi tiết</h4>
									<p>Phân tích kết quả chi tiết, giúp đánh giá năng lực chính xác</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<style>
		.features-section {
			padding: 100px 0;
			background: #f8f9fa;
		}

		.section-tag {
			display: inline-block;
			padding: 8px 16px;
			background: rgba(var(--bs-primary-rgb), 0.1);
			color: var(--bs-primary);
			border-radius: 50px;
			font-weight: 600;
			font-size: 0.9rem;
		}

		.section-title {
			font-size: 2.5rem;
			font-weight: 700;
			line-height: 1.2;
		}

		.section-description {
			color: #6c757d;
			font-size: 1.1rem;
			line-height: 1.6;
		}

		.features-image {
			position: relative;
			z-index: 1;
		}

		.feature-shape-1,
		.feature-shape-2 {
			position: absolute;
			width: 200px;
			height: 200px;
			border-radius: 28% 72% 50% 50% / 28% 28% 72% 72%;
			background: rgba(var(--bs-primary-rgb), 0.1);
			z-index: -1;
		}

		.feature-shape-1 {
			top: -40px;
			left: -40px;
			animation: morphing 15s linear infinite;
		}

		.feature-shape-2 {
			bottom: -40px;
			right: -40px;
			animation: morphing 20s linear infinite reverse;
		}

		@keyframes morphing {
			0% { border-radius: 28% 72% 50% 50% / 28% 28% 72% 72%; }
			25% { border-radius: 50% 50% 28% 72% / 72% 28% 72% 28%; }
			50% { border-radius: 72% 28% 72% 28% / 50% 50% 28% 72%; }
			75% { border-radius: 28% 72% 28% 72% / 72% 28% 50% 50%; }
			100% { border-radius: 28% 72% 50% 50% / 28% 28% 72% 72%; }
		}

		.experience-badge {
			position: absolute;
			bottom: 30px;
			right: 30px;
			background: white;
			padding: 20px;
			border-radius: 15px;
			box-shadow: 0 10px 30px rgba(0,0,0,0.1);
			text-align: center;
		}

		.experience-badge .number {
			display: block;
			font-size: 2rem;
			font-weight: 700;
			color: var(--bs-primary);
			line-height: 1;
		}

		.experience-badge .text {
			font-size: 0.9rem;
			color: #6c757d;
		}

		.feature-card {
			display: flex;
			align-items: flex-start;
			gap: 20px;
			padding: 20px;
			margin-bottom: 20px;
			border-radius: 15px;
			background: white;
			transition: all 0.3s ease;
		}

		.feature-card:hover {
			transform: translateY(-5px);
			box-shadow: 0 10px 30px rgba(0,0,0,0.1);
		}

		.icon-box {
			width: 50px;
			height: 50px;
			display: flex;
			align-items: center;
			justify-content: center;
			border-radius: 12px;
		}

		.icon-box i {
			font-size: 1.5rem;
		}

		.bg-primary-soft { background: rgba(var(--bs-primary-rgb), 0.1); }
		.bg-success-soft { background: rgba(var(--bs-success-rgb), 0.1); }
		.bg-info-soft { background: rgba(var(--bs-info-rgb), 0.1); }

		.feature-content h4 {
			font-size: 1.1rem;
			font-weight: 600;
			margin-bottom: 5px;
		}

		.feature-content p {
			font-size: 0.9rem;
			color: #6c757d;
			margin: 0;
		}

		@media (max-width: 991.98px) {
			.features-section {
				padding: 60px 0;
			}

			.section-title {
				font-size: 2rem;
			}

			.feature-shape-1,
			.feature-shape-2 {
				width: 150px;
				height: 150px;
			}

			.experience-badge {
				padding: 15px;
			}
		}
	</style>

	<!-- <div class="section">
		<div class="container">
			<div class="row justify-content-between">
				<div class="col-lg-7 mb-4 mb-lg-0">
					<img src="images/img_8.jpg" alt="Image" class="img-fluid rounded">
				</div>
				<div class="col-lg-4 ps-lg-2">
					<div class="mb-5">
						<h2 class="text-black h4">BẮT ĐẦU NGAY</h2>
						<p>Nền tảng của chúng tôi giúp đơn giản hóa quá trình tạo đề thi, cho phép bạn thiết kế các bài kiểm tra trắc nghiệm tùy chỉnh một cách dễ dàng và hiệu quả.</p>
					</div> -->

					<!-- Tạo Đ Thi / Cuộc Thi -->
					<!-- <div class="d-flex mb-3 service-alt">
						<div>
							<span class="bi-pencil-square me-4"></span>
						</div>
						<div>
							<h3>TẠO ĐỀ THI / CUỘC THI</h3>
							<p>Tạo ra các đề thi hoặc cuộc thi mới với các tính năng linh hoạt và dễ dàng tùy chỉnh.</p>
						</div>
					</div> -->

					<!-- Quản Lý Đề Thi -->
					<!-- <div class="d-flex mb-3 service-alt">
						<div>
							<span class="bi-file-earmark-text-fill me-4"></span>
						</div>
						<div>
							<h3>QUẢN LÝ ĐỀ THI</h3>
							<p>Quản lý các đề thi đã tạo, chỉnh sửa và cập nhật nội dung một cách thuận tiện.</p>
						</div>
					</div> -->

					<!-- Quản Lý Thư Viện Đề Thi -->
					<!-- <div class="d-flex mb-3 service-alt">
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
	</div> -->


	<div class="section sec-features position-relative">
		<div class="section-pattern"></div>
		<div class="container">
			<div class="row mb-5">
				<div class="col-lg-6 mx-auto text-center">
					<div class="section-tag mb-3" data-aos="fade-up">ĐỐI TƯỢNG SỬ DỤNG</div>
					<h2 class="section-title text-white mb-4" data-aos="fade-up" data-aos-delay="100">
						Giải Pháp Cho Mọi <span class="text-warning">Đối Tượng</span>
					</h2>
					<p class="text-white-50" data-aos="fade-up" data-aos-delay="200">
						Nền tảng của chúng tôi được thiết kế phù hợp cho nhiều đối tượng khác nhau, từ học sinh đến giáo viên
					</p>
				</div>
			</div>

			<div class="row g-4 justify-content-center">
				<!-- Card Học sinh -->
				<div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="0">
					<div class="user-card student-card">
						<div class="card-icon">
							<i class="bi bi-mortarboard-fill"></i>
						</div>
						<h3>HỌC SINH</h3>
						<ul class="feature-list">
							<li>
								<i class="bi bi-check-circle-fill"></i>
								Giao diện dễ sử dụng
							</li>
							<li>
								<i class="bi bi-check-circle-fill"></i>
								Đánh giá năng lực thường xuyên
							</li>
							<li>
								<i class="bi bi-check-circle-fill"></i>
								Theo dõi tiến độ học tập
							</li>
							<li>
								<i class="bi bi-check-circle-fill"></i>
								Truy cập mọi lúc mọi nơi
							</li>
						</ul>
						<?php if(!$is_logged_in): ?>
							<a href="DangNhap.php" class="btn btn-primary mt-4">Bắt đầu ngay</a>
						<?php endif; ?>
					</div>
				</div>

				<!-- Card Giáo viên -->
				<div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
					<div class="user-card teacher-card">
						<div class="card-icon">
							<i class="bi bi-person-workspace"></i>
						</div>
						<h3>GIÁO VIÊN</h3>
						<ul class="feature-list">
							<li>
								<i class="bi bi-check-circle-fill"></i>
								Tạo đề thi dễ dàng
							</li>
							<li>
								<i class="bi bi-check-circle-fill"></i>
								Quản lý ngân hàng câu hỏi
							</li>
							<li>
								<i class="bi bi-check-circle-fill"></i>
								Thống kê kết quả chi tiết
							</li>
							<li>
								<i class="bi bi-check-circle-fill"></i>
								Đánh giá học sinh hiệu quả
							</li>
						</ul>
						<?php if(!$is_logged_in): ?>
							<a href="DangNhap.php" class="btn btn-success mt-4">Tham gia ngay</a>
						<?php endif; ?>
					</div>
				</div>

				<!-- Card Admin -->
				<div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
					<div class="user-card admin-card">
						<div class="card-icon">
							<i class="bi bi-shield-check"></i>
						</div>
						<h3>QUẢN TRỊ VIÊN</h3>
						<ul class="feature-list">
							<li>
								<i class="bi bi-check-circle-fill"></i>
								Quản lý người dùng
							</li>
							<li>
								<i class="bi bi-check-circle-fill"></i>
								Phân quyền hệ thống
							</li>
							<li>
								<i class="bi bi-check-circle-fill"></i>
								Hỗ trợ tận tình
							</li>
							<li>
								<i class="bi bi-check-circle-fill"></i>
								Tiếp nhận phản hồi
							</li>
						</ul>
						<?php if(!$is_logged_in): ?>
							<a href="DangNhap.php" class="btn btn-info mt-4">Liên hệ ngay</a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<style>
		.sec-features {
			background: linear-gradient(140deg, var(--bs-dark) 0%, #3038e8 100%);
			padding: 100px 0;
			overflow: hidden;
		}

		.section-pattern {
			position: absolute;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			background-image: radial-gradient(rgba(255, 255, 255, 0.1) 2px, transparent 2px);
			background-size: 30px 30px;
			opacity: 0.5;
		}

		.user-card {
			background: rgba(255, 255, 255, 0.05);
			backdrop-filter: blur(10px);
			border-radius: 20px;
			padding: 30px;
			text-align: center;
			transition: all 0.3s ease;
			height: 100%;
			border: 1px solid rgba(255, 255, 255, 0.1);
		}

		.user-card:hover {
			transform: translateY(-10px);
			box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
		}

		.card-icon {
			width: 80px;
			height: 80px;
			margin: 0 auto 20px;
			display: flex;
			align-items: center;
			justify-content: center;
			border-radius: 50%;
			font-size: 2rem;
		}

		.student-card .card-icon {
			background: rgba(var(--bs-primary-rgb), 0.1);
			color: var(--bs-primary);
		}

		.teacher-card .card-icon {
			background: rgba(var(--bs-success-rgb), 0.1);
			color: var(--bs-success);
		}

		.admin-card .card-icon {
			background: rgba(var(--bs-info-rgb), 0.1);
			color: var(--bs-info);
		}

		.user-card h3 {
			color: white;
			font-size: 1.5rem;
			margin-bottom: 20px;
		}

		.feature-list {
			list-style: none;
			padding: 0;
			margin: 0;
			text-align: left;
		}

		.feature-list li {
			color: rgba(255, 255, 255, 0.8);
			margin-bottom: 15px;
			display: flex;
			align-items: center;
			gap: 10px;
		}

		.feature-list li i {
			color: var(--bs-success);
			font-size: 1.2rem;
		}

		.user-card .btn {
			border-radius: 50px;
			padding: 10px 30px;
			font-weight: 500;
			transition: all 0.3s ease;
		}

		.user-card .btn:hover {
			transform: translateY(-2px);
			box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
		}

		@media (max-width: 991.98px) {
			.sec-features {
				padding: 60px 0;
			}
			
			.user-card {
				margin-bottom: 30px;
			}
		}
	</style>

	<div class="section create-exam-section">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-7 order-lg-4 mb-4 mb-lg-0">
					<div class="position-relative">
						<img src="images/img_9.png" alt="Create Exam" class="img-fluid rounded-4 shadow">
						<div class="floating-badge">
							<div class="badge-icon">
								<i class="bi bi-check-circle-fill"></i>
							</div>
							<div class="badge-text">
								<span class="d-block fw-bold">Dễ dàng</span>
								<small>Tạo đề trong 5 phút</small>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-5 pe-lg-5">
					<div class="create-exam-content">
						<div class="section-tag mb-3" data-aos="fade-up">HƯỚNG DẪN</div>
						<h2 class="section-title mb-4" data-aos="fade-up" data-aos-delay="100">
							Quy Trình Tạo Đề Thi <span class="text-primary">Đơn Giản</span>
						</h2>

						<!-- Steps -->
						<div class="steps-container">
							<!-- Step 1 -->
							<div class="step-item" data-aos="fade-up" data-aos-delay="200">
								<div class="step-icon bg-primary-soft">
									<i class="bi bi-pencil-square text-primary"></i>
								</div>
								<div class="step-content">
									<h4>Soạn câu hỏi</h4>
									<p>Nhập nội dung câu hỏi và các phương án trả lời một cách dễ dàng</p>
								</div>
							</div>

							<!-- Step 2 -->
							<div class="step-item" data-aos="fade-up" data-aos-delay="300">
								<div class="step-icon bg-success-soft">
									<i class="bi bi-check-circle text-success"></i>
								</div>
								<div class="step-content">
									<h4>Chọn đáp án</h4>
									<p>Đánh dấu đáp án đúng cho từng câu hỏi trong đề thi</p>
								</div>
							</div>

							<!-- Step 3 -->
							<div class="step-item" data-aos="fade-up" data-aos-delay="400">
								<div class="step-icon bg-warning-soft">
									<i class="bi bi-sliders text-warning"></i>
								</div>
								<div class="step-content">
									<h4>Cấu hình đề thi</h4>
									<p>Thiết lập thời gian, độ khó và các thông số khác cho đề thi</p>
								</div>
							</div>

							<!-- Step 4 -->
							<div class="step-item" data-aos="fade-up" data-aos-delay="500">
								<div class="step-icon bg-info-soft">
									<i class="bi bi-send-check text-info"></i>
								</div>
								<div class="step-content">
									<h4>Xuất bản</h4>
									<p>Hoàn tất và chia sẻ đề thi đến học sinh</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<style>
		.create-exam-section {
			padding: 100px 0;
			background: #f8f9fa;
		}

		.floating-badge {
			position: absolute;
			bottom: 30px;
			right: -20px;
			background: white;
			padding: 15px 20px;
			border-radius: 15px;
			box-shadow: 0 10px 30px rgba(0,0,0,0.1);
			display: flex;
			align-items: center;
			gap: 15px;
		}

		.badge-icon {
			width: 40px;
			height: 40px;
			background: rgba(var(--bs-success-rgb), 0.1);
			border-radius: 10px;
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 1.2rem;
			color: var(--bs-success);
		}

		.badge-text small {
			color: #6c757d;
		}

		.steps-container {
			position: relative;
			padding-left: 50px;
		}

		.steps-container::before {
			content: '';
			position: absolute;
			left: 20px;
			top: 0;
			bottom: 0;
			width: 2px;
			background: rgba(var(--bs-primary-rgb), 0.1);
		}

		.step-item {
			position: relative;
			padding-bottom: 30px;
		}

		.step-icon {
			position: absolute;
			left: -50px;
			width: 40px;
			height: 40px;
			border-radius: 50%;
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 1.2rem;
			background: white;
			z-index: 1;
		}

		.step-content {
			background: white;
			padding: 20px;
			border-radius: 15px;
			margin-left: 20px;
			transition: all 0.3s ease;
		}

		.step-content:hover {
			transform: translateX(10px);
			box-shadow: 0 10px 30px rgba(0,0,0,0.1);
		}

		.step-content h4 {
			font-size: 1.1rem;
			font-weight: 600;
			margin-bottom: 5px;
		}

		.step-content p {
			color: #6c757d;
			margin: 0;
			font-size: 0.9rem;
		}

		.bg-warning-soft { background: rgba(var(--bs-warning-rgb), 0.1); }

		@media (max-width: 991.98px) {
			.create-exam-section {
				padding: 60px 0;
			}
			
			.floating-badge {
				right: 20px;
			}
		}
	</style>

	<div class="section sec-services">
		<div class="container">
			<div class="row mb-5">
				<div class="col-lg-6 mx-auto text-center">
					<div class="section-tag mb-3" data-aos="fade-up">DỊCH VỤ</div>
					<h2 class="section-title mb-4" data-aos="fade-up" data-aos-delay="100">
						Các Tính Năng <span class="text-primary">Chính</span>
					</h2>
					<p class="section-description" data-aos="fade-up" data-aos-delay="200">
						Hệ thống cung cấp đầy đủ các công cụ cần thiết để tạo và quản lý đề thi trắc nghiệm một cách hiệu quả
					</p>
				</div>
			</div>

			<div class="row g-4 justify-content-center">
				<!-- Tạo Đề Thi Card -->
				<div class="col-md-6 col-lg-4" data-aos="fade-up">
					<div class="service-card">
						<div class="card-icon bg-primary-soft">
							<i class="bi bi-pencil-square text-primary"></i>
						</div>
						<h3>Tạo Đề Thi</h3>
						<p>Tạo đề thi với các tính năng linh hoạt, dễ dàng tùy chỉnh theo nhu cầu.</p>
					</div>
				</div>

				<!-- Tạo Cuộc Thi Card -->
				<div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
					<div class="service-card">
						<div class="card-icon bg-warning-soft">
							<i class="bi bi-trophy-fill text-warning"></i>
						</div>
						<h3>Tạo Cuộc Thi</h3>
						<p>Tổ chức các cuộc thi trực tuyến với nhiều hình thức và quy mô khác nhau.</p>
					</div>
				</div>

				<!-- Ngân Hàng Câu Hỏi Card -->
				<div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
					<div class="service-card">
						<div class="card-icon bg-success-soft">
							<i class="bi bi-bookmark-fill text-success"></i>
						</div>
						<h3>Ngân Hàng Câu Hỏi</h3>
						<p>Quản lý và tổ chức câu hỏi theo chủ đề, môn học. Dễ dàng tìm kiếm và tái sử dụng.</p>
					</div>
				</div>

				<!-- Quản Lý Người Dùng Card -->
				<div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
					<div class="service-card">
						<div class="card-icon bg-info-soft">
							<i class="bi bi-people-fill text-info"></i>
						</div>
						<h3>Quản Lý Người Dùng</h3>
						<p>Quản lý thông tin và phân quyền người dùng trong hệ thống một cách hiệu quả.</p>
					</div>
				</div>

				<!-- Tham Gia Thi Card -->
				<div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="400">
					<div class="service-card">
						<div class="card-icon bg-danger-soft">
							<i class="bi bi-person-check-fill text-danger"></i>
						</div>
						<h3>Tham Gia Thi</h3>
						<p>Tham gia các cuộc thi trắc nghiệm online với giao diện thân thiện, dễ sử dụng.</p>
					</div>
				</div>
			</div>
		</div>
	</div>

	<style>
		.sec-services {
			padding: 100px 0;
			background: white;
		}

		.service-card {
			background: white;
			padding: 30px;
			border-radius: 20px;
			box-shadow: 0 10px 30px rgba(0,0,0,0.05);
			transition: all 0.3s ease;
			height: 100%;
		}

		.service-card:hover {
			transform: translateY(-10px);
			box-shadow: 0 20px 40px rgba(0,0,0,0.1);
		}

		.card-icon {
			width: 60px;
			height: 60px;
			border-radius: 15px;
			display: flex;
			align-items: center;
			justify-content: center;
			margin-bottom: 20px;
		}

		.card-icon i {
			font-size: 1.5rem;
		}

		.service-card h3 {
			font-size: 1.3rem;
			font-weight: 600;
			margin-bottom: 15px;
		}

		.service-card p {
			color: #6c757d;
			margin-bottom: 20px;
			font-size: 0.95rem;
			line-height: 1.6;
		}

		.service-link {
			color: var(--bs-primary);
			text-decoration: none;
			display: inline-flex;
			align-items: center;
			gap: 8px;
			font-weight: 500;
			transition: all 0.3s ease;
		}

		.service-link:hover {
			gap: 12px;
			color: var(--bs-primary);
		}

		.bg-danger-soft { background: rgba(var(--bs-danger-rgb), 0.1); }
		.bg-warning-soft { background: rgba(var(--bs-warning-rgb), 0.1); }

		@media (max-width: 991.98px) {
			.sec-services {
				padding: 60px 0;
			}
			
			.service-card {
				padding: 20px;
			}
		}
	</style>
</div>

	<?php
		include 'footer.php';
		include 'javascript.php';
	?>

   

  </body>
  </html>
