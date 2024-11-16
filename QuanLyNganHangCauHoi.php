<?php
  include 'head.php';
?>
<body>
    <?php
        include 'header.php';
    ?>

    <!-- Add content here -->
    <div class="hero overlay" style="height: 150px !important; max-height: 150px !important; min-height: 100px !important">
    </div>

    <div class="container my-5">
        <h2 class="text-center mb-4">Quản Lý Thư Viện Đề Thi</h2>

        <!-- Danh sách đề thi -->
        <div class="mb-4">
            <h4>Danh Sách Đề Thi</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên Đề Thi</th>
                        <th>Số Câu Hỏi</th>
                        <th>Thời Gian</th>
                        <th>Ngày Tạo</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dữ liệu đề thi sẽ được thêm vào đây -->
                    <tr>
                        <td>1</td>
                        <td>Đề Thi Toán 1</td>
                        <td>20</td>
                        <td>30 phút</td>
                        <td>01/01/2024</td>
                        <td>
                            <a href="#" class="btn btn-warning btn-sm">Chỉnh Sửa</a>
                            <a href="#" class="btn btn-danger btn-sm">Xóa</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Quản lý câu hỏi trong thư viện -->
        <div class="mb-4">
            <h4>Quản Lý Câu Hỏi</h4>
            <a href="manage_questions.php" class="btn btn-info">Quản Lý Câu Hỏi</a>
        </div>

        <!-- Quản lý quyền truy cập -->
        <div class="mb-4">
            <h4>Quản Lý Quyền Truy Cập</h4>
            <a href="manage_permissions.php" class="btn btn-info">Quản Lý Quyền Truy Cập</a>
        </div>

    </div>

    <?php
        include 'footer.php';
        include 'javascript.php';
    ?>
</body>
</html>
