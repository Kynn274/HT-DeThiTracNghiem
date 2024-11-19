<?php
  include 'head.php';
?>
<style>
    /* Hiệu ứng hover cho các hàng trong bảng */
    .table-hover tbody tr:hover {
        background-color: #e3f2fd;
        box-shadow: inset 0 0 10px rgba(0, 123, 255, 0.25);
        cursor: pointer;
        transition: all 0.3s ease-in-out;
    }

    /* Hiệu ứng hover cho các nút hành động */
    .btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease-in-out;
    }
    .btn-warning:hover {
        background-color: #ffcc00;
        border-color: #ffcc00;
        color: #fff;
    }
    .btn-danger:hover {
        background-color: #d9534f;
        border-color: #d43f3a;
        color: #fff;
    }
    .btn-primary:hover {
        background-color: #337ab7;
        border-color: #2e6da4;
        color: #fff;
    }
</style>


<body>
    <?php
        include 'header.php';
    ?>

    <div class="hero overlay" style="height: 150px !important; max-height: 150px !important; min-height: 100px !important">
    </div>

    <div class="container my-5">
    <h2 class="text-center mb-4 fw-bold text-primary">Quản Lý Ngân Hàng Câu Hỏi</h2>

    <!-- Form thêm câu hỏi -->
    <div class="card shadow mb-5">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Thêm Câu Hỏi</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="#">
                <div class="mb-3">
                    <label for="question" class="form-label fw-semibold">Câu Hỏi</label>
                    <textarea class="form-control" id="question" name="question" rows="3" required></textarea>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="optionA" class="form-label fw-semibold">Đáp Án A</label>
                        <input type="text" class="form-control" id="optionA" name="optionA" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="optionB" class="form-label fw-semibold">Đáp Án B</label>
                        <input type="text" class="form-control" id="optionB" name="optionB" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="optionC" class="form-label fw-semibold">Đáp Án C</label>
                        <input type="text" class="form-control" id="optionC" name="optionC" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="optionD" class="form-label fw-semibold">Đáp Án D</label>
                        <input type="text" class="form-control" id="optionD" name="optionD" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="correctAnswer" class="form-label fw-semibold">Đáp Án Đúng</label>
                    <select class="form-select" id="correctAnswer" name="correctAnswer" required>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                    </select>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">Thêm Câu Hỏi</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Danh sách câu hỏi -->
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Danh Sách Câu Hỏi</h4>
        </div>
        <div class="card-body">
            <table class="table table-hover table-striped">
                <thead class="table-success">
                    <tr>
                        <th>ID</th>
                        <th>Câu Hỏi</th>
                        <th>Đáp Án A</th>
                        <th>Đáp Án B</th>
                        <th>Đáp Án C</th>
                        <th>Đáp Án D</th>
                        <th>Đáp Án Đúng</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Nội dung sẽ được điền từ cơ sở dữ liệu -->
                </tbody>
            </table>
        </div>
    </div>
</div>

    <?php
        include 'footer.php';
        include 'javascript.php';
    ?>
</body>
</html>
