<?php
    include 'head.php';
?>
<style>
    /* body {
        font-family: Arial, sans-serif;
        background-color: #f3f7fa;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        margin: 0;
    } */

    body>.container {
        width: 100%;
        max-width: 800px;
        min-height: 500px;
        background-color: #ffffff;
        padding: 20px;
        margin: 15px auto;
    }

    h1 {
        margin-top: 50px;
        text-align: center;
        color: #003366;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table, th, td {
        border: 1px solid #cccccc;
        padding: 10px;
        text-align: center;
    }

    th {
        background-color: #007acc;
        color: white;
    }

    .no-history {
        text-align: center;
        color: #555;
        margin-top: 20px;
    }

    .export-btn {
        margin-top: 20px;
        padding: 10px 20px;
        background-color: #007acc;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 5px;
    }

    .export-btn:hover {
        background-color: #005f8c;
    }
</style>
<body>
    <?php
        include 'header.php';
    ?>
    <div class="hero overlay" style="height: 150px !important; max-height: 150px !important; min-height: 100px !important">
    </div>
    <div class="container">
        <h1>Lịch Sử Cuộc Thi</h1>
        
        <!-- Bảng hiển thị lịch sử cuộc thi -->
        <table id="historyTable">
            <thead>
                <tr>
                    <th>Tên Người Dùng</th>
                    <th>Tên Cuộc Thi</th>
                    <th>Thời Gian Tham Gia</th>
                    <th>Kết Quả (Điểm)</th>
                    <th>Xuất Excel</th>
                </tr>
            </thead>
            <tbody id="historyTableBody"></tbody>
        </table>

        <!-- Thông báo khi không có lịch sử -->
        <div id="noHistoryMessage" class="no-history" style="display: none;">
            Chưa có lịch sử cuộc thi nào được lưu.
        </div>
    </div>


    <?php
        include 'footer.php';
        include 'javascript.php';
    ?>
</body>
</html>

<!-- <script>
        // Lấy dữ liệu lịch sử cuộc thi từ localStorage
        const users = JSON.parse(localStorage.getItem("users")) || [];
        const historyTableBody = document.getElementById("historyTableBody");
        const noHistoryMessage = document.getElementById("noHistoryMessage");

        // Kiểm tra nếu không có dữ liệu
        if (users.length === 0) {
            noHistoryMessage.style.display = "block";
        } else {
            let hasHistory = false;

            users.forEach(user => {
                if (user.contestHistory && user.contestHistory.length > 0) {
                    hasHistory = true;
                    user.contestHistory.forEach(contest => {
                        historyTableBody.innerHTML += `
                            <tr>
                                <td>${user.fullName}</td>
                                <td>${contest.name}</td>
                                <td>${contest.date}</td>
                                <td>${contest.result} điểm</td>
                            </tr>
                        `;
                    });
                }
            });

            // Hiển thị thông báo nếu không có lịch sử cuộc thi nào
            if (!hasHistory) {
                noHistoryMessage.style.display = "block";
            }
        }
    </script> -->
