<?php
	if (session_status() == PHP_SESSION_NONE) {
   		session_start();
	}
	require_once("method/database.php");
	$message = '';
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
    	$username_input = trim($_POST['username']);
    	$password_input = trim($_POST['password']);
    	$remember = false;
    	$stmt = $conn->prepare("SELECT u.UserID, u.Password, u.Type, u.Username, u.Status, d.Fullname FROM Users u, UserDetails d WHERE u.UserID = d.UserID AND u.Username = ?");
    	if ($stmt === false) {
        	die("Lỗi trong việc chuẩn bị câu truy vấn: " . htmlspecialchars($conn->error));
    	}

    	$stmt->bind_param("s", $username_input);
    	$stmt->execute();
    	$stmt->store_result();
    	if ($stmt->num_rows > 0) {
        	$stmt->bind_result($user_id, $hashed_password, $user_type, $user_name, $user_status, $user_fullname);
        	$stmt->fetch();

        	if (password_verify($password_input, $hashed_password)) {
				if($user_status == 0){
					$message = "<div class='error'>Tài khoản của bạn đã bị hạn chế!</div>";
				}else{
            		$_SESSION['user_id'] = $user_id;
            		$_SESSION['username'] = $user_name; 
            		$_SESSION['user_type'] = $user_type;
					$_SESSION['user_fullname'] = $user_fullname;
            		session_regenerate_id(true);
            		
					if ($remember) {
						setcookie('username', $username_input, time() + (86400 * 30), "/"); 
						setcookie('password', $password_input, time() + (86400 * 30), "/");
					} else {
						setcookie('username', '', time() - 3600, "/");
						setcookie('password', '', time() - 3600, "/");
					}
            		header("Location: index.php");
            		exit();
				}
        	} else {
            	$message = "<div class='error'>Mật khẩu không đúng!</div>";
        	}
    	} else {
        	$message = "<div class='error'>Tên tài khoản không tồn tại!</div>";
    	}
    	$stmt->close();
	}
	$conn->close();
	$saved_username = isset($_COOKIE['username']) ? $_COOKIE['username'] : '';
	$saved_password = isset($_COOKIE['password']) ? $_COOKIE['password'] : '';
?>
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
		min-height: 100vh;
		margin: 0;
		padding: 20px;
	}

	.logo {
		position: absolute;
		top: 10px;
		left: 10px;
		font-weight: bolder;
		font-size: 30px;
		color: #ffffff;
	}

	.container {
		width: 100%;
		max-width: 400px;
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
		margin-bottom: 20px;
	}

	.form-control {
		border-radius: 8px;
		border: 1px solid #ccc;
		padding: 12px;
		font-size: 16px;
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

	#togglePassword {
		position: absolute;
		right: 10px;
		top: 38px;
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

	@media (max-width: 575px) {
		.form-container {
			padding: 20px;
		}
		h2 {
			font-size: 24px;
		}
		.form-control {
			padding: 10px;
			font-size: 14px;
		}
		.btn-primary {
			padding: 10px;
			font-size: 14px;
		}
	}
</style>
<body>
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
			<form method="post" action="DangNhap.php">
				<h2>Đăng Nhập</h2>
				<div class="form-group">
					<label for="username">Tên đăng nhập</label>
					<input type="text" class="form-control" name="username" id="username" placeholder="Tên đăng nhập" value="<?php echo htmlspecialchars($saved_username); ?>" required>
				</div>

				<div class="form-group position-relative">
					<label for="password">Mật khẩu</label>
					<input type="password" class="form-control" name="password" id="password" placeholder="Mật khẩu" value="<?php echo htmlspecialchars($saved_password); ?>" required>
					<span id="togglePassword">
						<i class="bi bi-eye" id="eyeIcon"></i>
					</span>
				</div>

				<?php if (!empty($message)) echo $message; ?>
				<button type="submit" class="btn btn-primary" name="dangnhap">Đăng Nhập</button>

				<p class="text-center mt-3">
					Bạn chưa có tài khoản? <a href="DangKy.php" class="text-primary">Đăng ký</a><br>
					<a href="index.php" class="text-primary">Trang Chủ</a>
				</p>
			</form>
		</div>
	</div>

	<script src="./js/signin.js"></script>
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
