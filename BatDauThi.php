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
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-12">
                <!-- Exam Details Card -->
                <div class="card shadow-lg rounded-lg border-0 mb-5"> <!-- Added mb-5 for margin-bottom -->
                    <div class="card-body">
                        <!-- Title Section -->
                        <h2 class="card-title text-center text-primary font-weight-bold mb-3">Cuộc Thi: [Tên Cuộc Thi]</h2>
                        <p class="card-text text-muted text-center mb-4">Mô tả cuộc thi: [Mô Tả Cuộc Thi]</p>

                        <!-- Start Exam Button Section -->
                        <div class="d-flex justify-content-center">
                            <a href="ThamGiaThi.php?id=1" class="btn btn-success rounded-pill px-5 py-3 btn-lg shadow-lg">Bắt đầu cuộc thi</a>
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
