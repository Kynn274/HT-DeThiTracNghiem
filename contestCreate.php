<?php
	include 'head.php';
?>
<body>
	<?php
		include 'header.php';
	?>
    <style>
        :root {
            --primary-color: #4154f1;
            --secondary-color: #2c3cdd;
            --text-color: #1e293b;
            --border-color: #e9ecef;
        }

        /* Main Content Section */
        #content {
            padding: 40px 0;
            background: linear-gradient(135deg, #f6f9ff 0%, #f1f4ff 100%);
        }

        #content .container {
            max-width: 900px !important;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Form Styling */
        #contestForm {
            margin-top: 30px;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 25px;
        }

        .form-group {
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--text-color);
            font-weight: 500;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-group label i {
            color: var(--primary-color);
            font-size: 1.1rem;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid var(--border-color);
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(65, 84, 241, 0.1);
            outline: none;
        }

        /* Custom Select Styling */
        select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%234154f1' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            padding-right: 40px;
        }

        /* Difficulty Section */
        .difficulty-section {
            background: linear-gradient(135deg, rgba(65, 84, 241, 0.05), rgba(44, 60, 221, 0.05));
            padding: 25px;
            border-radius: 15px;
            margin: 30px 0;
            border: 1px solid rgba(65, 84, 241, 0.1);
        }

        .difficulty-title {
            color: var(--primary-color);
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .difficulty-title i {
            font-size: 1.2rem;
        }

        .total-questions {
            display: inline-block;
            padding: 8px 15px;
            background: rgba(65, 84, 241, 0.1);
            color: var(--primary-color);
            border-radius: 8px;
            font-weight: 500;
            /* float: right; */
            margin-right: 15px;
            margin-left: auto;
            margin-top: 15px;
        }

        /* Button Styling */
        #contestCreateSubmit {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            margin-top: 20px;
        }

        #contestCreateSubmit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(65, 84, 241, 0.4);
        }

        #contestCreateSubmit i {
            font-size: 1.2rem;
        }

        /* Number Input Styling */
        input[type="number"] {
            -moz-appearance: textfield;
        }

        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }

            #content .container {
                padding: 25px;
                margin: 15px;
            }

            .difficulty-section {
                padding: 20px;
            }
        }

        /* Custom Scrollbar */
        #content .container::-webkit-scrollbar {
            width: 6px;
        }

        #content .container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        #content .container::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 10px;
        }

        #content .container::-webkit-scrollbar-thumb:hover {
            background: var(--secondary-color);
        }

        /* Hero Section */
        .hero.inner-page, .hero.inner-page > .container > .row{
            min-height: 300px; 
            padding-top: 64px;
        }
        @media (max-width: 992px) {
            .hero.inner-page > .container > .row{
                min-height: 200px;
            }
        }

        .hero.overlay {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        }

        .hero .heading {
            font-size: 2.5rem;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        /* Form Title */
        h1 {
            color: var(--primary-color);
            font-size: 2rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 2rem;
            position: relative;
            padding-bottom: 15px;
        }

        h1:after {
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
    </style>
	<div class="hero overlay inner-page">
		<img src="images/blob.svg" alt="" class="img-fluid blob">
		<div class="container">
			<div class="row align-items-center justify-content-center pt-5">
				<div class="col-lg-6 text-center pe-lg-5">
					<h1 class="heading text-white mb-3" data-aos="fade-up">Tạo Cuộc Thi</h1>
					<div class="align-items-center mb-4" data-aos="fade-up" data-aos-delay="200">
						<a href="#content" class="btn btn-outline-white-reverse me-4">Bắt Đầu</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="section" id="content">
		<div class="container">
		<h1>Tạo Cuộc Thi</h1>
        <form id="contestForm">
            <div class="form-row">
                <div class="form-group">
                    <label for="examName">Tên cuộc thi:</label>
                    <input type="text" id="examName" name="examName" required>
                </div>
                <div class="form-group">
                    <label for="school">Trường:</label>
                    <input type="text" id="school" name="school">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="subject">Môn học:</label>
                    <select id="subject" name="subject" required>
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
                <div class="form-group">
                    <label for="duration">Thời gian làm bài (phút):</label>
                    <input type="number" id="duration" name="duration" min="15" max="180" value="60" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="examDate">Ngày làm bài:</label>
                    <input type="date" id="examDate" name="examDate" required>
                </div>
                <div class="form-group">
                    <label for="questionBank">Thư viện đề thi:</label>
                    <select id="questionBank" name="questionBank" required>
                        <option value="">-- Chọn thư viện --</option>
                        <?php
                            $sql = "SELECT * FROM QuestionBanks WHERE UserID = ?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("i", $_SESSION['user_id']);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while($row = $result->fetch_assoc()):
                        ?>
                            <option value="<?php echo $row['QuestionBankID']; ?>" data-total-questions="<?php echo $row['TotalNumber']; ?>"><?php echo $row['QuestionBankName']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="totalQuestions">Tổng số câu hỏi:</label>
                <input type="number" id="totalQuestions" name="totalQuestions" min="0" max="100" value="40" required onchange="updateDifficultyLimits()">
            </div>

            <div class="difficulty-section">
                <div class="difficulty-title">Phân bố độ khó</div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="easyQuestions">Số câu dễ:</label>
                        <input type="number" id="easyQuestions" name="easyQuestions" min="0" value="16" onchange="validateDifficultyDistribution()">
                    </div>
                    <div class="form-group">
                        <label for="mediumQuestions">Số câu trung bình:</label>
                        <input type="number" id="mediumQuestions" name="mediumQuestions" min="0" value="16" onchange="validateDifficultyDistribution()">
                    </div>
                    <div class="form-group">
                        <label for="hardQuestions">Số câu khó:</label>
                        <input type="number" id="hardQuestions" name="hardQuestions" min="0" value="8" onchange="validateDifficultyDistribution()">
                    </div>
                </div>
                <div class="total-questions" id="questionDistributionTotal" max-value="" value="">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="examMode">Chế độ tạo:</label>
                    <select id="examMode" name="examMode">
                        <option value="contest" selected>Cuộc thi</option>
                    </select>
                </div>
                <div class="form-group password-section" id="passwordSection">
                    <label for="password">Mật khẩu:</label>
                    <input type="password" id="password" name="password">
                </div>
                <div class="form-group testTimes-section" id="testTimesSection">
                    <label for="testTimes">Số lần thi:</label>
                    <input type="number" id="testTimes" name="testTimes" min="0" value="1" required>
                </div>
            </div>
        </form>
        <button class="btn" id="contestCreateSubmit">Tạo cuộc thi</button>

		</div>
	</div>
    <script src="./js/contest.js"></script>                            
	<?php
		include 'footer.php';
		include 'javascript.php';
	?>
</html>
