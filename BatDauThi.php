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
            'van' => 'Ngữ văn',
            'su' => 'Sử',
            'dia' => 'Địa',
            'gdcd' => 'GDCD',
            'tin' => 'Tin học'
        ];

        if(isset($_GET['id'])){
            $contestID = $_GET['id'];
            $stmt = $conn->prepare("SELECT * FROM Contests WHERE ContestID = ?");
            $stmt->bind_param("i", $contestID);
            $stmt->execute();
            $contest = $stmt->get_result()->fetch_assoc();
        }
    ?>

    <style>
        /* Hero Section */
        .hero.inner-page {
            position: relative;
            background: linear-gradient(135deg, #4154f1 0%, #2c3cdd 100%);
            min-height: 350px;
            display: flex;
            align-items: center;
            overflow: hidden;
        }

        .hero-background {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            overflow: hidden;
        }

        .hero-background::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('images/grid.png');
            opacity: 0.1;
            animation: backgroundMove 20s linear infinite;
        }

        /* Floating Shapes */
        .shape {
            position: absolute;
            opacity: 0.1;
        }

        .shape-1 {
            top: 10%;
            left: 10%;
            width: 100px;
            height: 100px;
            background: white;
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            animation: float 6s ease-in-out infinite;
        }

        .shape-2 {
            top: 60%;
            right: 10%;
            width: 150px;
            height: 150px;
            background: white;
            border-radius: 63% 37% 54% 46% / 55% 48% 52% 45%;
            animation: float 8s ease-in-out infinite;
        }

        .shape-3 {
            bottom: 10%;
            left: 30%;
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 41% 59% 41% 59% / 41% 59% 41% 59%;
            animation: float 7s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(10deg); }
        }

        /* Main Content */
        .exam-container {
            margin-top: -100px;
            position: relative;
            z-index: 10;
        }

        .exam-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: none;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .exam-header {
            background: linear-gradient(135deg, rgba(65, 84, 241, 0.05), rgba(44, 60, 221, 0.05));
            padding: 30px;
            text-align: center;
            border-bottom: 1px solid rgba(65, 84, 241, 0.1);
        }

        .exam-title {
            color: #2c3cdd;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .exam-info {
            padding: 30px;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background: white;
            border-radius: 12px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .info-item:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(65, 84, 241, 0.1);
        }

        .info-icon {
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(65, 84, 241, 0.1), rgba(44, 60, 221, 0.1));
            border-radius: 12px;
            font-size: 1.2rem;
            color: #4154f1;
        }

        .info-content {
            flex: 1;
        }

        .info-label {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 2px;
        }

        .info-value {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2c3cdd;
        }

        .start-exam-btn {
            background: linear-gradient(135deg, #4154f1, #2c3cdd);
            color: white;
            border: none;
            padding: 15px 40px;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            margin-top: 20px;
        }

        .start-exam-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(65, 84, 241, 0.3);
        }

        .start-exam-btn i {
            margin-right: 10px;
        }

        @media (max-width: 768px) {
            .exam-container {
                margin-top: -50px;
                padding: 0 15px;
            }

            .exam-title {
                font-size: 1.5rem;
            }

            .info-item {
                padding: 12px;
            }

            .info-icon {
                width: 35px;
                height: 35px;
                font-size: 1rem;
            }
        }

        .btn-action:hover {
            transform: translateY(-3px);
        }

        /* Modal Styling */
        .modal-content {
            border: none;
            border-radius: 15px;
            overflow: hidden;
        }

        .modal-header {
            background: linear-gradient(135deg, rgba(65, 84, 241, 0.05), rgba(44, 60, 221, 0.05));
            padding: 20px 30px;
        }

        .modal-title {
            color: #2c3cdd;
            font-weight: 600;
        }

        .modal-body {
            padding: 30px;
        }

        .modal-footer .btn {
            padding: 8px 20px;
            border-radius: 10px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .modal-footer .btn:hover {
            transform: translateY(-2px);
        }
    </style>

    <div class="hero inner-page">
        <div class="hero-background"></div>
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
        <div class="container">
            <div class="hero-content">
                <span class="text-gradient d-block mb-2 text-center" data-aos="fade-up">Bắt Đầu Thi</span>
                <h1 class="heading text-white mb-4 text-center" data-aos="fade-up" data-aos-delay="100" 
                    style="font-size: 3rem; font-weight: 700;">Thông Tin Cuộc Thi</h1>
                <p class="text-white-50 mb-0 text-center" data-aos="fade-up" data-aos-delay="200" 
                   style="font-size: 1.1rem;">
                    Vui lòng xem kỹ thông tin trước khi bắt đầu
                </p>
            </div>
        </div>
    </div>

    <div class="exam-container">
        <div class="container">
            <div class="exam-card">
                <div class="exam-header">
                    <h2 class="exam-title"><?php echo $contest['ContestName']; ?></h2>
                </div>
                <div class="exam-info">
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="bi bi-calendar-event"></i>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Ngày thi</div>
                            <div class="info-value"><?php echo $contest['TestDate']; ?></div>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="bi bi-book"></i>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Môn học</div>
                            <div class="info-value"><?php echo $subjects[$contest['Subject']] ?? 'Không xác định'; ?></div>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="bi bi-clock"></i>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Thời gian làm bài</div>
                            <div class="info-value"><?php echo $contest['Longtime']; ?> phút</div>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="bi bi-list-ol"></i>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Số câu hỏi</div>
                            <div class="info-value"><?php echo $contest['TotalQuestions']; ?> câu</div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button id="startExamButton" class="start-exam-btn">
                            <i class="bi bi-play-circle"></i>
                            Bắt đầu làm bài
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            // Thêm modal thông báo
            $('body').append(`
                <div class="modal fade" id="alertModal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header border-0">
                                <h5 class="modal-title">Thông báo</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                <i class="bi bi-exclamation-circle text-warning" style="font-size: 3rem;"></i>
                                <p class="mt-3" id="alertMessage"></p>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            </div>
                        </div>
                    </div>
                </div>
            `);

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
                        if(response.success){
                            window.location.href = 'ThamGiaThi.php?id=' + contestID;
                        }else{
                            $('#alertMessage').text(response.message);
                            new bootstrap.Modal($('#alertModal')).show();
                        }
                    },
                    error: function(response){
                        $('#alertMessage').text('Có lỗi xảy ra, vui lòng thử lại!');
                        new bootstrap.Modal($('#alertModal')).show();
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
