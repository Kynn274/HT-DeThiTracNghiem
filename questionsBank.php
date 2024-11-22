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
          'van' => 'Ngữ văn'
        ];
       
    ?>
    <style>
    input {
      border: none;
      background-color: transparent;
      width: fit-content;
      max-width: 100px;
    }
    .btn{
      padding: 10px 15px;
      height: 100%;
    }
    thead{
      background-color: #f8f9fa;
      text-align: center;
    }
    caption{
      font-size: 1.5rem;
      font-weight: bold;
    }
    td, th{
      vertical-align: middle;
    }
    tbody button i{
      font-size: 1rem;
      margin-right: 5px;
    }
    tbody button p{
      display: inline;
    }
    tbody button{
      margin: 5px;
    }
    
    @media (max-width: 1200px) {
      tbody button i{
        font-size: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0;
      }
      tbody button p{
        display: none;
      }
    }
    
    .container.article {
        max-height: 600px;
        overflow-y: auto;
        margin: 20px auto;
        border-radius: 8px;
        /* box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); */
    }

    /* Make the header sticky while scrolling */
    .table thead th {
        position: sticky;
        top: 0;
        background-color: #f8f9fa;
        z-index: 1;
    }
    td, th{
      text-align: center;
    }
    /* Custom scrollbar styling */
    .container.article::-webkit-scrollbar {
        width: 8px;
    }

    .container.article::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .container.article::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }

    .container.article::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Ensure the table caption stays above the scrollable area */
    .table caption {
        position: sticky;
        top: 0;
        background-color: white;
        z-index: 2;
        padding: 10px 0;
    }

    /* Ensure proper spacing */
    .table {
        margin-bottom: 0;
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
                              <th scope="col" style="text-align: center;"><?php echo $i++; ?></th>
                              <td scope="col" style="display: none;"><input type="text" id="questionBankID" value="<?php echo $questionBank['QuestionBankID']; ?>" disabled></td>
                              <td scope="col"><?php echo $questionBank['QuestionBankName']; ?></td>
                              <td scope="col"><?php echo $subjects[$questionBank['Subject']] ?? 'Không xác định'; ?></td>
                              <td scope="col"><?php echo $questionBank['CreateDate']; ?></td>
                              <td scope="col"><?php echo $questionBank['TotalNumber']; ?></td>
                              <td scope="col">
                                <button class="btn btn-success addQuestion-btn" value=""><i class="bi bi-plus"></i><p>Thêm câu hỏi</p></button>
                                <button class="btn btn-primary editQuestionsBank-btn" value=""><i class="bi bi-pen"></i><p>Sửa</p></button>
                                <button class="btn btn-danger deleteQuestionsBank-btn" value=""><i class="bi bi-trash"></i><p>Xóa</p></button>
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
            <button class="btn btn-info" id="addQuestionsBank">Thêm Ngân Hàng Câu Hỏi</button>
        </div>
    </div>
    <script src="./js/questionsBank.js"></script>
    <?php
        include 'footer.php';
        include 'javascript.php';
    ?>
</body>
</html>