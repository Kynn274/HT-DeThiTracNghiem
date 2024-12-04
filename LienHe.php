<?php
	include 'head.php';
?>
<body>
	<?php
		include 'header.php';
	?>

	<style>
	/* Hero Section Styling */
	.hero.inner-page {
		position: relative;
		background: linear-gradient(135deg, #4154f1 0%, #2c3cdd 100%);
		min-height: 350px;
		display: flex;
		align-items: center;
		overflow: hidden;
	}

	/* Background Animation */
	.hero-background {
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		overflow: hidden;
	}

	.hero-background::before {
		content: '';
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
		0% { transform: translateX(0) translateY(0); }
		100% { transform: translateX(-50%) translateY(-50%); }
	}

	/* Floating Shapes */
	.shape {
		position: absolute;
		opacity: 0.1;
	}

	.shape-1 {
		top: 10%;
		left: 10%;
		width: 100px;
		height: 100px;
		background: white;
		border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
		animation: float 6s ease-in-out infinite;
	}

	.shape-2 {
		top: 60%;
		right: 10%;
		width: 150px;
		height: 150px;
		background: white;
		border-radius: 63% 37% 54% 46% / 55% 48% 52% 45%;
		animation: float 8s ease-in-out infinite;
	}

	.shape-3 {
		bottom: 10%;
		left: 30%;
		width: 80px;
		height: 80px;
		background: white;
		border-radius: 41% 59% 41% 59% / 41% 59% 41% 59%;
		animation: float 7s ease-in-out infinite;
	}

	@keyframes float {
		0%, 100% { transform: translateY(0) rotate(0deg); }
		50% { transform: translateY(-20px) rotate(10deg); }
	}

	/* Text Gradient */
	.text-gradient {
		background: linear-gradient(to right, #4facfe 0%, #00f2fe 100%);
		-webkit-background-clip: text;
		-webkit-text-fill-color: transparent;
		font-weight: 600;
		font-size: 1.1rem;
	}

	/* Responsive */
	@media (max-width: 768px) {
		.hero.inner-page {
			min-height: 280px;
		}
		
		.heading {
			font-size: 2rem !important;
		}
		
		.text-gradient {
			font-size: 1rem;
		}
		
		.shape {
			display: none;
		}
	}
	</style>

	<!-- Hero Section -->
	<div class="hero inner-page">
		<div class="hero-background"></div>
		
		<!-- Floating Shapes -->
		<div class="shape shape-1"></div>
		<div class="shape shape-2"></div>
		<div class="shape shape-3"></div>
		
		<div class="container">
			<div class="hero-content">
				<span class="text-gradient d-block mb-2 text-center" data-aos="fade-up">Liên Hệ Với Chúng Tôi</span>
				<h1 class="heading text-white mb-4 text-center" data-aos="fade-up" data-aos-delay="100" 
					style="font-size: 3rem; font-weight: 700;">Hãy Kết Nối</h1>
				<p class="text-white-50 mb-0 text-center" data-aos="fade-up" data-aos-delay="200" 
				   style="font-size: 1.1rem;">
					Chúng tôi luôn sẵn sàng lắng nghe và hỗ trợ bạn 24/7
				</p>
			</div>
		</div>
	</div>

	<div class="section contact-section">
		<div class="container">
			<div class="row g-5">
				<!-- Contact Info -->
				<div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
					<div class="contact-info">
						<!-- Location Card -->
						<div class="info-card">
							<div class="card-icon bg-primary-soft">
								<i class="bi bi-geo-alt-fill text-primary"></i>
							</div>
							<div class="card-content">
								<h4>Địa Chỉ</h4>
								<p>280 An Dương Vương, Phường 4, Quận 5, TP.HCM</p>
							</div>
						</div>

						<!-- Email Card -->
						<div class="info-card">
							<div class="card-icon bg-success-soft">
								<i class="bi bi-envelope-fill text-success"></i>
							</div>
							<div class="card-content">
								<h4>Email</h4>
								<p>
									<a href="mailto:4801103042@student.hcmue.edu.vn">4801103042@student.hcmue.edu.vn</a>
								</p>
							</div>
						</div>

						<!-- Phone Card -->
						<div class="info-card">
							<div class="card-icon bg-warning-soft">
								<i class="bi bi-telephone-fill text-warning"></i>
							</div>
							<div class="card-content">
								<h4>Điện Thoại</h4>
								<p>
									<a href="tel:0967785209">0967785209</a>
								</p>
							</div>
						</div>
					</div>
				</div>

				<!-- Contact Form -->
				<div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">
					<div class="contact-form-wrapper">
						<h3 class="mb-4">Gửi tin nhắn cho chúng tôi</h3>
						<form class="contact-form">
							<div class="row g-4">
								<div class="col-md-6">
									<div class="form-floating">
										<input type="text" class="form-control" id="name" placeholder="Họ và tên">
										<label for="name">Họ và tên</label>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-floating">
										<input type="email" class="form-control" id="email" placeholder="Email">
										<label for="email">Email</label>
									</div>
								</div>
								<div class="col-12">
									<div class="form-floating">
										<input type="text" class="form-control" id="subject" placeholder="Tiêu đề">
										<label for="subject">Tiêu đề</label>
									</div>
								</div>
								<div class="col-12">
									<div class="form-floating">
										<textarea class="form-control" id="message" style="height: 150px" placeholder="Nội dung"></textarea>
										<label for="message">Nội dung</label>
									</div>
								</div>
								<div class="col-12">
									<button type="submit" class="btn btn-primary">
										Gửi tin nhắn
										<i class="bi bi-send-fill ms-2"></i>
									</button>
								</div>
							</div>
						</form>

						<!-- Social Links Section -->
						<div class="social-section mt-5 pt-4 border-top">
							<div class="row align-items-center">
								<div class="col-lg-5">
									<h4 class="social-title mb-3 mb-lg-0">Theo dõi chúng tôi trên:</h4>
								</div>
								<div class="col-lg-7">
									<div class="social-links d-flex gap-3 justify-content-lg-end">
										<a href="#" class="social-link" title="Facebook">
											<i class="bi bi-facebook"></i>
										</a>
										<a href="#" class="social-link" title="Twitter">
											<i class="bi bi-twitter"></i>
										</a>
										<a href="#" class="social-link" title="Instagram">
											<i class="bi bi-instagram"></i>
										</a>
										<a href="#" class="social-link" title="LinkedIn">
											<i class="bi bi-linkedin"></i>
										</a>
										<a href="#" class="social-link" title="YouTube">
											<i class="bi bi-youtube"></i>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<style>
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

	.text-gradient {
		background: linear-gradient(to right, #4facfe 0%, #00f2fe 100%);
		-webkit-background-clip: text;
		-webkit-text-fill-color: transparent;
		font-weight: 600;
		font-size: 1.2rem;
	}

	.contact-section {
		padding: 100px 0;
		background: #f8f9fa;
	}

	.info-card {
		background: white;
		padding: 30px;
		border-radius: 15px;
		margin-bottom: 30px;
		box-shadow: 0 10px 30px rgba(0,0,0,0.05);
		transition: all 0.3s ease;
	}

	.info-card:hover {
		transform: translateY(-5px);
		box-shadow: 0 15px 40px rgba(0,0,0,0.1);
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

	.card-content h4 {
		font-size: 1.2rem;
		font-weight: 600;
		margin-bottom: 10px;
	}

	.card-content p {
		color: #6c757d;
		margin: 0;
	}

	.card-content a {
		color: #6c757d;
		text-decoration: none;
		transition: all 0.3s ease;
	}

	.card-content a:hover {
		color: var(--bs-primary);
	}

	.social-section {
		background: linear-gradient(to right, rgba(var(--bs-primary-rgb), 0.05), rgba(var(--bs-primary-rgb), 0.01));
		margin: 0 -40px -40px;
		padding: 30px 40px;
		border-radius: 0 0 20px 20px;
	}

	.social-title {
		font-size: 1.1rem;
		font-weight: 600;
		color: #495057;
		margin: 0;
	}

	.social-links {
		flex-wrap: wrap;
	}

	.social-link {
		width: 45px;
		height: 45px;
		border-radius: 10px;
		background: white;
		display: flex;
		align-items: center;
		justify-content: center;
		color: #6c757d;
		font-size: 1.2rem;
		transition: all 0.3s ease;
		box-shadow: 0 5px 15px rgba(0,0,0,0.05);
	}

	.social-link:hover {
		transform: translateY(-3px);
		color: var(--bs-primary);
		box-shadow: 0 8px 25px rgba(0,0,0,0.1);
	}

	.social-link:hover .bi-facebook { color: #1877f2; }
	.social-link:hover .bi-twitter { color: #1da1f2; }
	.social-link:hover .bi-instagram { color: #e4405f; }
	.social-link:hover .bi-linkedin { color: #0077b5; }
	.social-link:hover .bi-youtube { color: #ff0000; }

	.contact-form-wrapper {
		background: white;
		padding: 40px;
		border-radius: 20px;
		box-shadow: 0 10px 30px rgba(0,0,0,0.05);
	}

	.form-control {
		border: 2px solid #e9ecef;
		padding: 0.8rem 1.2rem;
		height: auto;
		background: #f8f9fa;
	}

	.form-control:focus {
		border-color: var(--bs-primary);
		box-shadow: none;
	}

	.form-floating label {
		padding: 1rem 1.2rem;
	}

	.btn-primary {
		padding: 12px 30px;
		border-radius: 10px;
		font-weight: 500;
		transition: all 0.3s ease;
	}

	.btn-primary:hover {
		transform: translateY(-2px);
		box-shadow: 0 8px 25px rgba(var(--bs-primary-rgb), 0.25);
	}

	@media (max-width: 991.98px) {
		.contact-section {
			padding: 60px 0;
		}
		
		.contact-form-wrapper {
			padding: 20px;
		}

		.social-section {
			margin: 0 -20px -20px;
			padding: 20px;
		}
		
		.social-links {
			justify-content: center;
			margin-top: 15px;
		}
	}
	</style>

	<?php
		include 'footer.php';
		include 'javascript.php';
	?>
</body>
</html>
