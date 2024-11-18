<?php
	include 'head.php';
?>
<style>
	body {
		background: linear-gradient(to right, rgba(0, 0, 0, 0.85), rgba(0, 0, 139, 0.85));
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
	.error {
		color: red;
		text-align: center;
		margin: 10px 0;
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
	<div class="logo text-center mb-4">
		<div style="display: flex; align-items: center;">
			<img src="images/logo.png" alt="Logo" style="width: 100px; height: auto;">
			<div style="text-align: left;">
				<a href="index.php" class="text-decoration-none">
					<h1 class="m-0" style="font-size: 1.8rem; color: #ffffff; font-weight: bold;">MindBridge</h1>
					<h1 class="m-0" style="font-size: 1.8rem; color: #ffffff; font-weight: bold;">Institute</h1>
				</a>
			</div>
		</div>
	</div>

		<div class="container">
			<div class="form-container">
				<form method="post" action="DangKy.php" enctype="multipart/form-data">
					<h2>ĐĂNG KÝ</h2>
	
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
								<option value="1">Học sinh</option>
								<option value="2">Giáo viên</option>
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
						<?php if (!empty($message)) echo $message; ?>
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
