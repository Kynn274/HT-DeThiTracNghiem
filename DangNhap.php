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
<?php include 'head.php'; ?>
<style>
body {
    margin: 0;
    padding: 0;
    min-height: 100vh;
    background: linear-gradient(135deg, #4154f1, #2c3cdd);
    font-family: 'Work Sans', sans-serif;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
}

/* Background Animation */
.bg-animation {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    z-index: 1;
}

.bg-animation li {
    position: absolute;
    display: block;
    list-style: none;
    width: 20px;
    height: 20px;
    background: rgba(255, 255, 255, 0.1);
    animation: animate 25s linear infinite;
    bottom: -150px;
    border-radius: 50%;
}

@keyframes animate {
    0% {
        transform: translateY(0) rotate(0deg);
        opacity: 1;
        border-radius: 0;
    }
    100% {
        transform: translateY(-1000px) rotate(720deg);
        opacity: 0;
        border-radius: 50%;
    }
}

/* Logo Section */
.logo-section {
    position: fixed;
    top: 30px;
    left: 30px;
    z-index: 10;
}

.logo-container {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    transition: all 0.3s ease;
}

.logo-container:hover {
    transform: translateY(-5px);
    background: rgba(255, 255, 255, 0.15);
}

.logo-container img {
    width: 50px;
    height: auto;
    filter: brightness(0) invert(1);
}

.logo-text {
    text-decoration: none;
}

.logo-text h1 {
    color: #ffffff;
    font-size: 1.4rem;
    font-weight: 700;
    margin: 0;
    line-height: 1.2;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
}

/* Login Form Container */
.login-container {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
    width: 100%;
    max-width: 400px;
    position: relative;
    z-index: 2;
    animation: fadeIn 0.6s ease-out;
}

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

.login-container h2 {
    color: #2c3cdd;
    font-size: 2rem;
    font-weight: 700;
    text-align: center;
    margin-bottom: 30px;
    letter-spacing: 1px;
}

.form-group {
    margin-bottom: 25px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    color: #495057;
    font-weight: 500;
    font-size: 0.95rem;
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

#togglePassword {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #6c757d;
    transition: color 0.3s ease;
}

#togglePassword:hover {
    color: #4154f1;
}

.btn-login {
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
    margin-top: 10px;
}

.btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(65, 84, 241, 0.4);
}

.text-center {
    text-align: center;
    margin-top: 20px;
}

.text-center a {
    color: #4154f1;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}

.text-center a:hover {
    color: #2c3cdd;
    text-decoration: underline;
}

.error {
    background: #fff5f5;
    color: #e53e3e;
    padding: 12px 15px;
    border-radius: 8px;
    margin-bottom: 20px;
    font-size: 0.9rem;
    text-align: center;
    border-left: 4px solid #e53e3e;
    animation: shake 0.5s ease-in-out;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

/* Responsive Design */
@media (max-width: 768px) {
    .login-container {
        margin: 20px;
        padding: 30px 20px;
    }

    .logo-section {
        top: 20px;
        left: 20px;
    }

    .logo-container {
        padding: 10px;
    }

    .logo-container img {
        width: 40px;
    }

    .logo-text h1 {
        font-size: 1.2rem;
    }
}
</style>

<body>
    <!-- Background Animation -->
    <ul class="bg-animation">
        <?php for($i = 0; $i < 10; $i++): ?>
            <li style="
                left: <?php echo rand(0, 100); ?>%;
                width: <?php echo rand(10, 30); ?>px;
                height: <?php echo rand(10, 30); ?>px;
                animation-delay: <?php echo $i * 0.5; ?>s;
                animation-duration: <?php echo rand(10, 30); ?>s;
            "></li>
        <?php endfor; ?>
    </ul>

    <!-- Logo Section -->
    <div class="logo-section">
        <div class="logo-container">
            <img src="images/logo.png" alt="Logo">
            <a href="index.php" class="logo-text">
                <h1>MindBridge</h1>
                <h1>Institute</h1>
            </a>
        </div>
    </div>

    <!-- Login Form -->
    <div class="login-container">
        <form method="post" action="DangNhap.php">
            <h2>Đăng Nhập</h2>
            
            <div class="form-group">
                <label for="username">Tên đăng nhập</label>
                <input type="text" class="form-control" name="username" id="username" 
                       placeholder="Nhập tên đăng nhập" value="<?php echo htmlspecialchars($saved_username); ?>" required>
            </div>

            <div class="form-group position-relative">
                <label for="password">Mật khẩu</label>
                <input type="password" class="form-control" name="password" id="password" 
                       placeholder="Nhập mật khẩu" value="<?php echo htmlspecialchars($saved_password); ?>" required>
                <i class="bi bi-eye" id="togglePassword"></i>
            </div>

            <?php if (!empty($message)) echo $message; ?>
			
            <button type="submit" class="btn-login" name="dangnhap">Đăng Nhập</button>

            <div class="text-center">
                <p>Bạn chưa có tài khoản? <a href="DangKy.php">Đăng ký</a></p>
                <p><a href="index.php">Về trang chủ</a></p>
            </div>
        </form>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });
    </script>
</body>
</html>
