<?php
    include 'head.php';
?>
<body>
    <?php 
        include 'header.php'; 
        $user_id = $_SESSION['user_id'];
        $message = '';
        if(isset($_POST['action'])){
            if($_POST['action'] == 'updateUserPassword'){
                $oldPassword = $_POST['old_password'];
                $newPassword = $_POST['new_password'];
                $confirmPassword = $_POST['confirm_password'];
                if(empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) {
                    $message = 'Vui lòng điền đầy đủ thông tin';
                    $conn->close();
                    return;
                }
                if(strlen($newPassword) < 6) {
                    $message = 'Mật khẩu mới phải có ít nhất 6 ký tự';
                    $conn->close();
                    return;
                }
                if($newPassword == $oldPassword){
                    $message = 'Mật khẩu mới không được trùng với mật khẩu cũ';
                    $conn->close();
                    // return;
                }
                if($newPassword == $confirmPassword){
                    $sql = "SELECT Password FROM Users WHERE UserID = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $user_id);
                    if($stmt->execute()){
                        $result = $stmt->get_result();
                        $userData = $result->fetch_assoc();
                        if(password_verify($oldPassword, $userData['Password'])){
                            $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);
                            $sql = "UPDATE Users SET Password = ? WHERE UserID = ?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("si", $hashed_password, $user_id);
                            if($stmt->execute()){
                                $_SESSION['success_message'] = 'Đổi mật khẩu thành công!';
                                header("Location: ChinhSuaThongTinCaNhan.php");
                                exit();
                            }
                        }else{
                            $message = 'Mật khẩu cũ không đúng';
                            $conn->close();
                            // return;
                        }
                    }
                }else{
                    $message = 'Mật khẩu xác nhận không khớp';
                    $conn->close();
                    // return;
                }
            }
        }
    ?>
    <style>
        /* Hero Section */
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

        /* Password Change Form */
        .password-container {
            margin-top: -100px;
            position: relative;
            z-index: 10;
            padding: 0 20px;
        }

        .password-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: none;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 500px;
            margin: 0 auto;
        }

        .password-header {
            background: linear-gradient(135deg, rgba(65, 84, 241, 0.05), rgba(44, 60, 221, 0.05));
            padding: 30px;
            text-align: center;
            border-bottom: 1px solid rgba(65, 84, 241, 0.1);
        }

        .password-title {
            color: #2c3cdd;
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0;
        }

        .password-body {
            padding: 40px;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #6c757d;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .form-control {
            width: 100%;
            padding: 12px 40px 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #4154f1;
            box-shadow: 0 0 0 4px rgba(65, 84, 241, 0.1);
            outline: none;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 40px;
            color: #6c757d;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .toggle-password:hover {
            color: #4154f1;
        }

        .action-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 25px;
            border-radius: 12px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-back {
            background: #f8f9fa;
            color: #6c757d;
            border: none;
        }

        .btn-save {
            background: linear-gradient(135deg, #4154f1, #2c3cdd);
            color: white;
            border: none;
        }

        .btn-save:hover {
            box-shadow: 0 8px 25px rgba(65, 84, 241, 0.3);
        }

        .error-message {
            color: #dc3545;
            font-size: 0.9rem;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            .password-container {
                margin-top: -50px;
            }

            .password-body {
                padding: 30px 20px;
            }
        }
    </style>

    <div class="hero inner-page">
        <div class="hero-background"></div>
        <div class="container">
            <div class="hero-content">
                <span class="text-gradient d-block mb-2 text-center" data-aos="fade-up">Đổi Mật Khẩu</span>
                <h1 class="heading text-white mb-4 text-center" data-aos="fade-up" data-aos-delay="100" 
                    style="font-size: 3rem; font-weight: 700;">Cập Nhật Mật Khẩu</h1>
                <p class="text-white-50 mb-0 text-center" data-aos="fade-up" data-aos-delay="200" 
                   style="font-size: 1.1rem;">
                    Vui lòng nhập mật khẩu mới của bạn
                </p>
            </div>
        </div>
    </div>

    <div class="password-container">
        <div class="password-card">
            <div class="password-header">
                <h2 class="password-title">Đổi Mật Khẩu</h2>
            </div>
            <div class="password-body">
                <form action="DoiMatKhau.php" method="post">
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                    
                    <div class="form-group">
                        <label for="old_password">Mật khẩu cũ</label>
                        <input type="password" class="form-control" id="old_password" name="old_password">
                        <span class="toggle-password" id="togglePassword-old">
                            <i class="bi bi-eye" id="eyeIcon-old"></i>
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="new_password">Mật khẩu mới</label>
                        <input type="password" class="form-control" id="new_password" name="new_password">
                        <span class="toggle-password" id="togglePassword-new">
                            <i class="bi bi-eye" id="eyeIcon-new"></i>
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Xác nhận mật khẩu mới</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                        <span class="toggle-password" id="togglePassword-confirm">
                            <i class="bi bi-eye" id="eyeIcon-confirm"></i>
                        </span>
                    </div>

                    <?php if(!empty($message)): ?>
                        <div class="error-message"><?php echo $message; ?></div>
                    <?php endif; ?>

                    <div class="action-buttons">
                        <button type="button" onclick="window.history.back()" class="btn btn-back">
                            <i class="bi bi-arrow-left"></i>
                            Quay lại
                        </button>
                        <button type="submit" name="action" value="updateUserPassword" class="btn btn-save">
                            <i class="bi bi-check-lg"></i>
                            Lưu mật khẩu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="js/passwordChange.js"></script>
    <?php 
        include 'footer.php';
        include 'javascript.php';
    ?>
</body>
</html>