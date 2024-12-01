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
    <!-- Thông tin cuộc thi -->
    <div class="mb-4 container position-fixed top-0 left-0 w-100 h-100" style="z-index: 1000; max-width: 100vw !important; max-height: 100vh !important;" id="contestInfo">
            <div class="card position-absolute top-50 start-50 translate-middle" style="width: 500px; background-color: #fdfdfd; border-radius: 10px;">
                <div class="card-header fs-4 fw-bold">
                    Thông tin cuộc thi
                </div>
                <div class="card-body" id="contestInfoBody">
                    <h5 class="card-title fs-5">Special title treatment</h5>
                    <p class="card-text fs-6">With supporting text below as a natural lead-in to additional content.</p>
                    <button class="btn btn-primary" id="closeContestInfo">Đóng</button>
                </div>
            </div>
        </div>
    <script src="./js/contest.js"></script>
    <?php
        include 'footer.php';
        include 'javascript.php';
    ?>
</body>
</html>