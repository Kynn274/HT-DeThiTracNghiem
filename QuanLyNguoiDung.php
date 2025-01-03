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
    .btn{
      padding: 10px 15px;
      height: 100%;
    }
    thead{
      background-color: #f8f9fa;
      text-align: center;
    }
    caption{
      font-size: 1.5rem;
      font-weight: bold;
    }
    td, th{
      vertical-align: middle;
    }
    tbody button i{
      font-size: 1rem;
      margin-right: 5px;
    }
    tbody button p{
      display: inline;
    }
    tbody button{
      margin: 5px;
    }
    
    @media (max-width: 1200px) {
      tbody button i{
        font-size: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0;
      }
      tbody button p{
        display: none;
      }
    }
    .show-info, .show-evidence{
      background-color: rgba(0, 0, 0, 0.5);
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      display: none;
      z-index: 9999;
    }
    .show-info .container, .show-evidence .container{
      background-color: #fff;
      width: fit-content;
      height: fit-content;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      padding: 20px;
    }   
    .show-evidence img{
      width: 600px;
      height: 400px;
    }
    .show-info .container{
      width: fit-content;
      min-width: 300px;
      border-radius: 10px;
      box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1);
      padding: 20px;
    }
    .show-info .container h1{
      font-size: 1.5rem;
      font-weight: bold;
      margin: 10px 0;
      text-align: center;
    }
    .show-info .info-container label{
      font-size: 1rem;
      font-weight: bold;
    }
    .show-info .avatar img{
      width: 100px;
      height: 100px;
      border-radius: 50%;
    }
    .show-info .info-container{
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      gap: 10px;
      padding: 10px;
    }
    .show-info .info-item{
      width: 100%;
      display: flex;
      align-items: flex-start;
      flex-direction: column;
    }
    .show-info .info-item input{
      width: calc(100% - 20px);
      padding: 5px;
      background-color: transparent;
      border: none;
      margin: 0 10px;
    }
    .close-info, .close-evidence{
      z-index: 10000;
      background-color: transparent;
      border: none;
      width: fit-content;
      height: fit-content;
      position: absolute;
      top: 20px;
      right: 20px;
      cursor: pointer;
      transition: all 0.3s ease;
    }
    .close-info i, .close-evidence i{
      font-size: 1.5rem;
      color: #fff;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
    }
    .close-info:hover, .close-evidence:hover {
      transform: rotate(90deg);
    }
    .close-info:hover i, .close-evidence:hover i {
      color: #ff4d4d;
    }
    /* Container for the table with scrolling */
    .container.article {
        max-height: 600px;
        overflow-y: auto;
        margin: 20px auto;
        border-radius: 8px;
        /* box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); */
    }

    /* Make the header sticky while scrolling */
    .table thead th {
        position: sticky;
        top: 0;
        background-color: #f8f9fa;
        z-index: 1;
    }

    /* Custom scrollbar styling */
    .container.article::-webkit-scrollbar {
        width: 8px;
    }

    .container.article::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .container.article::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }

    .container.article::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Ensure the table caption stays above the scrollable area */
    .table caption {
        position: sticky;
        top: 0;
        background-color: white;
        z-index: 2;
        padding: 10px 0;
    }

    /* Ensure proper spacing */
    .table {
        margin-bottom: 0;
    }

    /* Style mới cho bảng */
    .table {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }

    .table thead {
        background: linear-gradient(135deg, #4154f1, #2c3cdd);
        color: white;
    }

    .table thead th {
        font-weight: 500;
        letter-spacing: 0.5px;
        padding: 15px;
        border: none;
    }

    .table tbody tr {
        transition: all 0.3s ease;
    }

    .table tbody tr:hover {
        background-color: #f8f9ff;
        transform: scale(1.01);
    }

    .table tbody td {
        padding: 12px 15px;
        vertical-align: middle;
        border-bottom: 1px solid #edf2f9;
    }

    /* Style cho buttons */
    .btn {
        padding: 8px 15px;
        border-radius: 8px;
        transition: all 0.3s ease;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        border: none;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .btn-primary {
        background: linear-gradient(135deg, #4154f1, #2c3cdd);
    }

    .btn-danger {
        background: linear-gradient(135deg, #ff4d4d, #f73859);
    }

    .btn-success {
        background: linear-gradient(135deg, #2dce89, #2dcecc);
    }

    .btn-warning {
        background: linear-gradient(135deg, #fb6340, #fbb140);
    }

    /* Style cho modal */
    .show-info .container, .show-evidence .container {
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        padding: 25px;
    }

    .show-info .container h1 {
        color: #2c3cdd;
        font-size: 1.8rem;
        margin-bottom: 20px;
    }

    .show-info .avatar img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 3px solid #4154f1;
        padding: 3px;
    }

    .show-info .info-container {
        background: #f8f9ff;
        border-radius: 12px;
        padding: 20px;
    }

    .show-info .info-item {
        margin-bottom: 15px;
    }

    .show-info .info-item label {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 5px;
    }

    .show-info .info-item input {
        font-size: 1rem;
        color: #2c3cdd;
        padding: 8px 12px;
        background: white;
        border-radius: 8px;
        width: 100%;
    }

    .show-evidence .container img{
      width: 100%;
      height: 100%;
    }
    /* Style cho container chính */
    .container.article {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }

    .table caption {
        color: #2c3cdd;
        font-size: 1.8rem;
        font-weight: 600;
        margin-bottom: 20px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Custom scrollbar */
    .container.article::-webkit-scrollbar {
        width: 6px;
    }

    .container.article::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .container.article::-webkit-scrollbar-thumb {
        background: #4154f1;
        border-radius: 10px;
    }

    .container.article::-webkit-scrollbar-thumb:hover {
        background: #2c3cdd;
    }

    /* Responsive adjustments */
    @media (max-width: 1200px) {
        tbody button i {
            font-size: 1.2rem;
            margin: 0;
        }
        
        .btn {
            padding: 6px 10px;
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

    /* Content Styling */
    .hero-content {
        position: relative;
        z-index: 1;
        text-align: center;
        padding: 0 15px;
    }

    .hero-title {
        color: white;
        font-size: 2.8rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.8s ease forwards;
    }

    .hero-subtitle {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1.2rem;
        font-weight: 500;
        margin-bottom: 2rem;
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.8s ease 0.2s forwards;
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
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

    .toast-container {
      position: fixed;
      bottom: 30px;
      left: 30px;
      z-index: 999999;
    }

    .toast {
      position: relative;
      width: 400px;
      padding: 20px;
      border-radius: 12px;
      background: #fff;
      box-shadow: 0 5px 20px rgba(0,0,0,0.15);
      display: none;
    }

    .toast.active {
      display: block;
      animation: show_toast 0.3s ease forwards;
    }

    @keyframes show_toast {
      0% {
        transform: translateX(-100%);
      }
      100% {
        transform: translateX(0);
      }
    }

    .toast .toast-content {
      display: flex;
      align-items: center;
    }

    .toast-content .bi {
      font-size: 25px;
      margin-right: 12px;
    }

    .toast-content .bi.bi-check-circle-fill {
      color: #2dce89;
    }

    .toast-content .bi.bi-x-circle-fill {
      color: #f5365c;
    }

    .toast-content .message {
      display: flex;
      flex-direction: column;
    }

    .message .text {
      font-size: 16px;
      font-weight: 400;
      color: #666666;
    }

    .message .text.text-1 {
      font-weight: 600;
      color: #333;
    }

    .toast .close {
      position: absolute;
      top: 10px;
      right: 15px;
      cursor: pointer;
      opacity: 0.6;
    }

    .toast .close:hover {
      opacity: 1;
    }

    .toast .progress {
      position: absolute;
      bottom: 0;
      left: 0;
      height: 3px;
      width: 100%;
      background: #ddd;
    }

    .toast .progress:before {
      content: '';
      position: absolute;
      bottom: 0;
      right: 0;
      height: 100%;
      width: 100%;
      background-color: #4154f1;
    }

    .toast.active .progress:before {
      animation: progress 5s linear forwards;
    }

    @keyframes progress {
      100% {
        right: 100%;
      }
    }
  </style>
  <div class="hero inner-page">
    <div class="hero-background"></div>
    
    <!-- Floating Shapes -->
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>
    <div class="shape shape-3"></div>
    
    <div class="container">
      <div class="hero-content">
        <span class="text-gradient d-block mb-2 text-center" data-aos="fade-up">Quản Lý Hệ Thống</span>
        <h1 class="heading text-white mb-4 text-center" data-aos="fade-up" data-aos-delay="100" 
            style="font-size: 3rem; font-weight: 700;">Quản Lý Người Dùng</h1>
        <p class="text-white-50 mb-0 text-center" data-aos="fade-up" data-aos-delay="200" 
           style="font-size: 1.1rem;">
          Quản lý và giám sát tài khoản người dùng trong hệ thống
        </p>
      </div>
    </div>
  </div>

  <div class="section">
    <div class="container article">
      <table class="table table-hover caption-top">
        <caption>DANH SÁCH NGƯỜI DÙNG</caption>
        <thead>
          <tr class="text-center text-dark fw-bold">
            <th scope="col">#</th>
            <th scope="col" style="display: none;">Mã người dùng</th>
            <th scope="col">Tài khoản</th>
            <th scope="col">Mật khẩu</th>
            <th scope="col">Vai trò</th>
            <th scope="col">Ngày tham gia</th>
            <th scope="col">Minh chứng</th>
            <th scope="col">Hành động</th>
          </tr>
        </thead>
        <tbody>
          <?php
            if(count($users) > 0){
            $i = 0;
            foreach ($users as $user) {
              $i++;
          ?>
          <tr>
            <th scope="row" style="text-align: center;"><?php echo $i ?></th>
            <td style="display: none;"><input type="text" value="<?php echo $user['UserID'] ?>" disabled></td>
            <td><input type="text" value="<?php echo $user['Username'] ?>" disabled></td>
            <td><input type="password" value="<?php echo $user['Password'] ?>" disabled></td>
            <td><input type="text" value="<?php echo $type = $user['Type'] == 0 ? 'Admin' : ($user['Type'] == 1 ? 'Học sinh' : 'Giáo viên') ?>" disabled></td>
            <td><input type="text" value="<?php echo $user['JoiningDate'] ?>" disabled></td>
            <td><button class="btn btn-primary show-evidence-btn" value="<?php echo $user['Evidence'] ?>"><i class="bi bi-eye-fill"></i><p class="m-0">Xem <br> minh chứng</p></button></td>
            <td>
              <?php if ($user['Status'] == 1) { ?>
                <button class="btn btn-danger ban-btn" value="<?php echo $user['UserID'] ?>"><i class="bi bi-lock-fill"></i><p class="m-0">Hạn Chế<br>tài khoản</p></button>
              <?php } else { ?>
                <button class="btn btn-success activate-btn" value="<?php echo $user['UserID'] ?>"><i class="bi bi-unlock-fill"></i><p class="m-0">Kích hoạt<br>tài khoản</p></button>
              <?php } ?>
              <!-- <button class="btn btn-warning reset-btn" value="<?php echo $user['UserID'] ?>"><i class="bi bi-key-fill"></i><p class="m-0">Khôi phục<br>mật khẩu</p></button> -->
              <button class="btn btn-primary show-info-btn" value="<?php echo $user['UserID'] ?>"><i class="bi bi-info-circle"></i><p class="m-0">Thông tin<br>chi tiết</p></button>
            </td>
            </tr>
            <?php } ?>
          <?php }else{ ?>
            <tr>
              <td colspan="8" style="text-align: center;">Không tìm thấy người dùng nào</td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
  <div class="show-info">
    <button class="btn btn-danger close-btn close-info z-1001"><i class="bi bi-x-lg"></i></button>
    <div class="container">
      <h1>Thông tin chi tiết</h1>
      <div class="info-container">
        <div class="avatar">
          <img src="" alt="">
        </div>
        <div class="info-item">
          <label for="fullname">Họ và tên:</label>
          <input type="text" id="fullname" value="" disabled>
        </div>
        <div class="info-item">
          <label for="email">Email:</label>
          <input type="email" id="email" value="" disabled>
        </div>
        <div class="info-item">
          <label for="phone">Số điện thoại:</label>
          <input type="tel" id="phone" value="" disabled>
        </div>
        <div class="info-item">
          <label for="birthday">Ngày sinh:</label>
          <input type="date" id="birthday" value="" disabled>
        </div>
      </div>
    </div>
  </div>
  <div class="show-evidence">
    <button class="btn btn-danger close-btn close-evidence z-1001"><i class="bi bi-x-lg"></i>
    </button>
    <div class="container">
      <img src="" alt="">
    </div>
  </div>
  <div class="toast-container">
    <div class="toast" role="alert">
      <div class="toast-content">
        <i class="bi"></i>
        <div class="message">
          <span class="text text-1"></span>
          <span class="text text-2"></span>
        </div>
      </div>
      <i class="bi bi-x-lg close"></i>
      <div class="progress"></div>
    </div>
  </div>
  <script src="js/usersMangement.js"></script>
  <?php
    include 'footer.php';
    include 'javascript.php';
  ?>
  
  </body>
  </html>
