<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- <link rel="shortcut icon" href="favicon.png"> -->
		<meta name="description" content="" />
		<meta name="keywords" content="bootstrap, bootstrap5" />
	
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;600;700&display=swap" rel="stylesheet">
	
		<link rel="stylesheet" href="fonts/icomoon/style.css">
		<link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
	
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
	
		<link rel="stylesheet" href="css/tiny-slider.css">
		<link rel="stylesheet" href="css/aos.css">
		<link rel="stylesheet" href="css/glightbox.min.css">
		<link rel="stylesheet" href="css/style.css">
	
		<link rel="stylesheet" href="css/flatpickr.min.css">
		
		<style>
			body {
				background: linear-gradient(to right, #6a11cb, #2575fc);
				font-family: 'Work Sans', sans-serif;
				display: flex;
				justify-content: center;
				align-items: center;
				height: 150vh;
				margin: 0;
			}
			.logo {
				position: absolute;
				top: 10px;
				left: 10px;
				font-weight: bolder;
				font-size: 30px;
				color: #ffffff;
				font-family: 'Work Sans', sans-serif;
			}
			.container {
				width: 100%;
				max-width: 700px; 
				padding: 40px; 
			}

			.form-container {
				background: #ffffff;
				border-radius: 12px;
				padding: 30px;
				box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
				border: 1px solid #ddd;
			}

			h2 {
				text-align: center;
				font-weight: 700;
				color: #333;
				margin-bottom: 20px;
			}

			.form-group {
				margin-bottom: 15px; 
			}

			.form-control {
				border-radius: 8px;	
				border: 1px solid #ccc;
				padding: 15px;
				font-size: 18px;
				width: 100%; 
				transition: all 0.3s ease;
			}

			.form-control:focus {
				border-color: #2575fc;
				box-shadow: 0 0 5px rgba(37, 117, 252, 0.5);
			}

			.position-relative {
				position: relative;
			}

			#togglePassword, #togglePassword1 {
				position: absolute;
				right: 10px;
				top: 65%;
				transform: translateY(-50%);
				cursor: pointer;
			}


			.btn-primary {
				width: 100%;
				background-color: #2575fc;
				border: none;
				padding: 12px;
				border-radius: 8px;
				color: white;
				font-size: 16px;
				font-weight: bold;
				cursor: pointer;
				transition: background-color 0.3s, transform 0.3s;
			}

			.btn-primary:hover {
				background-color: #6a11cb;
				transform: translateY(-2px);
			}

			.text-center {
				text-align: center;
			}

			.text-primary {
				color: #2575fc;
			}

			.text-primary:hover {
				text-decoration: underline;
			}
		</style>
	</head>
	<body>
		
		<div class="logo">
			<span>ContestOnline</span>
		</div>

		<div class="container">
			<div class="form-container">
				<form method="post" action="">
					<h2>Đăng Ký</h2>
	
						<div class="form-group">
							<label for="username">Tên đăng nhập</label>
							<input type="text" class="form-control" name="username" id="username" placeholder="Tên đăng nhập" required>
						</div>
	
						<div class="form-group">
							<label for="fullname">Họ và tên</label>
							<input type="text" class="form-control" name="fullname" id="fullname" placeholder="Họ và tên" required>
						</div>
	
						<div class="form-group">
							<label for="email">Email</label>
							<input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
						</div>
	
						<div class="form-group position-relative">
							<label for="password">Mật khẩu</label>
							<input type="password" class="form-control" name="password" id="password" placeholder="Mật khẩu" required>
							<i id="togglePassword" class="bi bi-eye"></i>
						</div>
	
						<div class="form-group position-relative">
							<label for="password1">Nhập lại mật khẩu</label>
							<input type="password" class="form-control" name="password1" id="password1" placeholder="Nhập lại mật khẩu" required>
							<i id="togglePassword1" class="bi bi-eye"></i>
						</div>
	
						<div class="form-group">
							<label for="job">Nghề nghiệp</label>
							<select class="form-control" name="job" id="job" required>
								<option value="student">Học sinh</option>
								<option value="teacher">Giáo viên</option>
							</select>
						</div>
	
						<div class="form-group">
							<label for="image">Tải ảnh minh chứng</label>
							<input type="file" class="form-control" name="image" id="image" required>
						</div>
	
						<div class="form-group">
							<label for="phone">Số điện thoại</label>
							<input type="tel" class="form-control" name="phone" id="phone" placeholder="Số điện thoại">
						</div>
	
						<div class="form-group">
							<label for="dob">Ngày sinh</label>
							<input type="date" class="form-control" name="dob" id="dob">
						</div>
	
						<button type="submit" class="btn btn-primary btn-block" name="dangky">Đăng ký</button>
	
						<p class="text-center mt-3">
							Bạn đã có tài khoản rồi? <a href="DangNhap.php" class="text-primary">Đăng nhập</a></br>
							<a href="index.php" class="text-primary">Trang Chủ</a>
						</p>
					</form>
				</div>
			</div>
		</div>

		<script>
			// Chuyển đổi hiển thị mật khẩu
			const togglePassword = document.getElementById('togglePassword');
			const togglePassword1 = document.getElementById('togglePassword1');
			const passwordField = document.getElementById('password');
			const passwordField1 = document.getElementById('password1');

			togglePassword.addEventListener('click', function () {
				const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
				passwordField.setAttribute('type', type);
				togglePassword.classList.toggle('bi-eye');
				togglePassword.classList.toggle('bi-eye-slash');
			});

			togglePassword1.addEventListener('click', function () {
				const type = passwordField1.getAttribute('type') === 'password' ? 'text' : 'password';
				passwordField1.setAttribute('type', type);
				togglePassword1.classList.toggle('bi-eye');
				togglePassword1.classList.toggle('bi-eye-slash');
			});
		</script>
	</body>
</html>
