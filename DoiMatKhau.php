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
                if($newPassword == $oldPassword){
                    $message = 'New password cannot be the same as the old password';
                    $conn->close();
                }else if($newPassword == $confirmPassword){
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
                                $message = 'Password updated successfully';
                                header("Location: ChinhSuaThongTinCaNhan.php");
                            }
                        }else{
                            $message = 'Old password is incorrect';
                            $conn->close();
                        }
                    }
                }else{
                    $message = 'Confirm password does not match';
                    $conn->close();
                }
            }
        }
    ?>
    <style>
        .container.article{
            display: flex;
            align-items: flex-start;
            justify-content: center;
        }
        form h4{
            font-weight: bold;
            font-size: 15pt;
            color: #848D92 !important;
            margin-top: 0 !important;
        }
        form{
            width: 300px;
        }
        form input{
            padding: 10px 25px !important;
        }
        .form-group{
            position: relative;
        }
        .buttons{
            float: right;
        }
        #togglePassword-old, #togglePassword-new, #togglePassword-confirm {
			position: absolute;
			right: 10px;
			top: 38px;
			cursor: pointer;
		}
    </style>
    <div class="hero overlay" style="height: 150px !important; max-height: 150px !important; min-height: 100px !important">
	</div>
    <div class="section">
        <div class="container article">
            <form action="DoiMatKhau.php" method="post" enctype="multipart/form-data">
                <h4>ĐỔI MẬT KHẨU</h4>
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                <div class="form-group">
                    <label for="old_password">Mật khẩu cũ</label>
                    <input type="password" class="form-control" id="old_password" name="old_password" value="">
                    <span id="togglePassword-old">
						<i class="bi bi-eye" id="eyeIcon-old"></i>
					</span>
                </div>
                <div class="form-group">
                    <label for="new_password">Mật khẩu mới</label>
                    <input type="password" class="form-control" id="new_password" name="new_password">
                    <span id="togglePassword-new">
						<i class="bi bi-eye" id="eyeIcon-new"></i>
					</span>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Nhập lại mật khẩu mới</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                    <span id="togglePassword-confirm">
						<i class="bi bi-eye" id="eyeIcon-confirm"></i>
					</span>
                </div>
                <div class="form-group">
                    <p class="text-danger"><?php if(!empty($message)) echo $message; ?></p>
                </div>
                <div class="form-group buttons">
                    <button type="button" class="btn btn-secondary">Quay lại</button>
                    <button type="submit" name="action" value="updateUserPassword" class="btn btn-success">Lưu mật khẩu</button>
                </div>

            </form>
        </div>
    </div>
    <script src="js/passwordChange.js"></script>
    <?php 
        include 'footer.php';
        include 'javascript.php';
    ?>
</body>
</html>