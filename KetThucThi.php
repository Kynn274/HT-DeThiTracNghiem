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

    <!-- Exam Completion -->
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg rounded-lg border-0">
                    <div class="card-body text-center">
                        <h2 class="text-success">Hoàn thành cuộc thi.</h2>
                        
                        <!-- Total Time Spent -->
                        <h5 class="text-muted">Tổng thời gian làm bài: <span id="total-time">00:00</span></h5>

                        <div class="mt-4">
                            <a href="#" class="btn btn-success rounded-pill px-4 py-2 mb-2">Xem Kết Quả</a>
                        </div>
                        <div>
                            <a href="index.php" class="btn btn-primary rounded-pill px-4 py-2">Về trang chủ</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5"></div> <!-- Add space between the form and footer -->

    <?php
        include 'footer.php';
        include 'javascript.php';
    ?>
</body>
</html>
