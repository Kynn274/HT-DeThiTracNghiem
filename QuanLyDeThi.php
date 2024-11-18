<?php
  include 'head.php';
?>
<body>
  <?php
    include 'header.php';
    $stmt = $conn->prepare("SELECT u.UserID, u.Username, u.Password, u.Type, u.JoiningDate, u.Status, ud.Evidence FROM Users u, UserDetails ud WHERE u.UserID = ud.UserID");
    $stmt->execute();
    $result = $stmt->get_result();
    $users = $result->fetch_all(MYSQLI_ASSOC);
  ?>
  <style>
    <style>
      input[type="text"], input[type="password"] {
      border: none;
      background-color: transparent;
      width: fit-content;
      max-width: 100px;
    }
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
</head>
<body>
<div class="hero overlay inner-page">
    <img src="images/blob.svg" alt="" class="img-fluid blob">
    <div class="container">
      <div class="row align-items-center justify-content-center text-center pt-5">
        <div class="col-lg-6">
          <!-- <p data-aos="fade-up" class="meta">by <a href="#">Admin</a> &bullet; on <a href="#">Apr 4th, 2022</a> </p> -->
          <h1 class="heading text-white mb-3" data-aos="fade-up" data-aos-delay="100">QUẢN LÝ ĐỀ THI/CUỘC THI </h1>
        </div>
      </div>
    </div>
  </div>

    <h1>Quản Lý Đề Thi/Cuộc Thi</h1>
    <div class="container">
        <!-- Form Thêm/Sửa Đề Thi -->
        <form id="examForm">
            <div class="form-group">
                <label for="examName">Tên Đề Thi</label>
                <input type="text" id="examName" required>
            </div>
            <div class="form-group">
                <label for="subject">Môn Học</label>
                <input type="text" id="subject" required>
            </div>
            <div class="form-group">
                <label for="duration">Thời gian làm bài (phút)</label>
                <input type="number" id="duration" required>
            </div>
            <div class="form-group">
                <label for="examDate">Ngày làm bài</label>
                <input type="date" id="examDate" required>
            </div>
            <div class="form-group">
                <label for="examLibrary">Thư viện đề thi</label>
                <select id="examLibrary" required>
                    <option value="" disabled selected>Chọn thư viện đề thi</option>
                    <option value="library1">Thư viện 1</option>
                    <option value="library2">Thư viện 2</option>
                </select>
            </div>
            <div class="form-group">
                <label for="questionCount">Số lượng câu hỏi</label>
                <input type="number" id="questionCount" required>
            </div>
            <div class="form-group">
                <label for="difficulty">Mức độ</label>
                <select id="difficulty" required>
                    <option value="" disabled selected>Chọn mức độ</option>
                    <option value="easy">Dễ</option>
                    <option value="medium">Trung bình</option>
                    <option value="hard">Khó</option>
                </select>
            </div>
            <div class="form-group">
                <label for="mode">Chế độ tạo</label>
                <select id="mode" required>
                    <option value="contest">Cuộc thi</option>
                    <option value="pdf">PDF</option>
                </select>
            </div>
            <div class="form-group" id="passwordGroup" style="display: none;">
                <label for="password">Mật khẩu (chỉ khi chọn 'Cuộc thi')</label>
                <input type="password" id="password">
            </div>
            <button type="submit" class="btn">Lưu Đề Thi</button>
        </form>

        <!-- Tìm kiếm và Lọc -->
        <div class="form-group">
            <label for="searchInput">Tìm kiếm đề thi</label>
            <input type="text" id="searchInput" placeholder="Nhập từ khóa...">
        </div>

        <!-- Danh sách đề thi -->
        <table id="examTable">
            <thead>
                <tr>
                    <th>Tên Đề Thi</th>
                    <th>Môn Học</th>
                    <th>Thời gian</th>
                    <th>Ngày làm bài</th>
                    <th>Thư viện</th>
                    <th>Số câu hỏi</th>
                    <th>Mức độ</th>
                    <th>Chế độ tạo</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <!-- Các đề thi sẽ được thêm động -->
            </tbody>
        </table>
    </div>

    <script>
        // Danh sách đề thi
        const exams = [];

        // Form
        const examForm = document.getElementById("examForm");
        const examName = document.getElementById("examName");
        const subject = document.getElementById("subject");
        const duration = document.getElementById("duration");
        const examDate = document.getElementById("examDate");
        const examLibrary = document.getElementById("examLibrary");
        const questionCount = document.getElementById("questionCount");
        const difficulty = document.getElementById("difficulty");
        const mode = document.getElementById("mode");
        const passwordGroup = document.getElementById("passwordGroup");
        const password = document.getElementById("password");

        // Bảng
        const examTable = document.getElementById("examTable").querySelector("tbody");

        // Tìm kiếm
        const searchInput = document.getElementById("searchInput");

        // Thêm hoặc chỉnh sửa đề thi
        examForm.addEventListener("submit", function (e) {
            e.preventDefault();
            const newExam = {
                name: examName.value,
                subject: subject.value,
                duration: duration.value,
                date: examDate.value,
                library: examLibrary.value,
                questionCount: questionCount.value,
                difficulty: difficulty.value,
                mode: mode.value,
                password: password.value,
            };

            // Thêm vào danh sách
            exams.push(newExam);
            renderExams();

            // Reset form
            examForm.reset();
            passwordGroup.style.display = "none"; // Ẩn mật khẩu khi form đã được reset
        });

        // Hiển thị danh sách đề thi
        function renderExams() {
            examTable.innerHTML = "";

            const searchKeyword = searchInput.value.toLowerCase();

            const filteredExams = exams.filter((e) => e.name.toLowerCase().includes(searchKeyword));

            filteredExams.forEach((e, index) => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${e.name}</td>
                    <td>${e.subject}</td>
                    <td>${e.duration} phút</td>
                    <td>${e.date}</td>
                    <td>${e.library}</td>
                    <td>${e.questionCount}</td>
                    <td>${e.difficulty}</td>
                    <td>${e.mode}</td>
                    <td class="action-buttons">
                        <button class="btn btn-edit" onclick="editExam(${index})">Sửa</button>
                        <button class="btn btn-delete" onclick="deleteExam(${index})">Xóa</button>
                    </td>
                `;
                examTable.appendChild(row);
            });
        }

        // Chỉnh sửa đề thi
        function editExam(index) {
            const exam = exams[index];
            examName.value = exam.name;
            subject.value = exam.subject;
            duration.value = exam.duration;
            examDate.value = exam.date;
            examLibrary.value = exam.library;
            questionCount.value = exam.questionCount;
            difficulty.value = exam.difficulty;
            mode.value = exam.mode;
            password.value = exam.password;

            if (exam.mode === 'contest') {
                passwordGroup.style.display = "block"; // Hiển thị trường mật khẩu
            } else {
                passwordGroup.style.display = "none";
            }
        }

        // Xóa đề thi
        function deleteExam(index) {
            if (confirm("Bạn có chắc muốn xóa đề thi này?")) {
                exams.splice(index, 1);
                renderExams();
            }
        }

        // Hiển thị mật khẩu khi chọn "Cuộc thi"
        mode.addEventListener("change", function () {
            if (mode.value === "contest") {
                passwordGroup.style.display = "block";
            } else {
                passwordGroup.style.display = "none";
            }
        });

        // Tìm kiếm đề thi
        searchInput.addEventListener("input", renderExams);
    </script>
     <?php
        include 'footer.php';
        include 'javascript.php';
    ?>


</body>
</html>
