<?php
	include 'head.php';
?>
<style>
	body {
		background: linear-gradient(135deg, #4154f1, #2c3cdd);
		font-family: 'Work Sans', sans-serif;
		min-height: 100vh;
		margin: 0;
		padding: 20px;
	}
	.logo-section {
		position: fixed;
		top: 20px;
		left: 20px;
		z-index: 1000;
	}
	.logo-container {
		display: flex;
		align-items: center;
		gap: 15px;
	}
	.logo-container img {
		width: 60px;
		height: auto;
		filter: brightness(0) invert(1);
		transition: all 0.3s ease;
	}
	.logo-text {
		text-decoration: none;
	}
	.logo-text h1 {
		font-size: 1.5rem;
		color: #ffffff;
		font-weight: bold;
		margin: 0;
		line-height: 1.2;
		text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
	}
	.container {
		max-width: 800px;
		margin: 80px auto 20px;
		padding: 0 20px;
	}
	.form-container {
		background: rgba(255, 255, 255, 0.95);
		backdrop-filter: blur(10px);
		border-radius: 20px;
		padding: 40px;
		box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
	}
	h2 {
		text-align: center;
		font-size: 2rem;
		font-weight: 700;
		color: #2c3cdd;
		margin-bottom: 30px;
		text-transform: uppercase;
		letter-spacing: 1px;
	}
	.form-group {
		margin-bottom: 20px;
	}
	.form-group label {
		display: block;
		margin-bottom: 8px;
		color: #495057;
		font-weight: 500;
		font-size: 0.9rem;
	}
	.form-control {
		width: 100%;
		padding: 12px 15px;
		border: 2px solid #e9ecef;
		border-radius: 10px;
		font-size: 1rem;
		transition: all 0.3s ease;
		background: white;
	}
	.form-control:focus {
		border-color: #4154f1;
		box-shadow: 0 0 0 3px rgba(65, 84, 241, 0.1);
		outline: none;
	}
	.position-relative {
		position: relative;
	}
	#togglePassword, #togglePassword1 {
		position: absolute;
		right: 15px;
		top: 50%;
		transform: translateY(-50%);
		cursor: pointer;
		color: #6c757d;
		transition: color 0.3s ease;
	}
	#togglePassword:hover, #togglePassword1:hover {
		color: #4154f1;
	}
	.btn-primary {
		width: 100%;
		padding: 12px;
		border: none;
		border-radius: 10px;
		background: linear-gradient(135deg, #4154f1, #2c3cdd);
		color: white;
		font-size: 1rem;
		font-weight: 600;
		text-transform: uppercase;
		letter-spacing: 1px;
		cursor: pointer;
		transition: all 0.3s ease;
	}
	.btn-primary:hover {
		transform: translateY(-2px);
		box-shadow: 0 5px 15px rgba(65, 84, 241, 0.4);
	}
	.text-center {
		text-align: center;
		margin-top: 20px;
	}
	.text-primary {
		color: #4154f1;
		text-decoration: none;
		font-weight: 500;
		transition: all 0.3s ease;
	}
	.text-primary:hover {
		color: #2c3cdd;
		text-decoration: underline;
	}
	.error {
		background: #fff5f5;
		color: #e53e3e;
		padding: 10px 15px;
		border-radius: 8px;
		margin-bottom: 20px;
		font-size: 0.9rem;
		text-align: center;
		border-left: 4px solid #e53e3e;
	}
	.success {
		background: #f0fff4;
		color: #38a169;
		padding: 10px 15px;
		border-radius: 8px;
		margin-bottom: 20px;
		font-size: 0.9rem;
		text-align: center;
		border-left: 4px solid #38a169;
	}
	/* Custom file input */
	.form-control[type="file"] {
		padding: 8px;
	}
	.form-control[type="file"]::-webkit-file-upload-button {
		background: linear-gradient(135deg, #4154f1, #2c3cdd);
		color: white;
		padding: 8px 15px;
		border: none;
		border-radius: 6px;
		cursor: pointer;
		transition: all 0.3s ease;
	}
	.form-control[type="file"]::-webkit-file-upload-button:hover {
		background: linear-gradient(135deg, #2c3cdd, #1a237e);
	}
	/* Responsive */
	@media (max-width: 768px) {
		.container {
			padding: 0 15px;
			margin-top: 100px;
		}
		.form-container {
			padding: 30px 20px;
		}
		h2 {
			font-size: 1.75rem;
		}
		.logo-container img {
			width: 50px;
		}
		.logo-text h1 {
			font-size: 1.2rem;
		}
	}
	/* Animation */
	@keyframes fadeIn {
		from {
			opacity: 0;
			transform: translateY(20px);
		}
		to {
			opacity: 1;
			transform: translateY(0);
		}
	}
	.form-container {
		animation: fadeIn 0.5s ease-out;
	}
</style>
<body>
	<?php
  		require_once("method/database.php");
  		$message = '';
 		if ($_SERVER["REQUEST_METHOD"] == "POST") {
      		$username = $_POST['username'];
      		$fullname = $_POST['fullname'];
      		$email = $_POST['email'];
      		$phone = $_POST['phone'];
      		$password = $_POST['password'];
      		$confirm_password = $_POST['password1'];
	  		$job = $_POST['job'];
			$dob = $_POST['dob'];
			$image = $_FILES['image']['name'];
            $image_tmp = $_FILES['image']['tmp_name'];
			$joiningDate = date("Y-m-d");

      		if ($password !== $confirm_password) {
          		$message = "<div class='error'>Mật khẩu không khớp!</div>";
      		} else {
          		$stmt = $conn->prepare("SELECT Username FROM Users WHERE Username = ?");
          		$stmt->bind_param("s", $username);
          		$stmt->execute();
          		$stmt->store_result();
          		if ($stmt->num_rows > 0) {
              		$message = "<div class='error'>Tên tài khoản đã tồn tại!</div>";
              		$stmt->close();
          		} else {
              		$stmt = $conn->prepare("SELECT Email FROM UserDetails WHERE Email = ?");
              		$stmt->bind_param("s", $email);
              		$stmt->execute();
             		$stmt->store_result();
              		if ($stmt->num_rows > 0) {
                  		$message = "<div class='error'>Email đã tồn tại!</div>";
                 		$stmt->close();
              		} else {
                  		$stmt = $conn->prepare("SELECT PhoneNumber FROM UserDetails WHERE PhoneNumber = ?");
                  		$stmt->bind_param("s", $phone);
                  		$stmt->execute();
                  		$stmt->store_result();
                  		if ($stmt->num_rows > 0) {
                      		$message = "<div class='error'>Số điện thoại đã tồn tại!</div>";

                      		$stmt->close();
                  		} else {
                      		$hashed_password = password_hash($password, PASSWORD_DEFAULT);
                      		$stmt = $conn->prepare("INSERT INTO Users (Username, Password, Type, JoiningDate) VALUES (?, ?, ?, ?)");
                      		$stmt->bind_param("ssis", $username, $hashed_password, $job, $joiningDate);

                      		if ($stmt->execute()) {
                          		$userId = $stmt->insert_id;
                          		$stmt_detail = $conn->prepare("INSERT INTO UserDetails (UserId, Fullname, PhoneNumber, Email, DateOfBirth, Evidence) VALUES (?, ?, ?, ?, ?, ?)");
                          		$stmt_detail->bind_param("isssss", $userId, $fullname, $phone, $email, $dob, $image);

								if (!move_uploaded_file($image_tmp, "images/$image")) {
									$message = "<div class='error'>Failed to upload image!</div>";
									$stmt->close();
								}else{
									if ($stmt_detail->execute()) {
										$message = "<div class='success'>Đăng ký thành công!</div>";
										header("Location: DangNhap.php");
									} else {
										$stmt = $conn->prepare("DELETE FROM Users WHERE UserID = ?");
										$stmt->bind_param('i', $userId);
										$stmt->execute();
										$message = "<div class='error'>Lỗi khi thêm thông tin chi tiết: " . $stmt_detail->error . "</div>";
									}
									$stmt_detail->close();
								} 
							}else {
								$message = "<div class='error'>Lỗi khi thêm người dùng: " . $stmt->error . "</div>";
							}                          
                      		$stmt->close();
                  		}
              		}
          		}
      		}
		}
  		$conn->close();
  	?>
	<div class="logo-section">
		<div class="logo-container">
			<img src="images/logo.png" alt="Logo">
			<a href="index.php" class="logo-text">
				<h1>MindBridge</h1>
				<h1>Institute</h1>
			</a>
		</div>
	</div>

	<div class="container">
		<div class="form-container">
			<form method="post" action="DangKy.php" enctype="multipart/form-data">
				<h2>Đăng Ký Tài Khoản</h2>

				<div class="form-group">
					<label for="username">Tên đăng nhập</label>
					<input type="text" class="form-control" name="username" id="username" placeholder="Nhập tên đăng nhập" required>
				</div>

				<div class="form-group">
					<label for="fullname">Họ và tên</label>
					<input type="text" class="form-control" name="fullname" id="fullname" placeholder="Nhập họ và tên" required>
				</div>

				<div class="form-group">
					<label for="email">Email</label>
					<input type="email" class="form-control" name="email" id="email" placeholder="Nhập địa chỉ email" required>
				</div>

				<div class="form-group position-relative">
					<label for="password">Mật khẩu</label>
					<input type="password" class="form-control" name="password" id="password" placeholder="Nhập mật khẩu" required>
					<i class="bi bi-eye" id="togglePassword"></i>
				</div>

				<div class="form-group position-relative">
					<label for="password1">Xác nhận mật khẩu</label>
					<input type="password" class="form-control" name="password1" id="password1" placeholder="Nhập lại mật khẩu" required>
					<i class="bi bi-eye" id="togglePassword1"></i>
				</div>

				<div class="form-group">
					<label for="job">Vai trò</label>
					<select class="form-control" name="job" id="job" required>
						<option value="1">Học sinh</option>
						<option value="2">Giáo viên</option>
					</select>
				</div>

				<div class="form-group">
					<label for="image">Ảnh minh chứng</label>
					<input type="file" class="form-control" name="image" id="image" required>
				</div>

				<div class="form-group">
					<label for="phone">Số điện thoại</label>
					<input type="tel" class="form-control" name="phone" id="phone" placeholder="Nhập số điện thoại">
				</div>

				<div class="form-group">
					<label for="dob">Ngày sinh</label>
					<input type="date" class="form-control" name="dob" id="dob">
				</div>

				<?php if (!empty($message)) echo $message; ?>

				<button type="submit" class="btn btn-primary" name="dangky">Đăng Ký</button>

				<div class="text-center">
					<p>Đã có tài khoản? <a href="DangNhap.php" class="text-primary">Đăng nhập</a></p>
					<p><a href="index.php" class="text-primary">Về trang chủ</a></p>
				</div>
			</form>
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
