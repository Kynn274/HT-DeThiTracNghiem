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
    <div class="container mt-4">
        <div class="d-flex flex-column">
            <!-- Question Navigation -->
            <div class="flex-shrink-0 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="question-header">
                            <h4>
                                <i class="bi bi-grid-3x3-gap-fill"></i>
                                Danh sách câu hỏi
                            </h4>
                        </div>
                        <div id="questionPanel" class="d-flex flex-wrap gap-2 justify-content-center mt-4">
                            <!-- Questions will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Question Content -->
            <div class="flex-grow-1">
                <div class="card">
                    <div class="card-body">
                        <div id="questionBox">
                            <!-- Question content will be loaded here -->
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <button onclick="previousQuestion()" class="btn btn-outline-primary" id="previousQuestion">
                                <i class="bi bi-arrow-left"></i>
                                Câu trước
                            </button>
                            <button onclick="nextQuestion()" class="btn btn-primary" id="nextQuestion">
                                Câu tiếp
                                <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex justify-content-end mt-4 gap-3">
                <button onclick="window.location.href='./contest.php'" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left-circle"></i>
                    Quay lại
                </button>
                <button onclick="copyContestCode()" class="btn btn-primary">
                    <i class="bi bi-clipboard-check"></i>
                    Lấy mã cuộc thi
                </button>
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
