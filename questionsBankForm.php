<?php
    include 'head.php';
?>
<body>
    <?php
        include 'header.php';
        $bankMode = $_SESSION['bankMode'];
        $questionsBankId = $_SESSION['questionsBankId'];
        if($bankMode == 'add'){
            $bankName = '';
            $subject = '';
        }else{
            $sql = "SELECT * FROM questionBanks WHERE QuestionBankID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $questionsBankId);
            $stmt->execute();
            $result = $stmt->get_result();
            $bank = $result->fetch_assoc();
            $bankName = $bank['QuestionBankName'];
            $subject = $bank['Subject'];
        }
    ?>
    <style>
        .filling-form{
            margin: 40px 10px;
        }
        .filling-form h3{
            margin: 30px 0;
            font-size: 25px;
            font-weight: bold;
        }
        .filling-form button{
            float: right;
            margin-left: 10px;
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
        margin: 50px auto;
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
    <div class="hero overlay inner-page">
		<img src="images/blob.svg" alt="" class="img-fluid blob">
		<div class="container">
			<div class="row align-items-center justify-content-center text-center pt-5">
				<div class="col-lg-6">
					<h1 class="heading text-white mb-3" data-aos="fade-up">NGÂN HÀNG CÂU HỎI</h1>
				</div>
			</div>
		</div>
	</div>

    <div class="container article">
        <div class="filling-form">
            <h3>THÔNG TIN NGÂN HÀNG CÂU HỎI</h3>
            <form method="POST" action="process.php">
                <div class="mb-3">
                    <label for="quesBankName" class="form-label">Tên ngân hàng câu hỏi <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="quesBankName" name="quesBankName" value="<?php echo $bankName; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="subject" class="form-label">Môn học <span class="text-danger">*</span></label>
                    <select class="form-control" id="subject" name="subject" required>
                        <option value="">Chọn môn học</option>
                        <?php
                        $subjects = [
                            'toan' => 'Toán học',
                            'ly' => 'Vật lý',
                            'hoa' => 'Hóa học',
                            'sinh' => 'Sinh học',
                            'van' => 'Ngữ văn',
                            'anh' => 'Tiếng Anh'
                        ];
                        
                        foreach($subjects as $key => $value) {
                            $selected = ($subject == $key) ? 'selected' : '';
                            echo "<option value='$key' $selected>$value</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="text-end">
                    <button type="submit" name="action" value="saveQuestionsBank" id="saveQuestionsBank" class="btn btn-primary">
                        <i class="bi bi-save"></i> Lưu ngân hàng câu hỏi
                    </button>
                </div>
            </form>
        </div>
        
    </div>
    <script src="./js/questionsBank.js"></script>
    <?php
        include 'footer.php';
        include 'javascript.php';
    ?>
</body>
</html>