<?php
    include 'head.php';
?>
<body>
    <?php 
        include 'header.php'; 
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT * FROM UserDetails WHERE UserID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $userDetails = $result->fetch_assoc();

        
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

        /* Profile Section */
        .section {
            padding: 40px 0;
            background: linear-gradient(135deg, #f6f9ff 0%, #f1f4ff 100%);
        }

        .container.article {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 40px;
            margin: 20px auto;
        }

        /* Avatar Section */
        .avatar {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
            padding: 20px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .avatar img {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #fff;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .avatar img:hover {
            transform: scale(1.05);
        }

        .open-avatar-selector {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            border: none;
            color: white;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .open-avatar-selector:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(245, 158, 11, 0.3);
        }

        /* Form Section */
        form {
            padding: 20px;
        }

        form h4 {
            color: var(--primary-color) !important;
            font-size: 1.5rem !important;
            font-weight: 700 !important;
            margin-bottom: 2rem !important;
            position: relative;
            padding-bottom: 15px;
        }

        form h4:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 80px;
            height: 4px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 2px;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.8rem;
            color: var(--text-color);
            font-weight: 600;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-group label i {
            color: var(--primary-color);
            font-size: 1.1rem;
        }

        .form-control {
            border: 2px solid var(--border-color);
            border-radius: 12px;
            padding: 12px 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(65, 84, 241, 0.1);
        }

        /* Buttons */
        .buttons {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 2rem;
        }

        .buttons .btn {
            padding: 12px 25px;
            border-radius: 12px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .buttons .btn i {
            font-size: 1.2rem;
        }

        .buttons .btn:hover {
            transform: translateY(-2px);
        }

        .btn-success {
            background: linear-gradient(135deg, #34d399, #10b981);
            border: none;
        }

        .btn-danger {
            background: linear-gradient(135deg, #f87171, #ef4444);
            border: none;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .container.article {
                grid-template-columns: 1fr;
                padding: 20px;
            }

            .avatar {
                max-width: 300px;
                margin: 0 auto;
            }

            .buttons {
                flex-direction: column;
            }

            .buttons .btn {
                width: 100%;
                justify-content: center;
            }
        }
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
				<span class="text-gradient d-block mb-2 text-center" data-aos="fade-up">Thông Tin Cá Nhân</span>
				<h1 class="heading text-white mb-4 text-center" data-aos="fade-up" data-aos-delay="100" 
					style="font-size: 3rem; font-weight: 700;">Chỉnh Sửa Hồ Sơ</h1>
				<p class="text-white-50 mb-0 text-center" data-aos="fade-up" data-aos-delay="200" 
				   style="font-size: 1.1rem;">
					Cập nhật thông tin cá nhân của bạn
				</p>
			</div>
		</div>
	</div>

    <!-- Form Section -->
    <div class="section">
        <div class="container article">
            <div class="avatar">
                <img src="images/<?php echo $userDetails['Avatar'] ? $userDetails['Avatar'] : 'no-avatar.jpg'; ?>" alt="avatar">
                <button type="button" class="open-avatar-selector">
                    <i class="bi bi-camera"></i>
                    Thay đổi ảnh đại diện
                </button>
            </div>

            <form action="process.php" method="post" enctype="multipart/form-data">
                <h4>CHỈNH SỬA THÔNG TIN CÁ NHÂN</h4>
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                <input type="hidden" name="avatar" value="<?php echo $userDetails['Avatar']; ?>">
                <input type="file" name="avatarInput" id="avatarInput" accept="image/*" style="display: none;">
                
                <div class="form-group">
                    <label for="fullname">
                        <i class="bi bi-person"></i>
                        Họ và tên
                    </label>
                    <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo $userDetails['Fullname']; ?>">
                </div>

                <div class="form-group">
                    <label for="dob">
                        <i class="bi bi-calendar"></i>
                        Ngày sinh
                    </label>
                    <input type="date" class="form-control" id="dob" name="dob" value="<?php echo $userDetails['DateOfBirth']; ?>">
                </div>

                <div class="form-group">
                    <label for="email">
                        <i class="bi bi-envelope"></i>
                        Email
                    </label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $userDetails['Email']; ?>">
                </div>

                <div class="form-group">
                    <label for="phone">
                        <i class="bi bi-telephone"></i>
                        Số điện thoại
                    </label>
                    <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $userDetails['PhoneNumber']; ?>">
                </div>

                <div class="buttons">
                    <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                        <i class="bi bi-arrow-left"></i>
                        Quay lại
                    </button>
                    <button type="button" class="btn btn-danger" onclick="window.location.href='DoiMatKhau.php'">
                        <i class="bi bi-key"></i>
                        Đổi mật khẩu
                    </button>
                    <button name="action" value="updateUserDetails" class="btn btn-success">
                        <i class="bi bi-check-lg"></i>
                        Lưu thông tin
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script src="js/InformationEdition.js"></script>
    <?php 
        include 'footer.php';
        include 'javascript.php';
    ?>
</body>
</html>