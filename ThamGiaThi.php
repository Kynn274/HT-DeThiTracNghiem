<?php
  include 'head.php';
?>
<body>
    <?php
        include 'header.php';
        $contestID = 0;
        $type = '';
        if(isset($_SESSION['joinContest'])){
            $contestID = $_SESSION['joinContest']['contestID'];
            $type = $_SESSION['joinContest']['type'];            
        }
    ?>
    <script>
        let contestID = '<?php echo $contestID; ?>';
        let type = '<?php echo $type; ?>';
        let questionsArray = [];
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
                    loadQuestions(1);
                }else{
                    alert(data.message);
                }
            },
            error: function(xhr, status, error){
                alert('Error: ' + error);
            }
        });
        
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

    </script>
    <!-- Add content here -->
    <div class="hero overlay" style="height: 150px !important; max-height: 150px !important; min-height: 100px !important">
    </div>

    <!-- Exam Participation Page -->
    <div class="container mt-4">
        <div class="row">
            <!-- Question Navigation on the left side -->
            <div class="col-md-3">
                <div class="card shadow-lg rounded-lg border-0">
                    <div class="card-body">
                        <h4 class="text-primary text-center">Chọn Câu Hỏi:</h4>

                        <!-- Circle Buttons for Questions -->
                        <div class="d-flex flex-column align-items-center">
                            <a href="#question1" class="btn btn-outline-primary rounded-circle my-2" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; font-size: 22px;">1</a>
                            <a href="#question2" class="btn btn-outline-primary rounded-circle my-2" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; font-size: 22px;">2</a>
                            <a href="#question3" class="btn btn-outline-primary rounded-circle my-2" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; font-size: 22px;">3</a>
                            <a href="#question4" class="btn btn-outline-primary rounded-circle my-2" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; font-size: 22px;">4</a>
                            <!-- Add more circles for additional questions -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Question Content -->
            <div class="col-md-9">
                <div class="card shadow-lg rounded-lg border-0">
                    <div class="card-body">
                        <!-- Timer Display -->
                        <?php if($type == 'contest'): ?>
                            <div class="text-center mb-4">
                                <h5 class="text-danger">Thời gian còn lại: <span id="countdown">30:00</span></h5>
                            </div>
                        <?php endif; ?>
                        <div id="questionBox">
                            <h4 id="question1" class="text-primary">Cannot load question</h4>
                            <!-- Question 1 -->
                            <!-- <h4 id="question1" class="text-primary">Câu hỏi 1:</h4>
                            <p>[Nội Dung Câu Hỏi]</p>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="question1" id="option1" value="A">
                                <label class="form-check-label" for="option1">Đáp án A</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="question1" id="option2" value="B">
                                <label class="form-check-label" for="option2">Đáp án B</label>
                            </div>
                            <div class="form-check">
                            <input class="form-check-input" type="radio" name="question1" id="option3" value="C">
                                <label class="form-check-label" for="option3">Đáp án C</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="question1" id="option4" value="D">
                                <label class="form-check-label" for="option4">Đáp án D</label>
                            </div> -->

                        

                        <!-- Question 2 -->
                        <!-- <h4 id="question2" class="mt-4 text-primary">Câu hỏi 2:</h4>
                        <p>[Nội Dung Câu Hỏi]</p>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question2" id="option1" value="A">
                            <label class="form-check-label" for="option1">Đáp án A</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question2" id="option2" value="B">
                            <label class="form-check-label" for="option2">Đáp án B</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question2" id="option3" value="C">
                            <label class="form-check-label" for="option3">Đáp án C</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question2" id="option4" value="D">
                            <label class="form-check-label" for="option4">Đáp án D</label>
                        </div> -->

                        <!-- Question 3 -->
                        <!-- <h4 id="question3" class="mt-4 text-primary">Câu hỏi 3:</h4>
                        <p>[Nội Dung Câu Hỏi]</p>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question3" id="option1" value="A">
                            <label class="form-check-label" for="option1">Đáp án A</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question3" id="option2" value="B">
                            <label class="form-check-label" for="option2">Đáp án B</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question3" id="option3" value="C">
                            <label class="form-check-label" for="option3">Đáp án C</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question3" id="option4" value="D">
                            <label class="form-check-label" for="option4">Đáp án D</label>
                        </div> -->

                        <!-- Question 4 -->
                        <!-- <h4 id="question4" class="mt-4 text-primary">Câu hỏi 4:</h4>
                        <p>[Nội Dung Câu Hỏi]</p>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question4" id="option1" value="A">
                            <label class="form-check-label" for="option1">Đáp án A</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question4" id="option2" value="B">
                            <label class="form-check-label" for="option2">Đáp án B</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question4" id="option3" value="C">
                            <label class="form-check-label" for="option3">Đáp án C</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question4" id="option4" value="D">
                            <label class="form-check-label" for="option4">Đáp án D</label>
                            </div>
                        </div> -->
                        <!-- Navigation buttons -->
                        
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <a href="previous_question.php?id=1" class="btn btn-outline-secondary px-4 py-2 rounded-pill">Quay lại</a>
                        <a href="next_question.php?id=1" class="btn btn-primary px-4 py-2 rounded-pill">Tiếp theo</a>
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
