<?php
  include 'head.php';
?>
<body>
  <?php
    include 'header.php';
    $stmt = $conn->prepare("SELECT u.UserID, u.Username, u.Password, u.Type, u.JoiningDate, u.Status, ud.Evidence FROM Users u, UserDetails ud WHERE u.UserID = ud.UserID");
    $stmt->execute();
    $result = $stmt->get_result();
    $users = $result->fetch_all(MYSQLI_ASSOC);
  ?>
  <style>
    input[type="text"], input[type="password"] {
      border: none;
      background-color: transparent;
      width: fit-content;
      max-width: 100px;
    }
   .title {
    color: #006994;
    text-align: center;
    margin-bottom: 30px;
    }

    label {
    font-size: 16px;
    color: #006994;
    display: block;
    margin-bottom: 8px;
    }

    input, select {
    width: 100%;
    padding: 10px;
    font-size: 14px;
    border: 1px solid #006994;
    border-radius: 4px;
    background-color: #f0f8ff;
    }

input:focus, select:focus {
    border-color: #008cba;
    outline: none;
}

/* Submit button */
.btn-submit {
    background-color: #006994;
    color: white;
    padding: 12px;
    font-size: 16px;
    border: none;
    border-radius: 4px;
    width: 100%;
    cursor: pointer;
}

.btn-submit:hover {
    background-color: #008cba;
}

/* Responsive */
@media (max-width: 600px) {
    .container {
        padding: 15px;
    }

    .title {
        font-size: 24px;
    }

    .btn-submit {
        font-size: 14px;
    }
}


  </style>
  
  <div class="hero overlay inner-page">
    <img src="images/blob.svg" alt="" class="img-fluid blob">
    <div class="container">
      <div class="row align-items-center justify-content-center text-center pt-5">
        <div class="col-lg-6">
          <!-- <p data-aos="fade-up" class="meta">by <a href="#">Admin</a> &bullet; on <a href="#">Apr 4th, 2022</a> </p> -->
          <h1 class="heading text-white mb-3" data-aos="fade-up" data-aos-delay="100">QUẢN LÝ QUYỀN TRUY CẬP</h1>
        </div>
      </div>
    </div>
  </div>
    <style> 
    
    </style>
    <div class="container">
        <h1 class="title">Quản Lý Quyền Truy Cập</h1>
        <form action="#" method="post">
            <div class="form-group">
                <label for="user-name">Tên người dùng</label>
                <input type="text" id="user-name" name="user-name" required>
            </div>
            
            <div class="form-group">
                <label for="role">Vai trò</label>
                <select id="role" name="role">
                    <option value="admin">Quản trị viên</option>
                    <option value="instructor">Giáo viên</option>
                    <option value="student">Học sinh</option>
                </select>
            </div>

            <div class="form-group">
                <label for="status">Trạng thái tài khoản</label>
                <select id="status" name="status">
                    <option value="active">Kích hoạt</option>
                    <option value="inactive">Khóa</option>
                </select>
            </div>

            <div class="form-group">
                <label for="permissions">Quyền truy cập</label>
                <select id="permissions" name="permissions">
                    <option value="create_exam">Tạo đề thi</option>
                    <option value="manage_users">Quản lý người dùng</option>
                    <option value="view_results">Xem kết quả</option>
                </select>
            </div>

            <div class="form-group">
                <button type="submit" class="btn-submit">Cập nhật quyền</button>
            </div>
        </form>
    </div>

  <?php
    include 'footer.php';
    include 'javascript.php';
  ?>
</body>
</html>
