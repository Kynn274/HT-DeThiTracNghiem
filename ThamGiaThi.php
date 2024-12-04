<?php
  include 'head.php';
?>
<body>
    <?php
        include 'header.php';
        $contestID = 0;
        if(isset($_GET['id'])){
            $contestID = $_GET['id'];
        }
    ?>
    <script>
        let contestID = '<?php echo $contestID; ?>';
        let userID = '<?php echo $_SESSION['user_id']; ?>';
        let currentQuestion = 1;
        let joiningContestID = 0;
        let questionsArray = [];
        $('#previousQuestion').prop('disabled', true);

        // Khởi tạo hoặc lấy thời gian bắt đầu từ localStorage
        let startTime;
        if (!localStorage.getItem('examStartTime_' + contestID)) {
            startTime = new Date().getTime();
            localStorage.setItem('examStartTime_' + contestID, startTime);
        } else {
            startTime = parseInt(localStorage.getItem('examStartTime_' + contestID));
        }
        
        let takingTime = 0;

        // DOM Ready
        $(document).ready(function() {
            $.ajax({
                url: 'process.php',
                type: 'POST',
                data: {
                    action: 'getContestQuestions',
                    contestID: contestID
                },
                success: function(data){
                    console.log(data);
                    if(data.success){
                        questionsArray = data.questions;
                        // Khôi phục câu trả lời đã chọn từ localStorage
                        const savedAnswers = localStorage.getItem('examAnswers_' + contestID);
                        if (savedAnswers) {
                            questionsArray = JSON.parse(savedAnswers);
                        } else {
                            questionsArray.forEach(question => {
                                question['SelectedAnswer'] = 0;
                            });
                        }
                        loadQuestions(1);
                        loadQuestionPanel();
                        setCountdown(data.contestInfo.Longtime);
                    }else{
                        alert(data.message);
                    }
                },
                error: function(xhr, status, error){
                    alert('Error: ' + error);
                }
            });

            // Lưu câu trả lời khi người dùng chọn
            $(document).on('click', '.form-check-input', function() {
                localStorage.setItem('examAnswers_' + contestID, JSON.stringify(questionsArray));
            });

            $.ajax({
                url: 'process.php',
                type: 'POST',
                data: {
                    action: 'getJoiningContestID',
                    userID: userID,
                    contestID: contestID
                },
                success: function(data){
                    console.log('<?php echo $_SESSION['user_id']; ?>');
                    console.log(contestID);
                    if(data.success){
                        joiningContestID = data.joiningContestID;
                    }else{
                        console.log(data.message);
                    }
                },
                error: function(response){
                    console.log(response);
                }
            });
            //  Trigger
            $('#submitAnswerButton').on('click', function () {
                let check = true;
                questionsArray.forEach(question => {
                    if(question['SelectedAnswer'] == 0){
                        check = false;
                        console.log(check);
                    }
                });
                
                if(check == true){
                    $('#modalMessage').text('Bạn có chắc chắn muốn nộp bài không?');
                }else{
                    $('#modalMessage').text('Bạn chưa chọn đáp án cho tất cả câu hỏi, bạn có chắc chắn muốn nộp bài không?');
                }
                $('#submitAnswerModal').modal('show');
            });
            $('#submitAnswerButtonModal').on('click', function(){
                console.log(joiningContestID);
                $.ajax({
                    url: 'process.php',
                    type: 'POST',
                    data: {
                        action: 'submitAnswer',
                        joiningContestID: joiningContestID,
                        questionsArray: questionsArray,
                        takingTime: takingTime
                    },
                    success: function(response){
                        if(response.success){
                            localStorage.removeItem('examStartTime_' + contestID);
                            localStorage.removeItem('examAnswers_' + contestID);
                            window.location.href = 'KetThucThi.php?id=' + joiningContestID;
                        }else{
                            $('#submitAnswerModal').modal('hide');
                            // Hiển thị modal thông báo lỗi
                            $('#modalMessage').text('Không thể nộp bài. Vui lòng thử lại!');
                            $('#submitAnswerButtonModal').hide();
                            $('#submitAnswerModal').modal('show');
                        }
                    },
                    error: function(response){
                        $('#submitAnswerModal').modal('hide');
                        // Hiển thị modal thông báo lỗi
                        $('#modalMessage').text('Có lỗi xảy ra. Vui lòng thử lại!');
                        $('#submitAnswerButtonModal').hide();
                        $('#submitAnswerModal').modal('show');
                    }
                });
            });
            // Reset modal khi đóng
            $('#submitAnswerModal').on('hidden.bs.modal', function () {
                $('#submitAnswerButtonModal').show();
            });
        });

        
        //  Functions
        function loadQuestions(questionNumber){
                let number = questionNumber - 1;
                let question = questionsArray[number];
                $('#questionBox').empty();
                let h4 = $('<h4>').addClass('text-primary').attr('id', `question${questionNumber}`).text(`Câu hỏi ${questionNumber}:`);
                $('#questionBox').append(h4);
                let p = $('<p>').addClass('mt-4 fs-5').text(question['QuestionDescription']);
                $('#questionBox').append(p);
                for(let i = 0; i < question['Answer'].length; i++){
                    let div = $('<div>').addClass('form-check');
                    let input = $('<input>').addClass('form-check-input').attr('type', 'radio').attr('name', `question${questionNumber}`).attr('id', `option${i}`).attr('value', question['Answer'][i]['AnswerID']).attr('checked', question['SelectedAnswer'] == question['Answer'][i]['AnswerID'] ? true : false);
                    let label = $('<label>').addClass('form-check-label fs-6').attr('for', `option${i}`).text((i == 0 ? ' A. ' : i == 1 ? ' B. ' : i == 2 ? ' C. ' : ' D. ') + question['Answer'][i]['AnswerDescription']);
                    div.append(input);
                    div.append(label);
                    $('#questionBox').append(div);
                    input.click(function(){
                        questionsArray[number]['SelectedAnswer'] = parseInt($(this).val());
                        loadQuestionPanel();
                    });
                }
            }
            function loadQuestionPanel(){
                $('#questionPanel').empty();
                console.log(questionsArray.length);
                for(let j = 0; j < questionsArray.length; j++){
                        let btn = $('<button>').addClass(`btn btn-outline-primary ${questionsArray[j]['SelectedAnswer'] == 0 ? 'bg-light' : 'bg-primary'} rounded-circle questionNumber mx-auto position-relative`).attr('id', `question${j + 1}`).attr('style', 'width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; font-size: 22px;').attr('value', j + 1).text(j + 1);
                    
                        $('#questionPanel').append(btn);
                        btn.click(function(){
                            currentQuestion = parseInt($(this).attr('value'));
                            loadQuestions(currentQuestion);
                            if(currentQuestion <= 1){
                                $('#previousQuestion').prop('disabled', true);
                                $('#nextQuestion').prop('disabled', false);
                            }else if(currentQuestion >= questionsArray.length){
                                $('#nextQuestion').prop('disabled', true);
                                $('#previousQuestion').prop('disabled', false);
                            }else{
                                $('#previousQuestion').prop('disabled', false);
                                $('#nextQuestion').prop('disabled', false);
                            }
                        });

                }
            }
            function setCountdown(time) {
                let second = time * 60;
                // Tính thời gian đã trôi qua
                const elapsedTime = Math.floor((new Date().getTime() - startTime) / 1000);
                second = second - elapsedTime;

                let countdownTimer = setInterval(function() {
                    second--;
                    
                    // Tính thời gian đã làm
                    let currentTime = new Date().getTime();
                    takingTime = Math.floor((currentTime - startTime) / 1000);
                    
                    // Format thời gian đếm ngược
                    let minutes = Math.floor(second / 60);
                    let seconds = second % 60;
                    
                    // Thêm số 0 phía trước nếu cần
                    minutes = minutes < 10 ? "0" + minutes : minutes;
                    seconds = seconds < 10 ? "0" + seconds : seconds;
                    
                    $('#countdown').attr('value', second).text(`${minutes}:${seconds}`);

                    // Kiểm tra hết giờ
                    if (second <= 0) {
                        clearInterval(countdownTimer);
                        autoSubmit();
                    }
                }, 1000);
            }
            function autoSubmit() {
                $.ajax({
                    url: 'process.php',
                    type: 'POST',
                    data: {
                        action: 'submitAnswer',
                        joiningContestID: joiningContestID,
                        questionsArray: questionsArray,
                        takingTime: takingTime
                    },
                    success: function(response) {
                        // Xóa dữ liệu khỏi localStorage khi nộp bài
                        localStorage.removeItem('examStartTime_' + contestID);
                        localStorage.removeItem('examAnswers_' + contestID);
                        window.location.href = 'KetThucThi.php?id=' + joiningContestID;
                    },
                    error: function(response) {
                        console.log(response);
                    }
                });
            }
            function nextQuestion(){
                if(currentQuestion < questionsArray.length){
                    currentQuestion += 1;
                    loadQuestions(currentQuestion);
                    $('#previousQuestion').prop('disabled', false);
                }
                if(currentQuestion >= questionsArray.length){
                    $('#nextQuestion').prop('disabled', true);
                }
            }
            function previousQuestion(){
                if(currentQuestion > 1){
                    currentQuestion -= 1;
                    loadQuestions(currentQuestion);
                    $('#nextQuestion').prop('disabled', false);
                }
                if(currentQuestion <= 1){
                    $('#previousQuestion').prop('disabled', true);
                }
            }
    </script>
    <!-- Add content here -->
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

        /* Main Content */
        .container.exam-container {
            max-width: 1200px;
            margin: 20px auto;
        }

        .question-nav-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: none;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .question-header {
            padding: 20px;
            border-bottom: 1px solid rgba(65, 84, 241, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .question-header h4 {
            margin: 0;
            color: #2c3cdd;
            font-weight: 600;
        }

        .question-panel {
            padding: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
        }

        .question-number {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
        }

        .question-number:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(65, 84, 241, 0.2);
        }

        .question-content {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .timer-display {
            background: linear-gradient(135deg, #ff4d4d, #f73859);
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .question-box {
            margin-bottom: 30px;
        }

        .form-check {
            margin: 15px 0;
            padding: 15px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .form-check:hover {
            background: #f8f9ff;
        }

        .nav-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .btn-nav {
            padding: 10px 25px;
            border-radius: 12px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-nav:hover {
            transform: translateY(-2px);
        }

        .submit-btn {
            background: linear-gradient(135deg, #2dce89, #2dcecc);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-top: 20px;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(45, 206, 137, 0.3);
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

        .modal-footer .btn-success {
            background: linear-gradient(135deg, #2dce89, #2dcecc);
            border: none;
        }

        .modal-footer .btn-success:hover {
            box-shadow: 0 5px 15px rgba(45, 206, 137, 0.3);
        }
    </style>

    <div class="hero inner-page">
        <div class="hero-background"></div>
        <div class="container">
            <div class="hero-content">
                <span class="text-gradient d-block mb-2 text-center" data-aos="fade-up">Làm Bài Thi</span>
                <h1 class="heading text-white mb-4 text-center" data-aos="fade-up" data-aos-delay="100" 
                    style="font-size: 3rem; font-weight: 700;">Bài Thi Trắc Nghiệm</h1>
                <p class="text-white-50 mb-0 text-center" data-aos="fade-up" data-aos-delay="200" 
                   style="font-size: 1.1rem;">
                    Vui lòng chọn câu trả lời chính xác
                </p>
            </div>
        </div>
    </div>

    <!-- Exam Participation Page -->
    <div class="container exam-container">
        <div class="d-flex flex-column">
            <!-- Question Navigation -->
            <div class="flex-shrink-0">
                <div class="question-nav-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h4>Chọn Câu Hỏi:</h4>
                            <div class="d-flex justify-content-end">
                                <div class="d-flex align-items-center gap-2">
                                </div>
                            </div>
                        </div>

                        <!-- Circle Buttons for Questions -->
                        <div class="question-panel" id="questionPanel">
                            <!-- Question buttons will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Question Content -->
            <div class="flex-grow-1">
                <div class="question-content">
                    <div class="card-body">
                        <!-- Timer Display -->
                        <div class="timer-display">
                            <i class="bi bi-clock"></i>
                            Thời gian còn lại: <span id="countdown" value=""></span>
                        </div>
                        <div id="questionBox">
                            <!-- Question content will be loaded here -->
                        </div>
                        
                        <!-- Navigation buttons -->
                        <div class="nav-buttons">
                            <button onclick="previousQuestion()" class="btn-nav btn-outline-primary">
                                <i class="bi bi-arrow-left"></i> Câu trước
                            </button>
                            <button onclick="nextQuestion()" class="btn-nav btn-primary">
                                Câu tiếp <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-4">
            <button id="submitAnswerButton" class="submit-btn">
                <i class="bi bi-check2-circle"></i> Nộp bài
            </button>
        </div>
    </div>

    <!-- Modal Nộp Bài -->
    <div class="modal fade" tabindex="-1" id="submitAnswerModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title">Nộp bài</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center" id="submitAnswerModalBody">
                    <i class="bi bi-exclamation-circle text-warning" style="font-size: 3rem;"></i>
                    <p class="mt-3" id="modalMessage"></p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg"></i> Đóng
                    </button>
                    <button type="button" class="btn btn-success" id="submitAnswerButtonModal">
                        <i class="bi bi-check-lg"></i> Nộp bài
                    </button>
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
