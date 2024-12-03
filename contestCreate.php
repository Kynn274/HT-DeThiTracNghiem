<?php
	include 'head.php';
?>
<body>
	<?php
		include 'header.php';
	?>
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #1e40af;
            --background-color: #f0f9ff;
            --text-color: #1e293b;
            --border-color: #bfdbfe;
            --error-color: #ef4444;
        }

        /* body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
        } */

        body>.container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        }

        h1 {
            text-align: center;
            color: var(--primary-color);
            font-size: 2rem;
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-row {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .form-row > * {
            flex: 1;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--text-color);
        }

        select, input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-size: 1rem;
            transition: all 0.2s;
        }

        select:focus, input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .difficulty-section {
            background-color: #f8fafc;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }

        .difficulty-title {
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }

        .password-section {
            display: block;
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .btn {
            display: block;
            width: 100%;
            padding: 1rem;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn:hover {
            background-color: var(--secondary-color);
        }

        .error {
            color: var(--error-color);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .total-questions {
            text-align: right;
            font-weight: 500;
            margin-top: 0.5rem;
            color: var(--primary-color);
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
    <script src="./js/createExam.js"></script>
    <script src="./js/contest.js"></script>                            
	<?php
		include 'footer.php';
		include 'javascript.php';
	?>
</html>
