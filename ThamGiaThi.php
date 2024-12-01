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
                        questionsArray.forEach(question => {
                            question['SelectedAnswer'] = 0;
                        });
                        // console.log(questionsArray);
                        // console.log(data.contestInfo.Longtime);
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
                        questionsArray: questionsArray
                    },
                    success: function(response){
                        window.location.href = 'KetThucThi.php?id=' + joiningContestID;
                    },
                    error: function(response){
                        console.log(response);
                    }
                });
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
            function setCountdown(time){
                let second = time * 60;
                $('#countdown').attr('value', second).text(`${Math.floor(second / 60)}:${second % 60}`);
                // console.log(time);
                //countdown();
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
                        <div class="text-center mb-4">
                            <h5 class="text-danger">Thời gian còn lại: <span id="countdown" value=""></span></h5>
                        </div>
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
        <div class="d-flex justify-content-end mt-4">
            <button id="submitAnswerButton" data-bs-toggle="modal" data-bs-target="#submitAnswerModal" class="btn btn-success px-4 py-3 rounded-pill me-2">Nộp bài</button>
        </div>
        <div class="modal" tabindex="-1" id="submitAnswerModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Nộp bài</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="submitAnswerModalBody">
                        <p id="modalMessage"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-success" id="submitAnswerButtonModal">Nộp bài</button>
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
