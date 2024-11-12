<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ContestOnline</title>
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

        .container {
            width: 100%;
            max-width: 600px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #003366;
        }

        .question-block {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #b3d1ff;
            border-radius: 8px;
            background-color: #f0f8ff;
        }

        .question-block h3 {
            color: #004080;
            margin-bottom: 10px;
        }

        .question-block input[type="text"] {
            width: calc(100% - 10px);
            padding: 5px;
            margin-bottom: 10px;
            border: 1px solid #b3d1ff;
            border-radius: 4px;
        }

        .add-option-btn {
            background-color: #007acc;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        .add-option-btn:hover {
            background-color: #005999;
        }

        .remove-btn {
            color: #cc0000;
            cursor: pointer;
            margin-left: 10px;
            font-size: 0.9em;
        }

        .add-question-btn,
        .submit-btn {
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
            transition: background-color 0.3s ease;
        }

        .add-question-btn:hover,
        .submit-btn:hover {
            background-color: #005999;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tạo Đề Thi</h1>
        <form id="quizForm">
            <!-- Nơi thêm các câu hỏi -->
            <div id="questionContainer"></div>

            <!-- Nút thêm câu hỏi -->
            <button type="button" class="add-question-btn" onclick="addQuestion()">Thêm Câu Hỏi</button>
            <!-- Nút lưu đề thi -->
            <button type="submit" class="submit-btn">Lưu Đề Thi</button>
        </form>
    </div>

    <script>
        // Hàm thêm một câu hỏi mới
        function addQuestion() {
            const questionContainer = document.getElementById("questionContainer");

            // Tạo một div cho mỗi câu hỏi
            const questionBlock = document.createElement("div");
            questionBlock.className = "question-block";

            // Tạo trường nhập câu hỏi
            const questionInput = document.createElement("input");
            questionInput.type = "text";
            questionInput.placeholder = "Nhập nội dung câu hỏi";
            questionInput.name = "questions[]";
            questionBlock.appendChild(questionInput);

            // Tạo danh sách các đáp án
            const optionsContainer = document.createElement("div");
            optionsContainer.className = "options-container";
            questionBlock.appendChild(optionsContainer);

            // Hàm thêm một đáp án
            function addOption() {
                const optionDiv = document.createElement("div");

                const optionInput = document.createElement("input");
                optionInput.type = "text";
                optionInput.placeholder = "Nhập đáp án";
                optionInput.name = "options[]";

                const correctOption = document.createElement("input");
                correctOption.type = "radio";
                correctOption.name = "correctOption";
                correctOption.value = optionInput.value;

                const removeBtn = document.createElement("span");
                removeBtn.textContent = "Xóa";
                removeBtn.className = "remove-btn";
                removeBtn.onclick = function() {
                    optionDiv.remove();
                };

                optionDiv.appendChild(optionInput);
                optionDiv.appendChild(correctOption);
                optionDiv.appendChild(removeBtn);
                optionsContainer.appendChild(optionDiv);
            }

            // Nút thêm đáp án
            const addOptionBtn = document.createElement("button");
            addOptionBtn.type = "button";
            addOptionBtn.textContent = "Thêm đáp án";
            addOptionBtn.className = "add-option-btn";
            addOptionBtn.onclick = addOption;
            questionBlock.appendChild(addOptionBtn);

            // Thêm questionBlock vào questionContainer
            questionContainer.appendChild(questionBlock);
        }

        // Xử lý sự kiện submit để lưu đề thi
        document.getElementById("quizForm").onsubmit = function(event) {
            event.preventDefault();
            alert("Đề thi đã được lưu!");
        };
    </script>
</body>
</html>
