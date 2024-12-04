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
:root {
    --primary-color: #4154f1;
    --secondary-color: #2c3cdd;
    --text-color: #1e293b;
    --border-color: #e9ecef;
}

/* Main Content Section */
.section {
    padding: 40px 0;
    background: linear-gradient(135deg, #f6f9ff 0%, #f1f4ff 100%);
}

/* Container Styling */
.container.article {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
}

/* Form Card */
.card {
    border: none;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    margin-bottom: 2rem;
}

.card-body {
    padding: 2rem;
}

/* Form Title */
h2.text-center {
    color: var(--primary-color);
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 2rem;
    position: relative;
    padding-bottom: 15px;
}

h2.text-center:after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border-radius: 2px;
}

/* Form Controls */
.form-label {
    color: var(--text-color);
    font-weight: 600;
    margin-bottom: 0.8rem;
    font-size: 0.95rem;
    display: flex;
    align-items: center;
    gap: 8px;
}

.form-label i {
    color: var(--primary-color);
    font-size: 1.1rem;
}

.form-control {
    border: 2px solid var(--border-color);
    border-radius: 12px;
    padding: 12px 15px;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 4px rgba(65, 84, 241, 0.1);
}

textarea.form-control {
    min-height: 120px;
    resize: vertical;
}

/* Select Styling */
.form-select {
    border: 2px solid var(--border-color);
    border-radius: 12px;
    padding: 12px 15px;
    transition: all 0.3s ease;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%234154f1' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
}

.form-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 4px rgba(65, 84, 241, 0.1);
}

/* Questions Table */
.table {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
}

.table thead {
    background: linear-gradient(135deg, #4154f1, #2c3cdd);
    color: white;
}

.table thead th {
    font-weight: 500;
    letter-spacing: 0.5px;
    padding: 15px;
    border: none;
}

.table tbody tr {
    transition: all 0.3s ease;
}

.table tbody tr:hover {
    background-color: #f8f9ff;
    transform: scale(1.01);
}

.table caption {
    color: var(--primary-color);
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 1rem;
    caption-side: top;
}

/* Action Buttons */
.btn {
    padding: 12px 25px;
    border-radius: 12px;
    font-weight: 500;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn i {
    font-size: 1.2rem;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(65, 84, 241, 0.2);
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border: none;
}

.btn-lg {
    padding: 15px 30px;
    font-size: 1.1rem;
}

/* Edit Form */
.editQuestion {
    background: rgba(65, 84, 241, 0.05);
    border-radius: 12px;
}

.editQuestion td {
    padding: 15px;
}

/* Custom Scrollbar */
#questionsTable {
    max-height: 600px;
    overflow: auto;
    border-radius: 15px;
    margin: 2rem 0;
}

#questionsTable::-webkit-scrollbar {
    width: 6px;
}

#questionsTable::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

#questionsTable::-webkit-scrollbar-thumb {
    background: var(--primary-color);
    border-radius: 10px;
}

#questionsTable::-webkit-scrollbar-thumb:hover {
    background: var(--secondary-color);
}

/* Hero Section */
.hero.overlay {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
}

/* Responsive Design */
@media (max-width: 768px) {
    .container.article {
        padding: 20px;
    }

    .card-body {
        padding: 1.5rem;
    }

    .btn {
        padding: 10px 20px;
    }

    .table td, .table th {
        padding: 10px;
    }
}
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
