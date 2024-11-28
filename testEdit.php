<?php
	include 'head.php';
?>
<body>
	<?php
		include 'header.php';
        if(isset($_GET['contestID'])){
            $contestID = $_GET['contestID'];
            $sql = "SELECT * FROM Contests WHERE ContestID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $contestID);
            $stmt->execute();
            $result = $stmt->get_result();
            $contest = $result->fetch_assoc();
        }
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
            display: none;
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
					<h1 class="heading text-white mb-3" data-aos="fade-up">Sửa Đề Thi</h1>
					<div class="align-items-center mb-4" data-aos="fade-up" data-aos-delay="200">
						<a href="#content" class="btn btn-outline-white-reverse me-4">Bắt Đầu</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="section" id="content">
		<div class="container">
		<h1>Sửa Đề Thi</h1>
        <form id="contestForm">
            <input type="hidden" id="editContestID" name="editContestID" value="<?php echo $contest['ContestID']; ?>">
            <div class="form-row">
                <div class="form-group">
                    <label for="editExamName">Tên đề thi:</label>
                    <input type="text" id="editExamName" name="editExamName" required value="<?php echo $contest['ContestName']; ?>">
                </div>
                <div class="form-group">
                    <label for="editSchool">Trường:</label>
                    <input type="text" id="editSchool" name="editSchool" value="<?php echo $contest['School']; ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="editSubject">Môn học:</label>
                    <select id="editSubject" name="editSubject" required>
                        <option value="">-- Chọn môn học --</option>
                        <option value="toan" <?php echo $contest['Subject'] == 'toan' ? 'selected' : ''; ?>>Toán</option>
                        <option value="ly" <?php echo $contest['Subject'] == 'ly' ? 'selected' : ''; ?>>Vật lý</option>
                        <option value="hoa" <?php echo $contest['Subject'] == 'hoa' ? 'selected' : ''; ?>>Hóa học</option>
                        <option value="sinh" <?php echo $contest['Subject'] == 'sinh' ? 'selected' : ''; ?>>Sinh học</option>
                        <option value="anh" <?php echo $contest['Subject'] == 'anh' ? 'selected' : ''; ?>>Tiếng Anh</option>
                        <option value="van" <?php echo $contest['Subject'] == 'van' ? 'selected' : ''; ?>>Ngữ văn</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="editDuration">Thời gian làm bài (phút):</label>
                    <input type="number" id="editDuration" name="editDuration" min="15" max="180" value="<?php echo $contest['Longtime']; ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="editExamDate">Ngày làm bài:</label>
                    <input type="date" id="editExamDate" name="editExamDate" required value="<?php echo $contest['TestDate']; ?>">
                </div>
                <div class="form-group">
                    <label for="editQuestionBank">Thư viện đề thi:</label>
                    <select id="editQuestionBank" name="editQuestionBank" required>
                        <option value="">-- Chọn thư viện --</option>
                        <?php
                            $sql = "SELECT * FROM QuestionBanks WHERE UserID = ?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("i", $_SESSION['user_id']);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while($row = $result->fetch_assoc()):
                        ?>
                            <option value="<?php echo $row['QuestionBankID']; ?>" data-total-questions="<?php echo $row['TotalNumber']; ?>" <?php echo $row['QuestionBankID'] == $contest['QuestionBankID'] ? 'selected' : ''; ?>><?php echo $row['QuestionBankName']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="editTotalQuestions">Tổng số câu hỏi:</label>
                <input type="number" id="editTotalQuestions" name="editTotalQuestions" min="0" max="100" value="<?php echo $contest['TotalQuestions']; ?>" required onchange="updateDifficultyLimits()">
            </div>

            <div class="difficulty-section">
                <div class="difficulty-title">Phân bố độ khó</div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="editEasyQuestions">Số câu dễ:</label>
                        <input type="number" id="editEasyQuestions" name="editEasyQuestions" min="0" value="<?php echo $contest['EasyQuestions']; ?>" onchange="validateDifficultyDistribution()">
                    </div>
                    <div class="form-group">
                        <label for="editMediumQuestions">Số câu trung bình:</label>
                        <input type="number" id="editMediumQuestions" name="editMediumQuestions" min="0" value="<?php echo $contest['MediumQuestions']; ?>" onchange="validateDifficultyDistribution()">
                    </div>
                    <div class="form-group">
                        <label for="editHardQuestions">Số câu khó:</label>
                        <input type="number" id="editHardQuestions" name="editHardQuestions" min="0" value="<?php echo $contest['HardQuestions']; ?>" onchange="validateDifficultyDistribution()">
                    </div>
                </div>
                <div class="total-questions" id="editQuestionDistributionTotal" max-value="" value="">         
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="editExamMode">Chế độ tạo:</label>
                    <select id="editExamMode" name="editExamMode">
                        <option value="pdf" selected>Đề thi</option>
                    </select>
                </div>
                <div class="form-group password-section" id="editPasswordSection">
                    <label for="editPassword">Mật khẩu:</label>
                    <input type="password" id="editPassword" name="editPassword" value="<?php echo $contest['ContestPassword']; ?>">
                </div>
                <div class="form-group testTimes-section" id="editTestTimesSection">
                    <label for="editTestTimes">Số lần thi:</label>
                    <input type="number" id="editTestTimes" name="editTestTimes" min="0" value="<?php echo $contest['TestTimes']; ?>" required>
                </div>
            </div>
        </form>
        <button class="btn" id="contestEditSubmit">Sửa đề thi</button>

		</div>
	</div>
    <script src="./js/testEdit.js"></script>
    <script src="./js/test.js"></script>                            
	<?php
		include 'footer.php';
		include 'javascript.php';
	?>
</html>
