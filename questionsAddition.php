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
    /* Make the header sticky while scrolling */
    .questionAddition thead th {
        position: sticky;
        top: 0;
        background-color: #f8f9fa;
        z-index: 1;
        font-weight: bold;
        text-align: center;
    }

    /* Custom scrollbar styling */
    .questionsTable::-webkit-scrollbar {
        width: 8px;
    }

    .questionsTable::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .questionsTable::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }

    .questionsTable::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Ensure the table caption stays above the scrollable area */
    .questionAddition caption {
        position: sticky;
        top: 0;
        background-color: white;
        z-index: 2;
        padding: 10px 0;
        font-weight: bold;
    }

    /* Ensure proper spacing */
    .questionAddition table {
        margin-bottom: 0;
    }
</style>


<body>
    <?php
        include 'header.php';
    ?>

    <div class="hero overlay" style="height: 150px !important; max-height: 150px !important; min-height: 100px !important">
    </div>

    <div class="container article mb-5 my-5">
        <h2 class="text-center mb-4 fw-bold text-primary">Thêm Câu Hỏi</h2>

        <!-- Form thêm câu hỏi -->
        <div class="card mb-5">
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
                    <div class="mb-3">
                        <label for="level" class="form-label fw-semibold">Độ khó</label>
                        <select class="form-select" id="level" name="level" required>
                            <option value="1">Dễ</option>
                            <option value="2">Trung bình</option>
                            <option value="3">Khó</option>
                        </select>
                    </div>
                    <div class="d-grid">
                        <button type="submit" id="addQuestionBtn" class="btn btn-primary btn-lg">Thêm Câu Hỏi</button>
                    </div>
                </form>
            </div>
        </div>    

        <!-- Danh sách câu hỏi -->
        <div id="questionsTable">
            <table class="table table-hover caption-top">
            <caption>DANH SÁCH CÂU HỎI</caption>
            <thead>
                <tr>
                    <th scope="col" width="5%">#</th>
                    <th scope="col" width="25%">Câu hỏi</th>
                    <th scope="col" width="10%">Độ khó</th>
                    <th scope="col" width="10%">A</th>
                    <th scope="col" width="10%">B</th>
                    <th scope="col" width="10%">C</th>
                    <th scope="col" width="10%">D</th>
                    <th scope="col" width="20%">Hành động</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end gap-2 mb-3 mt-3">
            <button class="btn btn-primary" id="backToQuestionsBankForm">Quay lại</button>
            <button class="btn btn-success" id="saveQuestion">Lưu câu hỏi</button>
        </div>
    </div>
    <script src="./js/questionsBank.js"></script>
    <?php
        include 'footer.php';
        include 'javascript.php';
    ?>
</body>
</html>
