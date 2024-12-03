<?php
  include 'head.php';
?>
<body>
    <?php
        include 'header.php';
        $bankID = $_SESSION['currentBankId'];
        function deleteQuestionByQuestionID($questionID){
            global $conn;
            $sql = "DELETE FROM Questions WHERE QuestionID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $questionID);
            $stmt->execute();
        }
        
        if(!isset($bankID)){
            header('Location: questionsBank.php');
            exit;
        }else{
            $sql = "SELECT * FROM Questions WHERE QuestionBankID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $bankID);
            if($stmt->execute()){
                $result = $stmt->get_result();
            }
        }
        $questions = [];
        while($row = $result->fetch_assoc()){
            $question = $row;
            $questionID = $row['QuestionID'];
            $sql = "SELECT * FROM Answers WHERE QuestionID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $questionID);
            if($stmt->execute()){
                $answers = $stmt->get_result();
                while($answer = $answers->fetch_assoc()){
                    $question['answers'][] = $answer;
                }
            }
            $questions[] = $question;
        }
    ?>
<style>
    /* Hiệu ứng hover cho các hàng trong bảng */
    .table-hover tbody tr:hover {
        background-color: #e3f2fd;
        box-shadow: inset 0 0 10px rgba(0, 123, 255, 0.25);
        cursor: pointer;
        transition: all 0.3s ease-in-out;
    }

    /* Hiệu ứng hover cho các nút hành động */
    .btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease-in-out;
    }
    .btn-warning:hover {
        background-color: #ffcc00;
        border-color: #ffcc00;
        color: #fff;
    }
    .btn-danger:hover {
        background-color: #d9534f;
        border-color: #d43f3a;
        color: #fff;
    }
    .btn-primary:hover {
        background-color: #337ab7;
        border-color: #2e6da4;
        color: #fff;
    }
    /* Make the header sticky while scrolling */
    .questionAddition thead th {
        position: sticky;
        top: 0;
        background-color: #f8f9fa;
        z-index: 1;
        font-weight: bold;
        text-align: center;
    }

    /* Custom scrollbar styling */
    .questionsTable::-webkit-scrollbar {
        width: 8px;
    }

    .questionsTable::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .questionsTable::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }

    .questionsTable::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Ensure the table caption stays above the scrollable area */
    .questionAddition caption {
        position: sticky;
        top: 0;
        background-color: white;
        z-index: 2;
        padding: 10px 0;
        font-weight: bold;
    }

    /* Ensure proper spacing */
    #questionsTable table tbody {
        margin-bottom: 0;
    }
    
    #questionsTable table tbody::-webkit-scrollbar {
        width: 8px;
    }

    #questionsTable table tbody::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    #questionsTable table tbody::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }

    #questionsTable table tbody::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Thêm các style mới cho table scroll */
    #questionsTable {
        max-height: 500px;
        overflow: hidden;
    }

    #questionsTable table {
        width: 100%;
        border-collapse: collapse;
    }

    #questionsTable thead {
        position: sticky;
        top: 0;
        background-color: #f8f9fa;
        z-index: 2;
    }

    #questionsTable tbody {
        display: block;
        max-height: 400px;
        overflow-y: auto;
    }

    #questionsTable thead tr,
    #questionsTable tbody tr {
        display: table;
        width: 100%;
        table-layout: fixed;
    }

    /* Điều chỉnh chiều rộng các cột */
    #questionsTable th:nth-child(1),
    #questionsTable td:nth-child(1) { width: 5%; }
    #questionsTable th:nth-child(2),
    #questionsTable td:nth-child(2) { width: 5%; }
    #questionsTable th:nth-child(3),
    #questionsTable td:nth-child(3) { width: 15%; }
    #questionsTable th:nth-child(4),
    #questionsTable td:nth-child(4) { width: 10%; }
    #questionsTable th:nth-child(5),
    #questionsTable td:nth-child(5) { width: 10%; }
    #questionsTable th:nth-child(6),
    #questionsTable td:nth-child(6) { width: 10%; }
    #questionsTable th:nth-child(7),
    #questionsTable td:nth-child(7) { width: 10%; }
    #questionsTable th:nth-child(8),
    #questionsTable td:nth-child(8) { width: 10%; }
    #questionsTable th:nth-child(9),
    #questionsTable td:nth-child(9) { width: 10%; }
    #questionsTable th:nth-child(10),
    #questionsTable td:nth-child(10) { width: 20%; }

</style>

    <div class="hero overlay" style="height: 150px !important; max-height: 150px !important; min-height: 100px !important">
    </div>

    <div class="container article mb-5 my-5">
        <h2 class="text-center mb-4 fw-bold text-primary">Thêm Câu Hỏi</h2>

        <!-- Form thêm câu hỏi -->
        <div class="card mb-5">
            <div class="card-body">
                <form>
                    <input type="hidden" id="questionBankID_add" value="<?php echo $bankID; ?>">
                    <div class="mb-3">
                        <label for="question" class="form-label fw-semibold">Câu Hỏi</label>
                        <textarea class="form-control" id="question" name="question" rows="3" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="optionA" class="form-label fw-semibold">Đáp Án A</label>
                            <input type="text" class="form-control" id="optionA" name="optionA" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="optionB" class="form-label fw-semibold">Đáp Án B</label>
                            <input type="text" class="form-control" id="optionB" name="optionB" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="optionC" class="form-label fw-semibold">Đáp Án C</label>
                            <input type="text" class="form-control" id="optionC" name="optionC" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="optionD" class="form-label fw-semibold">Đáp Án D</label>
                            <input type="text" class="form-control" id="optionD" name="optionD" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="correctAnswer" class="form-label fw-semibold">Đáp Án Đúng</label>
                        <select class="form-select" id="correctAnswer" name="correctAnswer" required>
                            <option value="A" selected>A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="level" class="form-label fw-semibold">Độ khó</label>
                        <select class="form-select" id="level" name="level" required>
                            <option value="1" selected>Dễ</option>
                            <option value="2">Trung bình</option>
                            <option value="3">Khó</option>
                        </select>
                    </div>

                    
                </form>
                <div class="d-grid">
                    <button id="addQuestionBtn" class="btn btn-primary btn-lg">Thêm Câu Hỏi</button>
                </div>
            </div>
        </div>    

        <!-- Danh sách câu hỏi -->
        <div id="questionsTable">
            <table class="table table-hover caption-top">
            <caption>DANH SÁCH CÂU HỎI</caption>
            <thead>
                <tr>
                    <th scope="col" width="5%" class="text-center align-middle">#</th>
                    <th scope="col" width="5%" class="text-center align-middle" style="display: none;">ID</th>
                    <th scope="col" width="15%" class="text-center align-middle">Câu hỏi</th>
                    <th scope="col" width="10%" class="text-center align-middle">Độ khó</th>
                    <th scope="col" width="10%" class="text-center align-middle">A</th>
                    <th scope="col" width="10%" class="text-center align-middle">B</th>
                    <th scope="col" width="10%" class="text-center align-middle">C</th>
                    <th scope="col" width="10%" class="text-center align-middle">D</th>
                    <th scope="col" width="10%" class="text-center align-middle">Đáp án đúng</th>
                    <th scope="col" width="20%" class="text-center align-middle">Hành động</th>
                </tr>
            </thead>
            <tbody class="accordion accordion-flush">
                <?php
                if(count($questions) > 0):
                    $i = 1;
                    foreach($questions as $question): ?>
                        <tr class="questionItem">
                            <td class="text-center align-middle"><?php echo $i++; ?></td>
                            <td style="display: none;"><input type="hidden" id="questionID" value="<?php echo $question['QuestionID']; ?>"></td>
                            <td class="align-middle"><?php echo $question['QuestionDescription']; ?></td>
                            <td class="text-center align-middle"><?php echo $question['Level'] == 1 ? 'Dễ' : ($question['Level'] == 2 ? 'Trung bình' : 'Khó'); ?></td>
                            <?php $correctAnswer = '';
                            foreach($question['answers'] as $answer): ?>
                                <td class="text-center align-middle"><?php echo $answer['AnswerDescription']; ?></td>
                                <?php if($answer['AnswerID'] == $question['QuestionAnswerID']){
                                    $correctAnswer = $answer;
                                } ?>
                            <?php endforeach; ?>
                            <td class="text-center align-middle"><?php echo $correctAnswer['AnswerDescription']; ?></td>
                            <td class="text-center align-middle">
                                <button class="btn btn-warning btn-sm editQuestionBtn"><i class="bi-solid bi-pen"></i></button>
                                <button class="btn btn-danger btn-sm deleteQuestionBtn"><i class="bi-solid bi-trash"></i></button>
                            </td>
                            <tr style="display: none;" class="editQuestion">
                                <td></td>
                                <td style="display: none;">
                                    <input type="hidden" id="editQuestionID" value="<?php echo $question['QuestionID']; ?>">
                                </td>
                                <td class="text-center align-middle">
                                    <input type="text" class="form-control" id="editQuestionDescription" name="editQuestionDescription" value="<?php echo $question['QuestionDescription']; ?>" rows="3" required>
                                </td>
                                <td class="text-center align-middle">
                                    <select class="form-select form-control" id="editLevel" name="editLevel" required>
                                        <option value="1" <?php echo $question['Level'] == 1 ? 'selected' : ''; ?>>Dễ</option>
                                        <option value="2" <?php echo $question['Level'] == 2 ? 'selected' : ''; ?>>Trung bình</option>
                                        <option value="3" <?php echo $question['Level'] == 3 ? 'selected' : ''; ?>>Khó</option>
                                    </select>
                                </td>
                                <td class="text-center align-middle">
                                    <input type="hidden" id="editAnswerIDA" value="<?php echo $question['answers'][0]['AnswerID']; ?>">
                                    <input type="text" class="form-control" id="editOptionA" name="editOptionA" value="<?php echo $question['answers'][0]['AnswerDescription']; ?>" required>
                                </td>
                                <td class="text-center align-middle">
                                    <input type="hidden" id="editAnswerIDB" value="<?php echo $question['answers'][1]['AnswerID']; ?>">
                                    <input type="text" class="form-control" id="editOptionB" name="editOptionB" value="<?php echo $question['answers'][1]['AnswerDescription']; ?>" required>
                                </td>
                                <td class="text-center align-middle">
                                    <input type="hidden" id="editAnswerIDC" value="<?php echo $question['answers'][2]['AnswerID']; ?>">
                                    <input type="text" class="form-control" id="editOptionC" name="editOptionC" value="<?php echo $question['answers'][2]['AnswerDescription']; ?>" required>
                                </td>
                                <td class="text-center align-middle">
                                    <input type="hidden" id="editAnswerIDD" value="<?php echo $question['answers'][3]['AnswerID']; ?>">
                                    <input type="text" class="form-control" id="editOptionD" name="editOptionD" value="<?php echo $question['answers'][3]['AnswerDescription']; ?>" required>
                                </td>
                                <td class="text-center align-middle">
                                    <select class="form-select form-control" id="editCorrectAnswer" name="editCorrectAnswer" required>
                                        <option value="A" data-question-id="<?php echo $question['answers'][0]['AnswerID']; ?>" <?php echo $question['answers'][0]['AnswerID'] == $question['QuestionAnswerID'] ? 'selected' : ''; ?>>A</option>
                                        <option value="B" data-question-id="<?php echo $question['answers'][1]['AnswerID']; ?>" <?php echo $question['answers'][1]['AnswerID'] == $question['QuestionAnswerID'] ? 'selected' : ''; ?>>B</option>
                                        <option value="C" data-question-id="<?php echo $question['answers'][2]['AnswerID']; ?>" <?php echo $question['answers'][2]['AnswerID'] == $question['QuestionAnswerID'] ? 'selected' : ''; ?>>C</option>
                                        <option value="D" data-question-id="<?php echo $question['answers'][3]['AnswerID']; ?>" <?php echo $question['answers'][3]['AnswerID'] == $question['QuestionAnswerID'] ? 'selected' : ''; ?>>D</option>
                                    </select>
                                </td>
                                <td class="text-center align-middle">
                                    <button class="btn btn-success btn-sm saveEditBtn"><i class="bi-solid bi-check"></i></button>
                                </td>
                            </tr>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="8" class="text-center">Không có câu hỏi nào</td></tr>
                <?php endif; ?>
            </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end gap-2 mb-3 mt-3">
            <button class="btn btn-primary" id="backToQuestionsBank">Quay lại</button>
        </div>
    </div>
    <script src="./js/questionsBank.js"></script>
    <?php
        include 'footer.php';
        include 'javascript.php';
    ?>
</body>
</html>
