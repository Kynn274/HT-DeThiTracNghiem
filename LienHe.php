<?php
	include 'head.php';
?>
<body>
	<?php
		include 'header.php';
	?>

	<div class="hero overlay inner-page">
		<img src="images/blob.svg" alt="" class="img-fluid blob">
		<div class="container">
			<div class="row align-items-center justify-content-center text-center pt-5">
				<div class="col-lg-6">
					<h1 class="heading text-white mb-3" data-aos="fade-up">CONTACT US</h1>
				</div>
			</div>
		</div>
	</div>

	
	<div class="section">
		<div class="container">
			<div class="row">
				<div class="col-lg-4 mb-5 mb-lg-0" data-aos="fade-up" data-aos-delay="100">
					<div class="contact-info">

						<div class="address mt-2">
							<i class="icon-room"></i>
							<h4 class="mb-2">ĐỊA CHỈ:</h4>
							<p>280 An Dương Vương, Phường 4, Quận 5, <br> Thành phố Hồ Chí Minh</p>
						</div>

						<!-- <div class="open-hours mt-4">
							<i class="icon-clock-o"></i>
							<h4 class="mb-2">GIỜ HOẠT ĐỘNG:</h4>
							<p>
								Thứ Hai - Chủ Nhật:<br>
								24/7
							</p>
						</div> -->

						<div class="email mt-4">
							<i class="icon-envelope"></i>
							<h4 class="mb-2">EMAIL:</h4>
							<p>4801103042@student.edu.vn</p>
						</div>

						<div class="phone mt-4">
							<i class="icon-phone"></i>
							<h4 class="mb-2">SỐ ĐIỆN THOẠI:</h4>
							<p>0967785209</p>
						</div>

					</div>
				</div>
				<div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">
					<form action="#">
						<div class="row">
							<div class="col-6 mb-3">
								<input type="text" class="form-control" placeholder="Họ và Tên">
							</div>
							<div class="col-6 mb-3">
								<input type="email" class="form-control" placeholder="Email">
							</div>
							<!-- <div class="col-12 mb-3">
								<input type="text" class="form-control" placeholder="Subject">
							</div> -->
							<div class="col-12 mb-3">
								<textarea name="" id="" cols="30" rows="7" class="form-control" placeholder="Message"></textarea>
							</div>

							<div class="col-12">
								<input type="submit" value="Send Message" class="btn btn-primary">
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div> <!-- /.untree_co-section -->

    <?php
		include 'footer.php';
		include 'javascript.php';
	?>
  </body>
  </html>
