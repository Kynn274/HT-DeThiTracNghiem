<?php
    include 'head.php';
?>
<body>
    <?php
        include 'header.php';
        
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
            <form method="POST" action="process_questions_bank.php">
                <div class="mb-3">
                    <label for="quesBankName" class="form-label">Tên ngân hàng câu hỏi <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="quesBankName" name="quesBankName" required>
                </div>
                <div class="mb-3">
                    <label for="subject" class="form-label">Môn học <span class="text-danger">*</span></label>
                    <select class="form-control" id="subject" name="subject" required>
                        <option value="">Chọn môn học</option>
                        <option value="toan">Toán học</option>
                        <option value="ly">Vật lý</option>
                        <option value="hoa">Hóa học</option>
                        <option value="sinh">Sinh học</option>
                        <option value="van">Ngữ văn</option>
                        <option value="anh">Tiếng Anh</option>
                    </select>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Lưu ngân hàng câu hỏi
                    </button>
                    <button type="button" class="btn btn-success" onclick="window.location.href='questionsAddition.php'">
                        <i class="bi bi-plus-circle"></i> Thêm câu hỏi
                    </button>
                </div>
            </form>
        </div>
        
        <div class="questionsTable">
            <table class="table table-hover caption-top">
                <caption>DANH SÁCH CÂU HỎI TRONG NGÂN HÀNG</caption>
                <thead>
                    <tr>
                        <th scope="col" width="5%">#</th>
                        <th scope="col" width="35%">Câu hỏi</th>
                        <th scope="col" width="10%">A</th>
                        <th scope="col" width="10%">B</th>
                        <th scope="col" width="10%">C</th>
                        <th scope="col" width="10%">D</th>
                        <!-- <th scope="col" width="10%">Hành động</th> -->
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <script src="./js/questionsBank.js"></script>
    <?php
        include 'footer.php';
        include 'javascript.php';
    ?>
</body>
</html>