<?php
    include 'head.php';
?>
<body>
    <?php 
        include 'header.php'; 
    ?>
    <style>
        .avatar{
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            float: left;
            margin-right: 20px;
            gap: 20px;
        }
        .avatar img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
        }
        form{
            width: calc(100% - 190px);
            margin-right: 20px;
        }
        form h4{
            font-weight: bold;
            font-size: 15pt;
            color: #848D92 !important;
            margin-top: 0 !important;
        }
        .container.article{
            display: flex;
            align-items: flex-start;
            justify-content: center;
        }
        .buttons{
            float: right;
        }
    </style>
    <div class="hero overlay" style="height: 150px !important; max-height: 150px !important; min-height: 100px !important">
	</div>
    <div class="section">
        <div class="container article">
            <div class="avatar">
                <img src="images/no-avatar.jpg" alt="avatar">
                <button type="button" class="btn btn-primary">Chỉnh sửa ảnh đại diện</button>
            </div>
            <form action="" method="post">
                <h4>CHỈNH SỬA THÔNG TIN CÁ NHÂN</h4>
                <div class="form-group">
                    <label for="fullname">Họ và tên</label>
                    <input type="text" class="form-control" id="fullname" name="fullname" value="">
                </div>
                <div class="form-group">
                    <label for="dob">Ngày sinh</label>
                    <input type="date" class="form-control" id="dob" name="dob" value="">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="">
                </div>
                <div class="form-group">
                    <label for="phone">Số điện thoại</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="">
                </div>
                <div class="form-group buttons">
                    <button type="button" class="btn btn-secondary">Quay lại</button>
                    <button type="submit" class="btn btn-success">Lưu thông tin</button>
                </div>
            </form>
        </div>
    </div>
    <?php 
        include 'footer.php';
        include 'javascript.php';
    ?>
</body>
</html>