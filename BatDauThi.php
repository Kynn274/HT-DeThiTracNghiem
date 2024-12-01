<?php
  include 'head.php';
?>
<body>
    <?php
        include 'header.php';
        $subjects = [
            'toan' => 'Toán',
            'anh' => 'Tiếng Anh',
            'ly' => 'Vật lý',
            'hoa' => 'Hóa học',
            'sinh' => 'Sinh học',
            'van' => 'Ngữ văn'
        ];

        if(isset($_GET['id'])){
            $contestID = $_GET['id'];
            $stmt = $conn->prepare("SELECT * FROM Contests WHERE ContestID = ?");
            $stmt->bind_param("i", $contestID);
            $stmt->execute();
            $contest = $stmt->get_result()->fetch_assoc();
        }
    ?>

    <!-- Add content here -->
    <div class="hero overlay" style="height: 150px !important; max-height: 150px !important; min-height: 100px !important">
    </div>

    <!-- Exam Participation Page -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-8 col-sm-12">
                <!-- Exam Details Card -->
                <div class="card shadow-lg rounded-lg border-0 mb-5" style="width: 70vw !important; max-width: 800px !important; min-width: 500px !important;"> <!-- Added mb-5 for margin-bottom -->
                    <div class="card-body">
                        <!-- Title Section -->
                        <h2 class="card-title text-center text-primary text-uppercase fw-bold mb-3"><?php echo $contest['ContestName']; ?></h2>
                        <p class="card-text text-muted text-center mb-4 fs-6 pt-2">
                            <i class="bi bi-calendar"></i><span class="fw-bold"> Ngày thi: </span>
                            <span><?php echo $contest['TestDate']; ?></span>
                        </p>
                        <p class="card-text text-muted text-center mb-4 fs-6">
                            <i class="bi bi-book"></i><span class="fw-bold"> Môn học: </span>
                            <span><?php echo $subjects[$contest['Subject']] ?? 'Không xác định'; ?></span>
                        </p>
                        <p class="card-text text-muted text-center mb-4 fs-6">
                            <i class="bi bi-clock"></i><span class="fw-bold"> Thời gian thi: </span>
                            <span><?php echo $contest['Longtime']; ?></span>
                        </p>
                        <p class="card-text text-muted text-center mb-4 fs-6 pb-2">
                            <i class="bi bi-people"></i><span class="fw-bold"> Số lượng câu hỏi: </span>
                            <span><?php echo $contest['TotalQuestions']; ?></span>
                        </p>

                        <!-- Start Exam Button Section -->
                        <div class="d-flex justify-content-center ">
                            <button id="startExamButton" class="btn btn-success rounded-pill px-5 py-3 btn-lg shadow-lg">Bắt đầu cuộc thi</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $('#startExamButton').on('click', function(){
                let userID = '<?php echo $_SESSION['user_id']; ?>';
                let contestID = '<?php echo $contestID; ?>';
                $.ajax({
                    url: 'process.php',
                    type: 'POST',
                    data: {
                    action: 'startExam',
                    userID: userID,
                        contestID: contestID
                    },
                    success: function(response){
                        console.log(response);
                        if(response.success){
                            window.location.href = 'ThamGiaThi.php?id=' + contestID;
                        }
                    },
                    error: function(response){
                        console.log(response);
                    }
                });
            });
        });
    </script>
    <?php
        include 'footer.php';
        include 'javascript.php';
    ?>
</body>
</html>
