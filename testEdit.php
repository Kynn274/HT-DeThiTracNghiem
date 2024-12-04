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
            margin-right: 15px;
            margin-left: auto;
            margin-top: 15px;
        }

        /* Button Styling */
        #contestEditSubmit {
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

        #contestEditSubmit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(65, 84, 241, 0.4);
        }

        #contestEditSubmit i {
            font-size: 1.2rem;
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

/* Text Gradient */
.text-gradient {
    background: linear-gradient(to right, #4facfe 0%, #00f2fe 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    font-weight: 600;
    font-size: 1.1rem;
}

/* Responsive */
@media (max-width: 768px) {
    .hero.inner-page {
        min-height: 280px;
    }
    
    .heading {
        font-size: 2rem !important;
    }
    
    .text-gradient {
        font-size: 1rem;
    }
    
    .shape {
        display: none;
    }
}
        .btn-outline-white-reverse {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
            border: 2px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .btn-outline-white-reverse:hover {
            background: white;
            border-color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
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
	<div class="hero inner-page">
		<div class="hero-background"></div>
		
		<!-- Floating Shapes -->
		<div class="shape shape-1"></div>
		<div class="shape shape-2"></div>
		<div class="shape shape-3"></div>
		
		<div class="container">
			<div class="hero-content">
				<span class="text-gradient d-block mb-2 text-center" data-aos="fade-up">Chỉnh Sửa Đề Thi</span>
				<h1 class="heading text-white mb-4 text-center" data-aos="fade-up" data-aos-delay="100" 
					style="font-size: 3rem; font-weight: 700;">Cập Nhật Đề Thi</h1>
				<p class="text-white-50 mb-0 text-center" data-aos="fade-up" data-aos-delay="200" 
				   style="font-size: 1.1rem;">
					Điều chỉnh và cập nhật thông tin đề thi của bạn
				</p>
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
