<?php
  include 'head.php';
?>
<body>
    <?php
        include 'header.php';
        $sql = "SELECT * FROM questionbanks WHERE UserID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
    	  $stmt->execute();
        $questionsBanks = $stmt->get_result();
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

    /* Style cho bảng */
    .table {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
        margin-bottom: 0;
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
        position: sticky;
        top: 0;
        z-index: 1;
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

    .table caption {
        color: #2c3cdd;
        font-size: 1.8rem;
        font-weight: 600;
        margin-bottom: 20px;
        text-transform: uppercase;
        letter-spacing: 1px;
        position: sticky;
        top: 0;
        background-color: white;
        z-index: 2;
        padding: 10px 0;
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

    /* Container style */
    .container.article {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        max-height: 600px;
        overflow-y: auto;
        margin: 20px auto;
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

    /* Add Questions Bank Section */
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
    </style>
    <!-- Add content here -->
    <div class="hero overlay" style="height: 150px !important; max-height: 150px !important; min-height: 100px !important">
    </div>

    <div class="section">
        <div class="container article">
            <table class="table table-hover caption-top">
                <caption>DANH SÁCH NGÂN HÀNG CÂU HỎI</caption>
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" style="display: none;">Mã ngân hàng câu hỏi</th>
                        <th scope="col">Tên</th>
                        <th scope="col">Môn học</th>
                        <th scope="col">Ngày tạo</th>
                        <th scope="col">Số câu hỏi</th>
                        <th scope="col">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                      if($questionsBanks->num_rows > 0){
                        $i = 1;
                        while($questionBank = $questionsBanks->fetch_assoc()): ?>
                            <tr>
                              <th scope="col"><?php echo $i++; ?></th>
                              <td scope="col" style="display: none;">
                                <input type="hidden" id="questionBankID" value="<?php echo $questionBank['QuestionBankID']; ?>" disabled>
                              </td>
                              <td scope="col"><?php echo $questionBank['QuestionBankName']; ?></td>
                              <td scope="col"><?php echo $subjects[$questionBank['Subject']] ?? 'Không xác định'; ?></td>
                              <td scope="col"><?php echo $questionBank['CreateDate']; ?></td>
                              <td scope="col"><?php echo $questionBank['TotalNumber']; ?></td>
                              <td scope="col">
                                <div class="action-buttons">
                                  <button class="btn btn-success addQuestion-btn align-middle">
                                    <i class="bi bi-plus"></i><p class="align-middle m-0">Thêm câu hỏi</p>
                                  </button>
                                  <button class="btn btn-primary editQuestionsBank-btn align-middle">
                                    <i class="bi bi-pen"></i><p class="align-middle m-0">Sửa</p>
                                  </button>
                                  <button class="btn btn-danger deleteQuestionsBank-btn align-middle">
                                    <i class="bi bi-trash"></i><p class="align-middle m-0">Xóa</p>
                                  </button>
                                </div>
                              </td>
                            </tr>
                        <?php endwhile;
                      }else{
                        echo "<tr><td colspan='7' style='text-align: center;'>Không có ngân hàng câu hỏi nào</td></tr>";
                      }
                    ?>
                    
                </tbody>
            </table>
            
        </div>
        <!-- Quản lý câu hỏi trong thư viện -->
        <div class="mb-4 container">
            <h4>Thêm Ngân Hàng Câu Hỏi</h4>
            <button class="btn btn-info" id="addQuestionsBank">
                <i class="bi bi-plus-circle"></i>
                Thêm Ngân Hàng Câu Hỏi Mới
            </button>
        </div>
    </div>
    <script src="./js/questionsBank.js"></script>
    <?php
        include 'footer.php';
        include 'javascript.php';
    ?>
</body>
</html>