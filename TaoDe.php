<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo Đề Thi/Cuộc Thi</title>
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
</head>
<body>
    <div class="container">
        <h1>Tạo Đề Thi/Cuộc Thi</h1>
        <form id="examForm" onsubmit="handleSubmit(event)">
            <div class="form-row">
                <div class="form-group">
                    <label for="examName">Tên đề thi:</label>
                    <input type="text" id="examName" name="examName" required>
                </div>
                <div class="form-group">
                    <label for="school">Trường:</label>
                    <input type="text" id="school" name="school" required>
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
                    <input type="datetime-local" id="examDate" name="examDate" required>
                </div>
                <div class="form-group">
                    <label for="questionBank">Thư viện đề thi:</label>
                    <select id="questionBank" name="questionBank" required>
                        <option value="">-- Chọn thư viện --</option>
                        <option value="bank1">Đề thi THPT Quốc gia</option>
                        <option value="bank2">Đề thi học kì</option>
                        <option value="bank3">Đề thi thử nghiệm</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="totalQuestions">Tổng số câu hỏi:</label>
                <input type="number" id="totalQuestions" name="totalQuestions" min="1" max="100" value="40" required onchange="updateDifficultyLimits()">
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
                <div class="total-questions" id="questionDistributionTotal">
                    Tổng: 40/40 câu
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="examMode">Chế độ tạo:</label>
                    <select id="examMode" name="examMode" required onchange="togglePasswordField()">
                        <option value="contest">Contest</option>
                        <option value="pdf">PDF</option>
                    </select>
                </div>
                <div class="form-group password-section" id="passwordSection">
                    <label for="password">Mật khẩu:</label>
                    <input type="password" id="password" name="password">
                </div>
            </div>

            <button type="submit" class="btn">Tạo đề thi</button>
        </form>
    </div>

    <script src="./js/createExam.js">
        // // Thiết lập giá trị mặc định cho ngày thi (ngày hiện tại)
        // document.getElementById('examDate').valueAsDate = new Date();

        // function togglePasswordField() {
        //     const examMode = document.getElementById('examMode').value;
        //     const passwordSection = document.getElementById('passwordSection');
        //     const passwordInput = document.getElementById('password');

        //     if (examMode === 'contest') {
        //         passwordSection.style.display = 'block';
        //         passwordInput.required = true;
        //     } else {
        //         passwordSection.style.display = 'none';
        //         passwordInput.required = false;
        //         passwordInput.value = '';
        //     }
        // }

        // function updateDifficultyLimits() {
        //     const total = parseInt(document.getElementById('totalQuestions').value);
        //     const easy = document.getElementById('easyQuestions');
        //     const medium = document.getElementById('mediumQuestions');
        //     const hard = document.getElementById('hardQuestions');

        //     // Cập nhật giới hạn cho từng loại
        //     [easy, medium, hard].forEach(input => {
        //         input.max = total;
        //         const currentVal = parseInt(input.value);
        //         if (currentVal > total) {
        //             input.value = Math.floor(total / 3);
        //         }
        //     });

        //     validateDifficultyDistribution();
        // }

        // function validateDifficultyDistribution() {
        //     const total = parseInt(document.getElementById('totalQuestions').value);
        //     const easy = parseInt(document.getElementById('easyQuestions').value) || 0;
        //     const medium = parseInt(document.getElementById('mediumQuestions').value) || 0;
        //     const hard = parseInt(document.getElementById('hardQuestions').value) || 0;
        //     const currentTotal = easy + medium + hard;

        //     const distributionTotal = document.getElementById('questionDistributionTotal');
        //     distributionTotal.textContent = `Tổng: ${currentTotal}/${total} câu`;
        //     distributionTotal.style.color = currentTotal === total ? 'var(--primary-color)' : 'var(--error-color)';

        //     return currentTotal === total;
        // }

        // function handleSubmit(event) {
        //     event.preventDefault();

        //     if (!validateDifficultyDistribution()) {
        //         alert('Tổng số câu hỏi phân bố không khớp với tổng số câu hỏi yêu cầu!');
        //         return;
        //     }

        //     // Thực hiện xử lý tạo đề thi
        //     const formData = new FormData(event.target);
        //     const data = Object.fromEntries(formData.entries());
            
        //     // Log dữ liệu để kiểm tra
        //     console.log('Dữ liệu đề thi:', data);
            
        //     // Có thể thêm code gửi dữ liệu lên server tại đây
        //     alert('Đề thi đã được tạo thành công!');
        // }

        // // Khởi tạo ban đầu
        // togglePasswordField();
        // validateDifficultyDistribution();
    </script>

    <?php
        include 'footer.php';
        include 'javascript.php';
    ?>
</body>
</html>