<?php
  include 'head.php';
?>
<body>
    <?php
        include 'header.php';
        $contestID = 0;
        $contestCode = '';
        if(isset($_GET['contestID']) && isset($_GET['contestCode'])){
            $contestID = $_GET['contestID'];
            $contestCode = $_GET['contestCode'];        
        }
    ?>
    <script>
        let contestID = '<?php echo $contestID; ?>';
        let contestCode = '<?php echo $contestCode; ?>';
        let currentQuestion = 1;
        let questionsArray = [];
        $('#previousQuestion').prop('disabled', true);
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
                    console.log(questionsArray);
                    loadQuestions(1);
                    loadQuestionPanel();
                }else{
                    alert(data.message);
                }
            },
            error: function(xhr, status, error){
                alert('Error: ' + error);
            }
        });
        $('#markQuestion').click(function(){
            console.log($(this).attr('value'));
            if($(this).attr('value') == 0){
                $(this).attr('value', 1);
                $(this).find('i').removeClass('text-danger').addClass('text-success');
            }else{
                $(this).attr('value', 0);
                $(this).find('i').removeClass('text-success').addClass('text-danger');
            }
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
                let input = $('<input>').addClass('form-check-input').attr('type', 'radio').attr('name', `question${questionNumber}`).attr('id', `option${i}`).val(question['Answer'][i]['AnswerID']);
                let label = $('<label>').addClass('form-check-label fs-6').attr('for', `option${i}`).text((i == 0 ? ' A. ' : i == 1 ? ' B. ' : i == 2 ? ' C. ' : ' D. ') + question['Answer'][i]['AnswerDescription']);
                div.append(input);
                div.append(label);
                $('#questionBox').append(div);
            }
        }
        function loadQuestionPanel(){
            $('#questionPanel').empty();
            console.log(questionsArray.length);
            for(let j = 0; j < questionsArray.length; j++){

                    let btn = $('<button>').addClass('btn btn-outline-primary rounded-circle questionNumber mx-auto position-relative').attr('id', `question${j + 1}`).attr('style', 'width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; font-size: 22px;').attr('value', j + 1).text(j + 1);
                    let span = $('<span>').addClass('position-absolute top-0 start-100 translate-middle p-2 bg-transparent border border-0 rounded-circle').attr('id', `markQuestion${j + 1}`).attr('value', 0);
                    let i = $('<i>').addClass('bi bi-flag-fill text-success fs-5').attr('id', `markQuestion${j + 1}`);
                    span.append(i);
                    btn.append(span);
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
        function copyContestCode(){
            if(contestCode != ''){
                navigator.clipboard.writeText(contestCode);
                alert('Đã copy mã cuộc thi');
            }else{
                alert('Không có mã cuộc thi');
            }
        }
    </script>
    <!-- Add content here -->
    <div class="hero overlay" style="height: 150px !important; max-height: 150px !important; min-height: 100px !important">
    </div>

    <!-- Exam Participation Page -->
    <div class="container mt-4" style="max-width: 1200px;">
        <div class="d-flex flex-column">
            <!-- Question Navigation on the left side -->
            <div class="flex-shrink-0">
                <div class="card shadow-lg rounded-lg border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h4 class="text-primary text-center">Chọn Câu Hỏi:</h4>
                            <div class="d-flex justify-content-end">
                                <div class="d-flex align-items-center gap-2">
                                    <button id="markQuestion" class="p-2 bg-transparent border border-0" value="0">
                                        <i class="bi bi-flag-fill text-danger fs-5"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Circle Buttons for Questions -->
                        <div class="mx-auto d-flex justify-content-center align-items-center gap-2 flex-wrap mt-4 mb-2" id="questionPanel">
                            <!-- Question buttons will be loaded here -->
                            <h4 id="question1" class="text-danger fs-5">Cannot load question list</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Question Content -->
            <div class="flex-grow-1">
                <div class="card shadow-lg rounded-lg border-0">
                    <div class="card-body">
                        <!-- Timer Display -->
                        <!-- <div class="text-center mb-4">
                            <h5 class="text-danger">Thời gian còn lại: <span id="countdown">30:00</span></h5>
                        </div> -->
                        <div id="questionBox">
                            <h4 class="text-danger fs-5">Cannot load question</h4>
                        </div>
                        <!-- Navigation buttons -->
                        
                        <div class="d-flex justify-content-between mt-4">
                            <button onclick="previousQuestion()" class="btn btn-outline-secondary px-4 py-2 rounded-pill">Câu trước</button>
                            <button onclick="nextQuestion()" class="btn btn-primary px-4 py-2 rounded-pill">Câu tiếp</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <!-- <button onclick="submitAnswer()" class="btn btn-success px-4 py-2 rounded-pill">Nộp bài</button> -->
            <div class="d-flex justify-content-end mt-4">
                <button onclick="window.location.href='./contest.php'" class="btn btn-primary px-4 py-3 me-2 rounded-pill">Quay lại</button>
                <button onclick="copyContestCode()" class="btn btn-primary px-4 py-3 rounded-pill">Lấy mã cuộc thi</button>
            </div>
    </div>


    <div class="mt-5"></div> <!-- Add space between the form and footer -->

    <?php
        include 'footer.php';
        include 'javascript.php';
    ?>

</body>
</html>
