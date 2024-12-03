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
    input {
      border: none;
      background-color: transparent;
      width: fit-content;
      max-width: 100px;
    }
    .btn{
      padding: 10px 15px;
      height: 100%;
    }
    thead{
      background-color: #f8f9fa;
      text-align: center;
    }
    caption{
      font-size: 1.5rem;
      font-weight: bold;
    }
    td, th{
      vertical-align: middle;
    }
    tbody button i{
      font-size: 1rem;
      margin-right: 5px;
    }
    tbody button p{
      display: inline;
    }
    tbody button{
      margin: 5px;
    }
    
    @media (max-width: 1200px) {
      tbody button i{
        font-size: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0;
      }
      tbody button p{
        display: none;
      }
    }
    
    .container.article {
        max-height: 600px;
        overflow-y: auto;
        margin: 20px auto;
        border-radius: 8px;
        /* box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); */
    }

    /* Make the header sticky while scrolling */
    .table thead th {
        position: sticky;
        top: 0;
        background-color: #f8f9fa;
        z-index: 1;
    }
    td, th{
      text-align: center;
    }
    /* Custom scrollbar styling */
    .container.article::-webkit-scrollbar {
        width: 8px;
    }

    .container.article::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .container.article::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }

    .container.article::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Ensure the table caption stays above the scrollable area */
    .table caption {
        position: sticky;
        top: 0;
        background-color: white;
        z-index: 2;
        padding: 10px 0;
    }

    /* Ensure proper spacing */
    .table {
        margin-bottom: 0;
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
                              <th scope="col" style="text-align: center;"><?php echo $i++; ?></th>
                              <td scope="col" style="display: none;"><?php echo $contest['UserID']; ?></td>
                              <td scope="col"><?php echo $contest['FullName']; ?></td>
                              <td scope="col"><?php echo $contest['CreateDate']; ?></td>
                              <td scope="col"><?php echo $contest['SoLanThi']; ?></td>
                              <td scope="col"><?php echo $contest['CorrectAnswer']; ?> / <?php echo $contest['TotalQuestions']; ?></td>
                              <td scope="col">
                                <div class="row d-flex justify-content-center flex-row">
                                </div>
                                <div class="row d-flex justify-content-center flex-row">
                                    <button class="btn btn-info activateUser-btn col-5" data-user-id="<?php echo $contest['UserID']; ?>"><i class="bi bi-key"></i><p>Kích hoạt</p></button>
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