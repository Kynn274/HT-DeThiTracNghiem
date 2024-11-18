<?php
  include 'head.php';
?>
<body>
  <?php
    include 'header.php';
  ?>
  <style>
    input[type="text"], input[type="password"] {
      border: none;
      background-color: transparent;
      width: fit-content;
      max-width: 100px;
    }
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f0f8ff;
        }
        h1 {
            text-align: center;
            color: #0077cc;
        }
        .btn {
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: #ffffff;
            background-color: #0077cc;
            font-size: 14px;
        }
        .btn:hover {
            background-color: #005fa3;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input, select, textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #cccccc;
            border-radius: 4px;
        }
        textarea {
            resize: vertical;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #cccccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #0077cc;
            color: #ffffff;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .action-buttons {
            display: flex;
            gap: 5px;
        }
        .btn-edit {
            background-color: #ffa500;
        }
        .btn-edit:hover {
            background-color: #cc8400;
        }
        .btn-delete {
            background-color: #dc3545;
        }
        .btn-delete:hover {
            background-color: #a82833;
        }
    </style>
  <div class="hero overlay inner-page">
    <img src="images/blob.svg" alt="" class="img-fluid blob">
    <div class="container">
      <div class="row align-items-center justify-content-center text-center pt-5">
        <div class="col-lg-6">
          <!-- <p data-aos="fade-up" class="meta">by <a href="#">Admin</a> &bullet; on <a href="#">Apr 4th, 2022</a> </p> -->
          <h1 class="heading text-white mb-3" data-aos="fade-up" data-aos-delay="100">QUẢN LÝ NGƯỜI DÙNG </h1>
        </div>
      </div>
    </div>
  </div>
</head>
<body>
    <h1>Quản Lý Câu Hỏi</h1>
    <div class="container">
        <!-- Form Thêm/Sửa -->
        <form id="questionForm">
            <div class="form-group">
                <label for="questionContent">Nội dung câu hỏi</label>
                <textarea id="questionContent" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="questionType">Loại câu hỏi</label>
                <select id="questionType" required>
                    <option value="" disabled selected>Chọn loại câu hỏi</option>
                    <option value="multiple-choice">Trắc nghiệm</option>
                    <option value="essay">Tự luận</option>
                </select>
            </div>
            <div class="form-group">
                <label for="questionLevel">Mức độ</label>
                <select id="questionLevel" required>
                    <option value="" disabled selected>Chọn mức độ</option>
                    <option value="easy">Dễ</option>
                    <option value="medium">Trung bình</option>
                    <option value="hard">Khó</option>
                </select>
            </div>
            <button type="submit" class="btn">Lưu câu hỏi</button>
        </form>

        <!-- Tìm kiếm và Lọc -->
        <div class="form-group">
            <label for="searchInput">Tìm kiếm câu hỏi</label>
            <input type="text" id="searchInput" placeholder="Nhập từ khóa...">
        </div>
        <div class="form-group">
            <label for="filterLevel">Lọc theo mức độ</label>
            <select id="filterLevel">
                <option value="">Tất cả</option>
                <option value="easy">Dễ</option>
                <option value="medium">Trung bình</option>
                <option value="hard">Khó</option>
            </select>
        </div>

        <!-- Danh sách câu hỏi -->
        <table id="questionTable">
            <thead>
                <tr>
                    <th>Nội dung</th>
                    <th>Loại</th>
                    <th>Mức độ</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <!-- Các câu hỏi sẽ được thêm động -->
            </tbody>
        </table>
    </div>

    <script>
        // Danh sách câu hỏi
        const questions = [];

        // Form
        const questionForm = document.getElementById("questionForm");
        const questionContent = document.getElementById("questionContent");
        const questionType = document.getElementById("questionType");
        const questionLevel = document.getElementById("questionLevel");

        // Bảng
        const questionTable = document.getElementById("questionTable").querySelector("tbody");

        // Tìm kiếm và lọc
        const searchInput = document.getElementById("searchInput");
        const filterLevel = document.getElementById("filterLevel");

        // Thêm hoặc chỉnh sửa câu hỏi
        questionForm.addEventListener("submit", function (e) {
            e.preventDefault();
            const newQuestion = {
                content: questionContent.value,
                type: questionType.value,
                level: questionLevel.value,
            };

            // Thêm vào danh sách
            questions.push(newQuestion);
            renderQuestions();

            // Reset form
            questionForm.reset();
        });

        // Hiển thị danh sách câu hỏi
        function renderQuestions() {
            questionTable.innerHTML = "";

            // Lọc và tìm kiếm
            const searchKeyword = searchInput.value.toLowerCase();
            const filterValue = filterLevel.value;

            const filteredQuestions = questions.filter((q) => {
                const matchesSearch = q.content.toLowerCase().includes(searchKeyword);
                const matchesFilter = filterValue ? q.level === filterValue : true;
                return matchesSearch && matchesFilter;
            });

            // Thêm vào bảng
            filteredQuestions.forEach((q, index) => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${q.content}</td>
                    <td>${q.type === "multiple-choice" ? "Trắc nghiệm" : "Tự luận"}</td>
                    <td>${q.level === "easy" ? "Dễ" : q.level === "medium" ? "Trung bình" : "Khó"}</td>
                    <td class="action-buttons">
                        <button class="btn btn-edit" onclick="editQuestion(${index})">Sửa</button>
                        <button class="btn btn-delete" onclick="deleteQuestion(${index})">Xóa</button>
                    </td>
                `;
                questionTable.appendChild(row);
            });
        }

        // Chỉnh sửa câu hỏi
        function editQuestion(index) {
            const question = questions[index];
            questionContent.value = question.content;
            questionType.value = question.type;
            questionLevel.value = question.level;
        }

        // Xóa câu hỏi
        function deleteQuestion(index) {
            if (confirm("Bạn có chắc muốn xóa câu hỏi này?")) {
                questions.splice(index, 1);
                renderQuestions();
            }
        }

        // Tìm kiếm và lọc
        searchInput.addEventListener("input", renderQuestions);
        filterLevel.addEventListener("change", renderQuestions);
    </script>
     <?php
        include 'footer.php';
        include 'javascript.php';
    ?>
</body>
</html>
