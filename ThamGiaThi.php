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

    <!-- Exam Participation Page -->
    <div class="container mt-4">
        <div class="row">
            <!-- Exam Details -->
            <div class="col-md-12">
                <div class="card shadow-lg rounded-lg border-0">
                    <div class="card-body">
                        <h2 class="card-title text-center text-primary">Cuộc Thi: [Tên Cuộc Thi]</h2>
                        <p class="card-text text-muted text-center mb-4">Mô tả cuộc thi: [Mô Tả Cuộc Thi]</p>

                        <!-- Start Exam Button -->
                        <div class="text-center">
                            <a href="start_exam.php?id=1" class="btn btn-success rounded-pill px-4 py-2">Bắt đầu cuộc thi</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Questions Display -->
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card shadow-lg rounded-lg border-0">
                    <div class="card-body">
                        <h4 class="text-primary">Câu hỏi 1:</h4>
                        <p>[Nội Dung Câu Hỏi]</p>

                        <!-- Multiple Choices -->
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question1" id="option1" value="A">
                            <label class="form-check-label" for="option1">Đáp án A</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question1" id="option2" value="B">
                            <label class="form-check-label" for="option2">Đáp án B</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question1" id="option3" value="C">
                            <label class="form-check-label" for="option3">Đáp án C</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question1" id="option4" value="D">
                            <label class="form-check-label" for="option4">Đáp án D</label>
                        </div>

                        <!-- Navigation buttons -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="previous_question.php?id=1" class="btn btn-outline-secondary px-4 py-2 rounded-pill">Quay lại</a>
                            <a href="next_question.php?id=1" class="btn btn-primary px-4 py-2 rounded-pill">Tiếp theo</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Exam Completion -->
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card shadow-lg rounded-lg border-0">
                    <div class="card-body text-center">
                        <h2 class="text-success">Cảm ơn bạn đã tham gia cuộc thi!</h2>
                        <p class="text-muted mb-4">Kết quả của bạn sẽ được thông báo sau khi hoàn tất quá trình chấm điểm.</p>

                        <div>
                            <a href="view_results.php?id=1" class="btn btn-success rounded-pill px-4 py-2 mb-2">Xem Kết Quả</a>
                            <a href="index.php" class="btn btn-primary rounded-pill px-4 py-2">Về trang chủ</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
        include 'footer.php';
        include 'javascript.php';
    ?>
</body>
</html>
