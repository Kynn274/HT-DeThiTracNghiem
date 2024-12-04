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
        :root {
            --primary-color: #4154f1;
            --secondary-color: #2c3cdd;
            --text-color: #1e293b;
            --border-color: #e9ecef;
        }

        /* Modal Styling */
        .modal-content {
            border: none;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            padding: 20px 30px;
        }

        .modal-header .modal-title {
            color: white;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .modal-header .btn-close {
            color: white;
            opacity: 0.8;
            transition: all 0.3s ease;
        }

        .modal-header .btn-close:hover {
            opacity: 1;
            transform: rotate(90deg);
        }

        .modal-body {
            padding: 30px;
        }

        /* Form Controls */
        .form-label {
            color: var(--text-color);
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 0.8rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-label i {
            color: var(--primary-color);
            font-size: 1.1rem;
        }

        .form-control {
            border: 2px solid var(--border-color);
            border-radius: 12px;
            padding: 12px 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(65, 84, 241, 0.1);
        }

        /* Select Styling */
        .form-select {
            border: 2px solid var(--border-color);
            border-radius: 12px;
            padding: 12px 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%234154f1' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        }

        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(65, 84, 241, 0.1);
        }

        /* Modal Footer */
        .modal-footer {
            border: none;
            padding: 20px 30px;
            gap: 10px;
        }

        /* Buttons */
        .btn {
            padding: 12px 25px;
            border-radius: 12px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn i {
            font-size: 1.2rem;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            color: white;
        }

        .btn-primary:hover {
            box-shadow: 0 5px 15px rgba(65, 84, 241, 0.3);
        }

        .btn-secondary {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            color: var(--text-color);
        }

        .btn-secondary:hover {
            background: #e9ecef;
            border-color: #dee2e6;
        }

        /* Animation */
        .modal.fade .modal-dialog {
            transform: scale(0.9);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .modal.show .modal-dialog {
            transform: scale(1);
            opacity: 1;
        }

        /* Form Groups */
        .form-group {
            margin-bottom: 1.5rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .modal-body {
                padding: 20px;
            }
            
            .btn {
                padding: 10px 20px;
            }
        }

        /* Main Content Section */
        .section {
            padding: 40px 0;
            background: linear-gradient(135deg, #f6f9ff 0%, #f1f4ff 100%);
        }

        /* Container Styling */
        .container.article {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            margin: 30px auto;
        }

        /* Form Section */
        .filling-form {
            max-width: 800px;
            margin: 0 auto;
        }

        .filling-form h3 {
            color: var(--primary-color);
            font-size: 1.8rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 2rem;
            position: relative;
            padding-bottom: 15px;
        }

        .filling-form h3:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 2px;
        }

        /* Form Groups */
        .mb-3 {
            margin-bottom: 1.8rem !important;
        }

        .form-label {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 0.8rem;
            font-weight: 600;
            color: var(--text-color);
        }

        .form-label i {
            color: var(--primary-color);
            font-size: 1.1rem;
        }

        .text-danger {
            color: #ef4444 !important;
        }

        /* Input Fields */
        .form-control {
            border: 2px solid var(--border-color);
            border-radius: 12px;
            padding: 12px 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(65, 84, 241, 0.1);
        }

        /* Select Field */
        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%234154f1' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            padding-right: 40px;
        }

        /* Submit Button */
        .text-end {
            margin-top: 2rem;
        }

        #saveQuestionsBank {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            padding: 12px 25px;
            border-radius: 12px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        #saveQuestionsBank:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(65, 84, 241, 0.3);
        }

        #saveQuestionsBank i {
            font-size: 1.2rem;
        }

        /* Hero Section Styling */
        .hero.inner-page {
            position: relative;
            background: linear-gradient(135deg, #4154f1 0%, #2c3cdd 100%);
            min-height: 350px;
            display: flex;
            align-items: center;
            overflow: hidden;
        }

        /* Background Animation */
        .hero-background {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            overflow: hidden;
        }

        .hero-background::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('images/grid.png');
            opacity: 0.1;
            animation: backgroundMove 20s linear infinite;
        }

        @keyframes backgroundMove {
            0% { transform: translateX(0) translateY(0); }
            100% { transform: translateX(-50%) translateY(-50%); }
        }

        /* Floating Shapes */
        .shape {
            position: absolute;
            opacity: 0.1;
        }

        .shape-1 {
            top: 10%;
            left: 10%;
            width: 100px;
            height: 100px;
            background: white;
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            animation: float 6s ease-in-out infinite;
        }

        .shape-2 {
            top: 60%;
            right: 10%;
            width: 150px;
            height: 150px;
            background: white;
            border-radius: 63% 37% 54% 46% / 55% 48% 52% 45%;
            animation: float 8s ease-in-out infinite;
        }

        .shape-3 {
            bottom: 10%;
            left: 30%;
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 41% 59% 41% 59% / 41% 59% 41% 59%;
            animation: float 7s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(10deg); }
        }

        /* Content Styling */
        .hero-content {
            position: relative;
            z-index: 1;
            text-align: center;
            padding: 0 15px;
        }

        .hero-title {
            color: white;
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.8s ease forwards;
        }

        .hero-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.2rem;
            font-weight: 500;
            margin-bottom: 2rem;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.8s ease 0.2s forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero.inner-page {
                min-height: 280px;
            }

            .hero-title {
                font-size: 2rem;
            }

            .hero-subtitle {
                font-size: 1rem;
            }

            .shape {
                display: none;
            }
        }
    </style>
    <div class="hero inner-page">
        <div class="hero-background"></div>
        
        <!-- Floating Shapes -->
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
        
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title" data-aos="fade-up">NGÂN HÀNG CÂU HỎI</h1>
                <p class="hero-subtitle" data-aos="fade-up" data-aos-delay="100">
                    Quản lý và tổ chức câu hỏi của bạn một cách hiệu quả
                </p>
            </div>
        </div>
    </div>
    <!-- Modal Form -->
    <div class="modal fade" id="questionsBankModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-folder-plus me-2"></i>
                        Thêm Ngân Hàng Câu Hỏi
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="questionsBankForm">
                        <div class="form-group">
                            <label for="questionsBankName">
                                <i class="bi bi-bookmark"></i>
                                Tên ngân hàng
                            </label>
                            <input type="text" class="form-control" id="questionsBankName" required>
                        </div>
                        <div class="form-group">
                            <label for="subject">
                                <i class="bi bi-book"></i>
                                Môn học
                            </label>
                            <select class="form-select" id="subject" required>
                                <option value="">-- Chọn môn học --</option>
                                <option value="toan">Toán</option>
                                <option value="ly">Vật lý</option>
                                <option value="hoa">Hóa học</option>
                                <option value="sinh">Sinh học</option>
                                <option value="anh">Tiếng Anh</option>
                                <option value="van">Ngữ văn</option>
                                <option value="su">Sử</option>
                                <option value="dia">Địa</option>
                                <option value="gdcd">GDCD</option>
                                <option value="tin">Tin học</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg"></i>
                        Hủy
                    </button>
                    <button type="button" class="btn btn-primary" id="questionsBankSubmit">
                        <i class="bi bi-check-lg"></i>
                        Xác nhận
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container article">
        <div class="filling-form">
            <h3>THÔNG TIN NGÂN HÀNG CÂU HỎI</h3>
            <form method="POST" action="process.php">
                <div class="mb-3">
                    <label for="quesBankName" class="form-label">
                        <i class="bi bi-bookmark-star"></i>
                        Tên ngân hàng câu hỏi 
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control" id="quesBankName" name="quesBankName" 
                           value="<?php echo $bankName; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="subject" class="form-label">
                        <i class="bi bi-book"></i>
                        Môn học 
                        <span class="text-danger">*</span>
                    </label>
                    <select class="form-control" id="subject" name="subject" required>
                        <option value="">-- Chọn môn học --</option>
                        <?php
                        $subjects = [
                            'toan' => 'Toán học',
                            'ly' => 'Vật lý',
                            'hoa' => 'Hóa học',
                            'sinh' => 'Sinh học',
                            'van' => 'Ngữ văn',
                            'anh' => 'Tiếng Anh',
                            'su' => 'Sử',
                            'dia' => 'Địa',
                            'gdcd' => 'GDCD',
                            'tin' => 'Tin học'
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
                        <i class="bi bi-save"></i>
                        Lưu ngân hàng câu hỏi
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