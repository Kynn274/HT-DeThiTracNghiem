<?php
  include 'head.php';
?>
<body>
    <?php
        include 'header.php';
        $sql = "SELECT * FROM Contests WHERE UserID = ? AND Type = 'contest'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
    	$stmt->execute();
        $contests = $stmt->get_result();
        $subjects = [
            'toan' => 'Toán',
            'anh' => 'Tiếng Anh',
            'ly' => 'Vật lý',
            'hoa' => 'Hóa học',
            'sinh' => 'Sinh học',
            'van' => 'Ngữ văn',
            'su' => 'Sử',
            'dia' => 'Địa',
            'gdcd' => 'GDCD',
            'tin' => 'Tin học'
        ];
    ?>
    <style>
    input {
      border: none;
      background-color: transparent;
      width: fit-content;
      max-width: 100px;
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
        text-align: center;
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
        text-align: center;
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
        margin: 5px;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .btn-primary {
        background: linear-gradient(135deg, #4154f1, #2c3cdd);
        color: white;
    }

    .btn-danger {
        background: linear-gradient(135deg, #ff4d4d, #f73859);
        color: white;
    }

    .btn-success {
        background: linear-gradient(135deg, #2dce89, #2dcecc);
        color: white;
    }

    .btn-warning {
        background: linear-gradient(135deg, #fb6340, #fbb140);
        color: white;
    }

    .btn-info {
        background: linear-gradient(135deg, #11cdef, #1171ef);
        color: white;
    }

    .btn-secondary {
        background: linear-gradient(135deg, #8898aa, #6c757d);
        color: white;
    }

    /* Container style */
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

    /* Action buttons container */
    .action-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        justify-content: center;
    }

    .action-buttons .btn {
        flex: 1;
        min-width: 120px;
        justify-content: center;
    }

    /* Modal styling */
    #contestInfo .card {
        border: none;
        box-shadow: 0 15px 35px rgba(0,0,0,0.2);
    }

    #contestInfo .card-header {
        background: linear-gradient(135deg, #4154f1, #2c3cdd);
        color: white;
        border-radius: 10px 10px 0 0;
    }

    #contestInfo .card-body {
        padding: 25px;
    }

    /* Add Contest Section */
    .mb-4.container {
        background: white;
        border-radius: 15px;
        padding: 25px;
        margin-top: 20px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }

    .mb-4.container h4 {
        color: #2c3cdd;
        margin-bottom: 15px;
        font-weight: 600;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        tbody button i {
            font-size: 1.2rem;
            margin: 0;
        }
        
        tbody button p {
            display: none;
        }

        .action-buttons .btn {
            min-width: auto;
            padding: 8px;
        }
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
    </style>

    <div class="hero overlay" style="height: 150px !important; max-height: 150px !important; min-height: 100px !important">
    </div>

    <div class="section">
        <div class="container article">
            <table class="table table-hover caption-top">
                <caption>DANH SÁCH CUỘC THI</caption>
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" style="display: none;">Mã cuộc thi</th>
                        <th scope="col">Tên</th>
                        <th scope="col">Môn học</th>
                        <th scope="col">Ngày tạo</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($contests->num_rows > 0): 
                        $i = 1;
                        while($contest = $contests->fetch_assoc()): ?>
                            <tr>
                                <th scope="col"><?php echo $i++; ?></th>
                                <td scope="col"><?php echo $contest['ContestName']; ?></td>
                                <td scope="col"><?php echo $subjects[$contest['Subject']] ?? 'Không xác định'; ?></td>
                                <td scope="col"><?php echo $contest['CreateDate']; ?></td>
                                <td scope="col">
                                    <span class="badge <?php echo $contest['Status'] == 1 ? 'bg-success' : 'bg-danger'; ?>">
                                        <?php echo $contest['Status'] == 1 ? 'Đang hoạt động' : 'Không hoạt động'; ?>
                                    </span>
                                </td>
                                <td scope="col">
                                    <div class="action-buttons">
                                        <button class="btn btn-primary moreInfo-btn" data-contest-id="<?php echo $contest['ContestID']; ?>">
                                            <i class="bi bi-info-circle"></i><p>Thông tin</p>
                                        </button>
                                        <button class="btn btn-warning editContest-btn" onclick="window.location.href='contestEdit.php?contestID=<?php echo $contest['ContestID']; ?>'">
                                            <i class="bi bi-pen"></i><p>Sửa</p>
                                        </button>
                                        <button class="btn btn-danger deleteContest-btn" data-contest-id="<?php echo $contest['ContestID']; ?>">
                                            <i class="bi bi-trash"></i><p>Xóa</p>
                                        </button>
                                    </div>
                                    <div class="action-buttons">
                                        <button class="btn btn-secondary reviewContest-btn" data-contest-id="<?php echo $contest['ContestID']; ?>">
                                            <i class="bi bi-eye"></i><p>Xem</p>
                                        </button>
                                        <button class="btn btn-info getContestCode-btn" data-contest-id="<?php echo $contest['ContestID']; ?>" data-contest-code="<?php echo $contest['ContestCode']; ?>">
                                            <i class="bi bi-code-slash"></i><p>Lấy mã</p>
                                        </button>
                                        <button class="btn btn-info getStudentList-btn" onclick="window.location.href='contestStatistic.php?contestID=<?php echo $contest['ContestID']; ?>'">
                                            <i class="bi bi-list-ul"></i><p>Danh sách</p>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">Không có cuộc thi nào</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mb-4 container">
            <h4>Thêm Cuộc Thi</h4>
            <button class="btn btn-info" id="contestCreateRequest">
                <i class="bi bi-plus-circle"></i>
                Thêm Cuộc Thi Mới
            </button>
        </div>
    </div>

    <!-- Modal Thông tin cuộc thi -->
    <div class="mb-4 container position-fixed top-0 left-0 w-100 h-100" style="z-index: 1000; max-width: 100vw !important; max-height: 100vh !important; background: rgba(0,0,0,0.5); display: none;" id="contestInfo">
        <div class="card position-absolute top-50 start-50 translate-middle" style="width: 500px;">
            <div class="card-header fs-4 fw-bold">
                Thông tin cuộc thi
            </div>
            <div class="card-body" id="contestInfoBody">
                <h5 class="card-title fs-5">Special title treatment</h5>
                <p class="card-text fs-6">With supporting text below as a natural lead-in to additional content.</p>
                <button class="btn btn-primary" id="closeContestInfo">Đóng</button>
            </div>
        </div>
    </div>

    <script src="./js/contest.js"></script>
    <?php
        include 'footer.php';
        include 'javascript.php';
    ?>
</body>
</html>