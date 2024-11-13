<!-- <?php
    // include 'head.php';
?>
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e6f2ff;
            color: #003366;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        body>.container {
            width: 100%;
            max-width: 600px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .create-contest-btn {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            background-color: #007acc;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
<body>
    <?php
        // include 'header.php';
    ?>
     <div class="hero overlay" style="height: 100px !important; max-height: 150px !important; min-height: 100px !important">
     </div>

    <div class="container">
        <h1>Tạo Cuộc Thi</h1>
        
        <form id="contestForm">
            <label for="contestName">Tên Cuộc Thi:</label>
            <input type="text" id="contestName" name="contestName" required></br>

            <label for="contestDate">Ngày và Giờ Bắt Đầu:</label>
            <input type="datetime-local" id="contestDate" name="contestDate" required></br>

            <label for="contestDate">Ngày và Giờ Kết Thúc:</label>
            <input type="datetime-local" id="contestDate" name="contestDate" required>

            <h3>Chọn Đề </h3>
            <div id="questionList"></div>

            <button type="submit" class="create-contest-btn">Tạo Cuộc Thi</button>
        </form>
    </div>

    <script>
        // Lấy bộ câu hỏi từ localStorage
        const questions = JSON.parse(localStorage.getItem("quizQuestions")) || [];

        // Hiển thị danh sách câu hỏi để người dùng chọn
        function displayQuestions() {
            const questionList = document.getElementById("questionList");
            questions.forEach((q, index) => {
                const questionDiv = document.createElement("div");
                questionDiv.innerHTML = `
                    <input type="checkbox" id="question${index}" name="selectedQuestions" value="${index}">
                    <label for="question${index}"><b>Câu ${index + 1}:</b> ${q.question}</label>
                    <ul>
                        ${q.options.map((opt, i) => `<li>${i + 1}. ${opt}</li>`).join("")}
                    </ul>
                `;
                questionList.appendChild(questionDiv);
            });
        }

        displayQuestions();

        // Xử lý khi nộp form
        document.getElementById("contestForm").onsubmit = function(event) {
            event.preventDefault();

            const contestName = document.getElementById("contestName").value;
            const contestDate = document.getElementById("contestDate").value;
            const selectedQuestionIndices = Array.from(document.querySelectorAll("input[name='selectedQuestions']:checked")).map(input => parseInt(input.value));

            if (!contestName || !contestDate || selectedQuestionIndices.length === 0) {
                alert("Vui lòng nhập đủ thông tin cuộc thi và chọn ít nhất một câu hỏi.");
                return;
            }

            const selectedQuestions = selectedQuestionIndices.map(index => questions[index]);

            const contestData = {
                name: contestName,
                date: contestDate,
                questions: selectedQuestions
            };

            console.log("Cuộc thi được tạo:", contestData);
            alert("Cuộc thi đã được tạo thành công!");

            document.getElementById("contestForm").reset();
            displayQuestions();
        };
    </script>
</body>
</html> -->
