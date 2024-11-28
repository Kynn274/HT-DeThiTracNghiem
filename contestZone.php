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
    <div class="container mt-4" style="min-height: 250px;">
        <div class="row">
            <div class="col-md-12">
                <!-- Search Box -->
                <div class="mb-4 position-relative">
                    <input type="text" class="form-control" placeholder="Tìm kiếm cuộc thi..." id="searchBox" style="border-radius: 30px; padding: 10px 20px; border: 1px solid #ccc; font-size: 16px;">
                    <button class="bg-transparent border-0 position-absolute top-50 end-0 fs-5 translate-middle" id="searchButton"><i class="bi bi-search search-icon"></i></button>
                </div>
                
                <!-- Danh sách các cuộc thi -->
                <div class="row" id="examList">
                    
                    <!-- Giả lập 3 cuộc thi -->
                    <!-- <div class="col-md-4 mb-4">
                        <div class="card" style="border-radius: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.3s;">
                            <div class="card-body">
                                <h5 class="card-title">Cuộc thi 1</h5>
                                <p class="card-text">Mô tả về cuộc thi 1.</p>
                                <a href="ThamGiaThi.php?id=1" class="btn btn-primary" style="border-radius: 25px;">Tham gia</a>
                                <a href="edit_exam.php?id=1" class="btn btn-secondary" style="border-radius: 25px;">Chỉnh sửa</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card" style="border-radius: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.3s;">
                            <div class="card-body">
                                <h5 class="card-title">Cuộc thi 2</h5>
                                <p class="card-text">Mô tả về cuộc thi 2.</p>
                                <a href="ThamGiaThi.php?id=2" class="btn btn-primary" style="border-radius: 25px;">Tham gia</a>
                                <a href="edit_exam.php?id=2" class="btn btn-secondary" style="border-radius: 25px;">Chỉnh sửa</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card" style="border-radius: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.3s;">
                            <div class="card-body">
                                <h5 class="card-title">Cuộc thi 3</h5>
                                <p class="card-text">Mô tả về cuộc thi 3.</p>
                                <a href="ThamGiaThi.php?id=3" class="btn btn-primary" style="border-radius: 25px;">Tham gia</a>
                                <a href="edit_exam.php?id=3" class="btn btn-secondary" style="border-radius: 25px;">Chỉnh sửa</a>
                            </div>
                        </div>
                    </div> -->
                </div>

                <!-- Nút chuyển trang -->
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center" id="pagination">
                        <li class="page-item" id="prevPage">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item" id="nextPage">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <script src="./js/contestZone.js"></script>
    <?php
        include 'footer.php';
        include 'javascript.php';
    ?>
</body>
</html>