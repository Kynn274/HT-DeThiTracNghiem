<?php
  include 'head.php';
?>
<body>
    <?php
        include 'header.php';
        $joiningContestID = 0;
        if(isset($_GET['id'])){
            $joiningContestID = intval($_GET['id']);
        }
        $sql = "SELECT * FROM JoiningContests WHERE JoiningContestID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $joiningContestID);
        $stmt->execute();
        $result = $stmt->get_result();
        $joiningContest = $result->fetch_assoc();
        $sql = "SELECT TotalQuestions FROM Contests WHERE ContestID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $joiningContest['ContestID']);
        $stmt->execute();
        $result = $stmt->get_result();
        $totalQuestions = $result->fetch_assoc();
    ?>

    <!-- Add content here -->
    <div class="hero overlay" style="height: 150px !important; max-height: 150px !important; min-height: 100px !important">
    </div>

    <!-- Exam Completion -->
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg rounded-lg border-0">
                    <div class="card-body text-center">
                        <h2 class="text-success">Hoàn thành cuộc thi.</h2>
                        
                        <!-- Total Time Spent -->
                        <h5 class="text-muted">Tổng thời gian làm bài: <span id="total-time">00:00</span></h5>

                        <p class="fs-6 mt-3 mb-3 text-danger">Bạn đã làm đúng <span id="correct-answer"><b><?php echo $joiningContest['CorrectAnswer']; ?> / <?php echo $totalQuestions['TotalQuestions']; ?></b></span> câu</p>
                        <div>
                            <a href="index.php" class="btn btn-primary rounded-pill px-4 py-2">Về trang chủ</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5"></div> <!-- Add space between the form and footer -->

    <?php
        include 'footer.php';
        include 'javascript.php';
    ?>
</body>
</html>
