<?php
    include 'head.php';
?>
<body>
    <?php
        include 'header.php';
        if(isset($_GET['id'])){
            $joiningContestID = $_GET['id'];
            $sql = "SELECT jc.*, c.ContestName, c.TotalQuestions, ud.Fullname 
                   FROM JoiningContests jc 
                   INNER JOIN Contests c ON jc.ContestID = c.ContestID 
                   INNER JOIN UserDetails ud ON jc.UserID = ud.UserID 
                   WHERE jc.JoiningContestID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $joiningContestID);
            $stmt->execute();
            $result = $stmt->get_result();
            $contestResult = $result->fetch_assoc();
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

        /* Result Section */
        .result-container {
            margin-top: -100px;
            position: relative;
            z-index: 10;
            padding: 0 20px;
        }

        .result-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: none;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 800px;
            margin: 0 auto;
        }

        .result-header {
            background: linear-gradient(135deg, rgba(65, 84, 241, 0.05), rgba(44, 60, 221, 0.05));
            padding: 30px;
            text-align: center;
            border-bottom: 1px solid rgba(65, 84, 241, 0.1);
        }

        .result-title {
            color: #2c3cdd;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .result-subtitle {
            color: #6c757d;
            font-size: 1.1rem;
        }

        .result-body {
            padding: 40px;
        }

        .result-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
            margin-bottom: 40px;
        }

        .info-item {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .info-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .info-label {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .info-value {
            color: #2c3cdd;
            font-size: 1.8rem;
            font-weight: 700;
        }

        .score-circle {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4154f1, #2c3cdd);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
            font-weight: 700;
            margin: 0 auto 30px;
            position: relative;
            box-shadow: 0 10px 30px rgba(65, 84, 241, 0.3);
        }

        .score-circle::after {
            content: 'Điểm số';
            position: absolute;
            bottom: -30px;
            font-size: 1.1rem;
            font-weight: 500;
            color: #6c757d;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 40px;
        }

        .btn-action {
            padding: 12px 30px;
            border-radius: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-action:hover {
            transform: translateY(-3px);
        }

        .btn-review {
            background: linear-gradient(135deg, #4154f1, #2c3cdd);
            color: white;
            border: none;
        }

        .btn-review:hover {
            box-shadow: 0 8px 25px rgba(65, 84, 241, 0.3);
        }

        @media (max-width: 768px) {
            .result-container {
                margin-top: -50px;
            }

            .result-info {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .score-circle {
                width: 150px;
                height: 150px;
                font-size: 2.5rem;
            }
        }
    </style>

    <div class="hero inner-page">
        <div class="hero-background"></div>
        <div class="container">
            <div class="hero-content">
                <span class="text-gradient d-block mb-2 text-center" data-aos="fade-up">Kết Thúc Bài Thi</span>
                <h1 class="heading text-white mb-4 text-center" data-aos="fade-up" data-aos-delay="100" 
                    style="font-size: 3rem; font-weight: 700;">Kết Quả Bài Thi</h1>
                <p class="text-white-50 mb-0 text-center" data-aos="fade-up" data-aos-delay="200" 
                   style="font-size: 1.1rem;">
                    Xem kết quả chi tiết bài thi của bạn
                </p>
            </div>
        </div>
    </div>

    <div class="result-container">
        <div class="result-card">
            <div class="result-header">
                <h2 class="result-title"><?php echo $contestResult['ContestName']; ?></h2>
                <p class="result-subtitle">Thí sinh: <?php echo $contestResult['Fullname']; ?></p>
            </div>
            <div class="result-body">
                <div class="score-circle">
                    <?php 
                        $score = ($contestResult['CorrectAnswer'] / $contestResult['TotalQuestions']) * 10;
                        echo number_format($score, 1);
                    ?>
                </div>

                <div class="result-info">
                    <div class="info-item">
                        <div class="info-label">Số câu đúng</div>
                        <div class="info-value"><?php echo $contestResult['CorrectAnswer']; ?>/<?php echo $contestResult['TotalQuestions']; ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Thời gian làm bài</div>
                        <div class="info-value">
                            <?php 
                                $minutes = floor($contestResult['TakingTime'] / 60);
                                $seconds = $contestResult['TakingTime'] % 60;
                                echo sprintf("%02d:%02d", $minutes, $seconds);
                            ?>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Ngày thi</div>
                        <div class="info-value" style="font-size: 1.2rem;"><?php echo date('d/m/Y', strtotime($contestResult['CreateDate'])); ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Số lần thi còn lại</div>
                        <div class="info-value"><?php echo $contestResult['TestTimes']; ?> lần</div>
                    </div>
                </div>

                <div class="action-buttons">
                    <button onclick="window.location.href='contestZone.php'" class="btn-action btn-outline-primary">
                        <i class="bi bi-arrow-left"></i>
                        Quay lại
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php
        include 'footer.php';
        include 'javascript.php';
    ?>
</body>
</html>
