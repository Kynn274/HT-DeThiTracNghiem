<?php
  include 'head.php';
?>
<body>
    <?php
        include 'header.php';
        $contestID = '';
        if(isset($_GET['contestID'])){
            $contestID = $_GET['contestID'];
        }
        $sql = "SELECT JoiningContests.JoiningContestID, JoiningContests.UserID, 
                UserDetails.FullName, JoiningContests.CreateDate, JoiningContests.CorrectAnswer, Contests.TotalQuestions,
                COUNT(JoiningContests.JoiningContestID) AS SoLanThi
                FROM JoiningContests, Users, UserDetails, Contests
                WHERE JoiningContests.ContestID = ? AND JoiningContests.UserID = Users.UserID AND JoiningContests.UserID = UserDetails.UserID AND JoiningContests.ContestID = Contests.ContestID
                GROUP BY JoiningContests.UserID, UserDetails.FullName, JoiningContests.CreateDate, JoiningContests.JoiningContestID";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $contestID);
        $stmt->execute();
        $contestStatistic = $stmt->get_result();
    ?>
    <style>
    :root {
        --primary-color: #4154f1;
        --secondary-color: #2c3cdd;
        --text-color: #1e293b;
        --border-color: #e9ecef;
    }

    /* Main Content Section */
    .section {
        padding: 40px 0;
        background: linear-gradient(135deg, #f6f9ff 0%, #f1f4ff 100%);
    }

    /* Table Container */
    .container.article {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        max-height: 600px;
        overflow-y: auto;
        margin: 20px auto;
    }

    /* Table Styling */
    .table {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
        margin-bottom: 0;
    }

    .table thead {
        background: linear-gradient(135deg, #4154f1, #2c3cdd);
        color: white;
    }

    .table thead th {
        font-weight: 500;
        letter-spacing: 0.5px;
        padding: 15px;
        border: none;
        text-align: center;
        position: sticky;
        top: 0;
        z-index: 1;
    }

    .table tbody tr {
        transition: all 0.3s ease;
    }

    .table tbody tr:hover {
        background-color: #f8f9ff;
        transform: scale(1.01);
    }

    .table tbody td {
        padding: 12px 15px;
        vertical-align: middle;
        border-bottom: 1px solid #edf2f9;
        text-align: center;
    }

    .table caption {
        color: var(--primary-color);
        font-size: 1.8rem;
        font-weight: 600;
        margin-bottom: 20px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        justify-content: center;
    }

    .action-buttons .btn {
        flex: 1;
        min-width: 120px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        padding: 8px 15px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .action-buttons .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(65, 84, 241, 0.2);
    }

    .action-buttons .btn i {
        font-size: 1.1rem;
    }

    /* Export Section */
    .mb-4.container {
        background: white;
        border-radius: 15px;
        padding: 25px;
        margin-top: 20px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }

    .mb-4.container h4 {
        color: var(--primary-color);
        margin-bottom: 15px;
        font-weight: 600;
    }

    #exportResult {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 8px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    #exportResult:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(65, 84, 241, 0.2);
    }

    /* Modal Styling */
    .modal-content {
        border: none;
        border-radius: 20px;
        overflow: hidden;
    }

    .modal-header {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        border: none;
        padding: 15px 25px;
    }

    .modal-body {
        padding: 25px;
    }

    .modal-footer {
        border: none;
        padding: 15px 25px;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border: none;
    }

    /* Custom Scrollbar */
    .container.article::-webkit-scrollbar {
        width: 6px;
    }

    .container.article::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .container.article::-webkit-scrollbar-thumb {
        background: var(--primary-color);
        border-radius: 10px;
    }

    .container.article::-webkit-scrollbar-thumb:hover {
        background: var(--secondary-color);
    }

    /* Hero Section */
    .hero.overlay {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        tbody button i {
            font-size: 1.2rem;
            margin: 0;
        }
        
        tbody button p {
            display: none;
        }

        .action-buttons .btn {
            min-width: auto;
            padding: 8px;
        }
    }

    /* Preview Table */
    .table-bordered {
        border-radius: 10px;
        overflow: hidden;
    }

    .table-success {
        background-color: rgba(16, 185, 129, 0.1) !important;
    }

    .table-warning {
        background-color: rgba(245, 158, 11, 0.1) !important;
    }

    .table-danger {
        background-color: rgba(239, 68, 68, 0.1) !important;
    }

    .text-success {
        color: #10b981 !important;
    }

    .text-danger {
        color: #ef4444 !important;
    }
    </style>
    <!-- Add content here -->
    <div class="hero overlay" style="height: 150px !important; max-height: 150px !important; min-height: 100px !important">
    </div>

    <div class="section">
        <div class="container article">
            <table class="table table-hover caption-top">
                <caption>DANH SÁCH THAM GIA CUỘC THI</caption>
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" style="display: none;">Mã học sinh</th>
                        <th scope="col">Tên</th>
                        <th scope="col">Ngày thi</th>
                        <th scope="col">Số lần thi</th>
                        <th scope="col">Kết quả</th>
                        <th scope="col">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                      if($contestStatistic->num_rows > 0){
                        $i = 1;
                        while($contest = $contestStatistic->fetch_assoc()): ?>
                            <tr>
                              <th scope="col align-middle" style="text-align: center;"><?php echo $i++; ?></th>
                              <td scope="col" style="display: none;"><?php echo $contest['UserID']; ?></td>
                              <td scope="col"><?php echo $contest['FullName']; ?></td>
                              <td scope="col"><?php echo $contest['CreateDate']; ?></td>
                              <td scope="col"><?php echo $contest['SoLanThi']; ?></td>
                              <td scope="col"><?php echo $contest['CorrectAnswer']; ?> / <?php echo $contest['TotalQuestions']; ?></td>
                              <td scope="col">
                                <div class="row d-flex justify-content-center flex-row">
                                </div>
                                <div class="row d-flex justify-content-center flex-row">
                                    <button class="btn btn-info activateUser-btn col-5 align-middle" data-user-id="<?php echo $contest['UserID']; ?>"><i class="bi bi-key"></i><p class="align-middle m-0">Kích hoạt</p></button>
                                </div>
                              </td>
                            </tr>
                        <?php endwhile;
                      }else{
                        echo "<tr><td colspan='8' style='text-align: center;'>Không có ngân hàng câu hỏi nào</td></tr>";
                      }
                    ?>
                    
                </tbody>
            </table>
            
        </div>
        <!-- Xuất kết quả -->
        <div class="mb-4 container">
            <h4>Xuất kết quả</h4>
            <button class="btn btn-info" id="exportResult">Xuất kết quả</button>
        </div>
        
    </div>
    <!-- Modal Preview -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewModalLabel">Xem trước kết quả</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <!-- Header sẽ được thêm bằng JavaScript -->
                            </thead>
                            <tbody id="previewData">
                                <!-- Data sẽ được thêm bằng JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="downloadBtn">Tải xuống</button>
                </div>
            </div>
        </div>
    </div>
    <style>
    .modal-dialog {
        max-width: 95%;
    }
    .table th, .table td {
        text-align: center;
        vertical-align: middle;
        white-space: nowrap;
        padding: 0.5rem;
    }
    .text-success {
        font-weight: bold;
    }
    .text-danger {
        font-weight: bold;
    }
    </style>
    <!-- <script src="./js/contest.js"></script> -->
    <script>
      const contestID = <?php echo $contestID; ?>;
      $('.activateUser-btn').on('click', function(){
        const userID = $(this).data('user-id');
        $.ajax({
          url: 'process.php',
          method: 'POST',
          data: {
            userID: userID, 
            contestID: contestID, 
            action: 'moreTestTimes'
          },
          success: function(response){
            alert('Kích hoạt thành công');
          },
          error: function(xhr, status, error){
            alert('Kích hoạt thất bại');
          }
        });
      });

      $('#exportResult').on('click', function(){
        $.ajax({
            url: 'process.php',
            method: 'POST',
            data: {
                action: 'previewContestResult',
                contestID: contestID
            },
            success: function(response) {
                console.log(response);
                if(response.success) {
                    let html = '';
                    // Tạo header với các câu hỏi
                    let headerHtml = `
                        <tr>
                            <th>STT</th>
                            <th>Họ và tên</th>
                            <th>Ngày thi</th>
                            <th>Kết quả chung</th>
                            <th>Điểm</th>
                    `;
                    
                    // Thêm các cột câu hỏi vào header
                    if(response.data[0] && response.data[0].QuestionAndAnswer) {
                        response.data[0].QuestionAndAnswer.forEach((qa, idx) => {
                            headerHtml += `<th>Câu ${idx + 1}</th>`;
                        });
                    }
                    headerHtml += '</tr>';
                    
                    // Thêm dữ liệu học sinh và kết quả
                    response.data.forEach((row, index) => {
                        const score = (row.CorrectAnswer / row.TotalQuestions) * 100;
                        let rowClass = '';
                        if(score >= 80) rowClass = 'table-success';
                        else if(score >= 50) rowClass = 'table-warning';
                        else rowClass = 'table-danger';
                        
                        html += `
                            <tr class="${rowClass}">
                                <td>${index + 1}</td>
                                <td>${row.FullName}</td>
                                <td>${row.LastAttemptDate}</td>
                                <td>${row.CorrectAnswer} / ${row.TotalQuestions} câu</td>
                                <td>${score.toFixed(2)}</td>
                        `;
                        
                        // Thêm kết quả đúng/sai cho từng câu
                        row.QuestionAndAnswer.forEach(qa => {
                            html += `<td>${qa.IsCorrect == 1 ? 
                                '<span class="text-success">Đúng</span>' : 
                                '<span class="text-danger">Sai</span>'}</td>`;
                        });
                        
                        html += '</tr>';
                    });
                    
                    // Cập nhật bảng
                    $('#previewModal thead').html(headerHtml);
                    $('#previewData').html(html);
                    $('#previewModal').modal('show');
                } else {
                    alert('Có lỗi xảy ra khi tải dữ liệu');
                }
            },
            error: function() {
                alert('Có lỗi xảy ra khi tải dữ liệu');
            }
        });
      });

      $('#downloadBtn').on('click', function(){
        // Tạo form ẩn để submit
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'process.php';
        
        // Thêm các input hidden
        const actionInput = document.createElement('input');
        actionInput.type = 'hidden';
        actionInput.name = 'action';
        actionInput.value = 'exportContestResult';
        
        const contestInput = document.createElement('input');
        contestInput.type = 'hidden';
        contestInput.name = 'contestID';
        contestInput.value = contestID;
        
        form.appendChild(actionInput);
        form.appendChild(contestInput);
        
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
        
        $('#previewModal').modal('hide');
      });
    </script>
    <?php
        include 'footer.php';
        include 'javascript.php';
    ?>
    
</body>
</html>