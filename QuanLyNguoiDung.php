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
      z-index: 5;
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
      z-index: 5;
      background-color: transparent;
      border: none;
      width: fit-content;
      height: fit-content;
      position: absolute;
      top: 20px;
      right: 20px;
    }
    .close-info i, .close-evidence i{
      font-size: 1.5rem;
      color: #fff;
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
  </style>
  <div class="hero overlay inner-page">
    <img src="images/blob.svg" alt="" class="img-fluid blob">
    <div class="container">
      <div class="row align-items-center justify-content-center text-center pt-5">
        <div class="col-lg-6">
          <!-- <p data-aos="fade-up" class="meta">by <a href="#">Admin</a> &bullet; on <a href="#">Apr 4th, 2022</a> </p> -->
          <h1 class="heading text-white mb-3" data-aos="fade-up" data-aos-delay="100">QUẢN LÝ NGƯỜI DÙNG </h1>
        </div>
      </div>
    </div>
  </div>

  <div class="section">
    <div class="container article">
      <table class="table table-hover caption-top">
        <caption>DANH SÁCH NGƯỜI DÙNG</caption>
        <thead>
          <tr>
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
            <td><button class="btn btn-primary show-evidence-btn" value="<?php echo $user['Evidence'] ?>"><i class="bi bi-eye-fill"></i><p>Xem <br> minh chứng</p></button></td>
            <td>
              <?php if ($user['Status'] == 1) { ?>
                <button class="btn btn-danger ban-btn" value="<?php echo $user['UserID'] ?>"><i class="bi bi-lock-fill"></i><p>Hạn Chế<br>tài khoản</p></button>
              <?php } else { ?>
                <button class="btn btn-success activate-btn" value="<?php echo $user['UserID'] ?>"><i class="bi bi-unlock-fill"></i><p>Kích hoạt<br>tài khoản</p></button>
              <?php } ?>
              <button class="btn btn-warning reset-btn" value="<?php echo $user['UserID'] ?>"><i class="bi bi-key-fill"></i><p>Khôi phục<br>mật khẩu</p></button>
              <button class="btn btn-primary show-info-btn" value="<?php echo $user['UserID'] ?>"><i class="bi bi-info-circle"></i><p>Thông tin<br>chi tiết</p></button>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
  <div class="show-info">
    <button class="btn btn-danger close-btn close-info"><i class="bi bi-x-lg"></i></button>
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
    <button class="btn btn-danger close-btn close-evidence"><i class="bi bi-x-lg"></i>
    </button>
    <div class="container">
      <img src="" alt="">
    </div>
  </div>
  <script src="./js/usersMangement.js"></script>
  <?php
    include 'footer.php';
    include 'javascript.php';
  ?>
  </body>
  </html>
