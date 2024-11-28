<?php
require_once './method/database.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Ensure all responses are JSON
header('Content-Type: application/json');

function generateCode($length) {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $code = '';
    $maxIndex = strlen($characters) - 1;

    for ($i = 0; $i < $length; $i++) {
        $index = random_int(0, $maxIndex);
        $code .= $characters[$index];
    }
    $date = date('Y-m-d');
    $code = $code . $date;
    return $code;
}

if(isset($_POST['action'])) {
    if($_POST['action'] == 'getUserInfo') {
        $userID = $_POST['userID'];
        $sql = "SELECT * FROM UserDetails WHERE UserID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userID);
        
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $userData = $result->fetch_assoc();
            
            if ($userData) {
                echo json_encode([
                    'success' => true,
                    'data' => $userData
                ]);
                exit;
            }
        }
        
        echo json_encode([
            'success' => false,
            'message' => 'User not found'
        ]);
        exit;
    }
    if($_POST['action'] == 'banUser'){
        $userID = $_POST['userID'];
        $sql = "UPDATE Users SET Status = 0 WHERE UserID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userID);
        if($stmt->execute()){
            echo json_encode([
                'success' => true
            ]);
            exit;
        }
        echo json_encode([
            'success' => false,
            'message' => 'Could not ban user'
        ]);
        exit;
    }
    if($_POST['action'] == 'activateUser'){
        $userID = $_POST['userID'];
        $sql = "UPDATE Users SET Status = 1 WHERE UserID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userID);
        if($stmt->execute()){
            echo json_encode([
                'success' => true
            ]);
            exit;
        }
        echo json_encode([
            'success' => false,
            'message' => 'Could not activate user'
        ]);
        exit;
    }
    if($_POST['action'] == 'updateUserDetails') {
        $userID = $_POST['user_id'];
        $fullname = $_POST['fullname'];
        $dob = $_POST['dob'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $oldAvatar = $_POST['avatar'];
        $avatar = $_FILES['avatarInput']['name'] ?? $oldAvatar;
        $avatar_tmp = $_FILES['avatarInput']['tmp_name'] ?? null;

        if(move_uploaded_file($avatar_tmp, 'images/'.$avatar)) {
            echo "Image uploaded successfully";
        }
        else{
            $avatar = $oldAvatar;
        }
        $sql = "UPDATE UserDetails SET Fullname = ?, DateOfBirth = ?, Email = ?, PhoneNumber = ?, Avatar = ? WHERE UserID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $fullname, $dob, $email, $phone, $avatar, $userID);

        if($stmt->execute()){
            echo json_encode([
                'success' => true,
                'message' => 'Updated successfully'
            ]);
            header('Location: ChinhSuaThongTinCaNhan.php');
            exit;
        }
        
        echo json_encode([
            'success' => false,
            'message' => 'Could not update user details'
        ]);
        exit;
    }
    if($_POST['action'] == 'requestEditBank'){
        $_SESSION['bankMode'] = 'edit';
        $_SESSION['questionsBankId'] = $_POST['bankID'];
        echo json_encode([
            'success' => true,
            'message' => 'Request edit bank'
        ]);
        exit;
    }
    if($_POST['action'] == 'saveQuestionsBank'){
        $bankName = $_POST['quesBankName'];
        $subject = $_POST['subject'];
        if($_SESSION['bankMode'] == 'add'){
            $createdDate = date('Y-m-d');
            $userID = $_SESSION['user_id'];
            $sql = "INSERT INTO QuestionBanks (QuestionBankName, Subject, CreateDate, UserID) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $bankName, $subject, $createdDate, $userID);
        }else{
            $bankID = $_SESSION['questionsBankId'];
            $sql = "UPDATE QuestionBanks SET QuestionBankName = ?, Subject = ? WHERE QuestionBankID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $bankName, $subject, $bankID);
        }
        if($stmt->execute()){
            echo json_encode([
                'success' => true,
                'message' => 'Save questions bank'
            ]);
            header('Location: questionsBank.php');
            exit;
        }
        echo json_encode([
            'success' => false,
            'message' => 'Could not save questions bank'
        ]);
        exit;
    }
    if($_POST['action'] == 'deleteQuestionsBank'){
        $bankID = $_POST['bankID'];
        $sql = "DELETE FROM QuestionBanks WHERE QuestionBankID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $bankID);
        if($stmt->execute()){
            echo json_encode([
                'success' => true
            ]);
            exit;
        }
        echo json_encode([
            'success' => false,
            'message' => 'Could not delete questions bank'
        ]);
        exit;
    }
    if($_POST['action'] == 'requestAddQuestion'){
        $_SESSION['currentBankId'] = $_POST['bankID'];
        echo json_encode([
            'success' => true,
            'message' => 'Request add question'
        ]);
        exit;
    }
    if($_POST['action'] == 'addQuestionToBank'){
        $bankID = $_POST['bankID'];
        $question = $_POST['question'];
        $optionA = $_POST['optionA'];
        $optionB = $_POST['optionB'];
        $optionC = $_POST['optionC'];
        $optionD = $_POST['optionD'];
        $correctAnswer = $_POST['correctAnswer'];
        $level = $_POST['level'];

        // Thêm câu hỏi
        $sql = "INSERT INTO Questions (QuestionBankID, QuestionDescription, Level) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isi", $bankID, $question, $level);
        $stmt->execute();
        $questionID = $stmt->insert_id;

        // Thêm các đáp án
        $answers = [
            'A' => $optionA,
            'B' => $optionB,
            'C' => $optionC,
            'D' => $optionD
        ];

        $sql = "INSERT INTO Answers (QuestionID, AnswerDescription, AnswerStatus) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
        foreach($answers as $key => $value) {
            $isCorrect = ($key == $correctAnswer) ? 1 : 0;
            $stmt->bind_param("isi", $questionID, $value, $isCorrect);
            $stmt->execute();
            
            if($isCorrect) {
                $answerID = $stmt->insert_id;
            }
        }

        // Cập nhật QuestionAnswerID
        $sql = "UPDATE Questions SET QuestionAnswerID = ? WHERE QuestionID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $answerID, $questionID);
        if($stmt->execute()){
            $sql = "SELECT COUNT(*) FROM Questions WHERE QuestionBankID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $bankID);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $totalQuestions = $row['COUNT(*)'];
            $sql = "UPDATE QuestionBanks SET TotalNumber = ? WHERE QuestionBankID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $totalQuestions, $bankID);
            if($stmt->execute()){
                    echo json_encode([
                        'success' => true,
                        'message' => 'Add question to bank',
                        'data' => ['totalQuestions' => $totalQuestions]
                    ]);
                exit;
            }
            echo json_encode([
                'success' => false,
                'message' => 'Could not add question to bank'
            ]);
            exit;
        }
        exit;
    }
    if($_POST['action'] == 'deleteQuestion'){
        $questionID = $_POST['questionID'];
        $sql = "DELETE FROM Questions WHERE QuestionID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $questionID);
        if($stmt->execute()){
            echo json_encode([
                'success' => true
            ]);
            exit;
        }
        echo json_encode([
            'success' => false,
            'message' => 'Could not delete question'
        ]);
        exit;
    }
    if($_POST['action'] == 'editQuestion'){
        try {
            // Bắt đầu transaction
            $conn->begin_transaction();

            // Lấy dữ liệu từ request
            $questionID = $_POST['questionID'];
            $questionDescription = $_POST['questionDescription'];
            $level = $_POST['level'];
            $correctAnswer = $_POST['correctAnswer'];
            
            // Cập nhật thông tin câu hỏi
            $sql = "UPDATE Questions SET QuestionDescription = ?, Level = ? WHERE QuestionID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sii", $questionDescription, $level, $questionID);
            $stmt->execute();

            // Cập nhật các đáp án
            $answers = [
                'A' => ['id' => $_POST['answerIDA'], 'text' => $_POST['optionA']],
                'B' => ['id' => $_POST['answerIDB'], 'text' => $_POST['optionB']],
                'C' => ['id' => $_POST['answerIDC'], 'text' => $_POST['optionC']],
                'D' => ['id' => $_POST['answerIDD'], 'text' => $_POST['optionD']]
            ];

            $sql = "UPDATE Answers SET AnswerDescription = ?, AnswerStatus = ? WHERE AnswerID = ?";
            $stmt = $conn->prepare($sql);

            foreach($answers as $key => $answer) {
                $isCorrect = ($key == $correctAnswer) ? 1 : 0;
                $stmt->bind_param("sii", $answer['text'], $isCorrect, $answer['id']);
                $stmt->execute();

                // Lưu ID của đáp án đúng
                if($isCorrect) {
                    $correctAnswerID = $answer['id'];
                }
            }

            // Cập nhật QuestionAnswerID trong bảng Questions
            $sql = "UPDATE Questions SET QuestionAnswerID = ? WHERE QuestionID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $correctAnswerID, $questionID);
            $stmt->execute();

            // Commit transaction nếu mọi thứ OK
            $conn->commit();
            
            echo json_encode([
                'success' => true,
                'message' => 'Edit question'
            ]);
            exit;
        } catch(Exception $e) {
            // Rollback nếu có lỗi
            $conn->rollback();
            echo json_encode([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ]);
            exit;
        }
    }
    if($_POST['action'] == 'contestCreate'){
        $userID = $_SESSION['user_id'];
        $contestName = $_POST['contestName'];
        $school = $_POST['school'];
        $subject = $_POST['subject'];
        $createDate = date('Y-m-d');
        $duration = intval($_POST['duration']);
        $testDate = $_POST['examDate'];
        $questionBank = intval($_POST['questionBank']);
        $totalQuestions = intval($_POST['totalQuestions']);
        $easyQuestions = intval($_POST['easyQuestions']);
        $mediumQuestions = intval($_POST['mediumQuestions']);
        $hardQuestions = intval($_POST['hardQuestions']);
        $scorePerQuestion = floatval(10 / $totalQuestions);
        $testTimes = intval($_POST['testTimes']);
        $examMode = $_POST['examMode'];
        $password = $_POST['password'];
        $contestCode = generateCode(10);

        $sql = "INSERT INTO Contests (UserID, QuestionBankID, ContestName, School, Subject, CreateDate, TestDate, Longtime, TotalQuestions, EasyQuestions, MediumQuestions, HardQuestions, ScorePerQuestion, TestTimes, Type, ContestPassword, ContestCode) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iisssssiiiiidisss", $userID, $questionBank, $contestName, $school, $subject, $createDate, $testDate, $duration, $totalQuestions, $easyQuestions, $mediumQuestions, $hardQuestions, $scorePerQuestion, $testTimes, $examMode, $password, $contestCode);
        if($stmt->execute()){
            $contestID = $stmt->insert_id;
            $sql = "SELECT * FROM Questions WHERE QuestionBankID = ? AND Level = ? ORDER BY RAND() LIMIT ?";
            for($i = 1; $i <= 3; $i++){
                $stmt = $conn->prepare($sql);
                $limit = $i == 1 ? $easyQuestions : ($i == 2 ? $mediumQuestions : $hardQuestions);
                if($limit == 0){
                    continue;
                }else{
                    $check = "SELECT COUNT(*) FROM Questions WHERE QuestionBankID = ? AND Level = ?";
                    $stmtCheck = $conn->prepare($check);
                    $stmtCheck->bind_param("ii", $questionBank, $i);
                    $stmtCheck->execute();
                    $result = $stmtCheck->get_result();
                    $row = $result->fetch_assoc();
                    $total = $row['COUNT(*)'];
                    if($total < $limit){
                        echo json_encode([
                            'success' => false,
                            'message' => 'Không đủ câu hỏi'
                        ]);
                        exit;
                    }
                    $stmt->bind_param("iii", $questionBank, $i, $limit);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while($row = $result->fetch_assoc()){
                        $questionID = $row['QuestionID'];
                        $sql = "INSERT INTO ContestQuestions (ContestID, QuestionID) VALUES (?, ?)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("ii", $contestID, $questionID);
                        $stmt->execute();
                    }
                }
            }
            echo json_encode([
                'success' => true,
                'message' => 'Create contest'
            ]);
            exit;
        }
        echo json_encode([
            'success' => false,
            'message' => 'Could not create contest'
        ]);
        exit;
    }
    if($_POST['action'] == 'reviewContest'){
        $_SESSION['joinContest']['contestID'] = $_POST['contestID'];
        $_SESSION['joinContest']['type'] = 'review';
        echo json_encode([
            'success' => true,
            'message' => 'Review contest'
        ]);
        exit;
    }
    if($_POST['action'] == 'getContestQuestions'){
        $contestID = $_POST['contestID'];
        $sql = "SELECT * FROM ContestQuestions, Questions WHERE ContestQuestions.ContestID = ? AND ContestQuestions.QuestionID = Questions.QuestionID";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $contestID);
        if($stmt->execute()){
            $result = $stmt->get_result();
            $questions = [];
            while($row = $result->fetch_assoc()){
                $question = $row;
                $sql = "SELECT * FROM Answers WHERE QuestionID = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $question['QuestionID']);
                if($stmt->execute()){
                    $result1 = $stmt->get_result();
                    $answers = [];
                    while($row1 = $result1->fetch_assoc()){
                        $answers[] = $row1;
                    }
                    $question['Answer'] = $answers;
                    $questions[] = $question;
                }else{
                    echo json_encode([
                        'success' => false,
                        'message' => 'Could not get contest questions'
                    ]);
                    exit;
                }
            }
            echo json_encode([
                'success' => true,
                'questions' => $questions
            ]);
            exit;
        }
        echo json_encode([
            'success' => false,
            'message' => 'Could not get contest questions'
        ]);
        exit;
    }
    if($_POST['action'] == 'getContestInfo'){
        $contestID = $_POST['contestID'];
        $sql = "SELECT * FROM Contests WHERE ContestID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $contestID);
        if($stmt->execute()){
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            echo json_encode([
                'success' => true,
                'contestInfo' => $row
            ]);
            exit;
        }
        echo json_encode([
            'success' => false,
            'message' => 'Could not get contest info'
        ]);
        exit;
    }
    if($_POST['action'] == 'contestEdit'){
        $contestID = $_POST['contestID'];
        $contestName = $_POST['contestName'];
        $school = $_POST['school'];
        $subject = $_POST['subject'];
        $duration = $_POST['duration'];
        $examDate = $_POST['examDate'];
        $questionBank = $_POST['questionBank'];
        $totalQuestions = $_POST['totalQuestions'];
        $easyQuestions = $_POST['easyQuestions'];
        $mediumQuestions = $_POST['mediumQuestions'];
        $hardQuestions = $_POST['hardQuestions'];
        $examMode = $_POST['examMode'];
        $password = $_POST['password'];
        $testTimes = $_POST['testTimes'];

        $sql = "UPDATE Contests SET QuestionBankID = ?, ContestName = ?, School = ?, Subject = ?, Longtime = ?, TestDate = ?, TotalQuestions = ?, EasyQuestions = ?, MediumQuestions = ?, HardQuestions = ?, Type = ?, ContestPassword = ?, TestTimes = ? WHERE ContestID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssisiiiissii", $questionBank, $contestName, $school, $subject, $duration, $examDate, $totalQuestions, $easyQuestions, $mediumQuestions, $hardQuestions, $examMode, $password, $testTimes, $contestID);
        $result = $stmt->execute();
        if($result){
            echo json_encode(['success' => true]);
        }else{
            echo json_encode(['success' => false, 'error' => $conn->error]);
        }
        exit;
    }
    if($_POST['action'] == 'deleteContest'){
        $contestID = $_POST['contestID'];
        $sql = "DELETE FROM Contests WHERE ContestID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $contestID);
        $result = $stmt->execute();
        if($result){
            echo json_encode(['success' => true]);
        }else{
            echo json_encode(['success' => false, 'error' => $conn->error]);
        }
        exit;
    }
    if($_POST['action'] == 'loadJoinedContest'){
        $userID = $_POST['userID'];
        $sql = "SELECT * FROM JoiningContests, Contests WHERE JoiningContests.UserID = ? AND JoiningContests.ContestID = Contests.ContestID ORDER BY Contests.TestDate DESC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userID);
        if($stmt->execute()){
            $result = $stmt->get_result();
            $contests = [];
            while($row = $result->fetch_assoc()){
                $contests[] = $row;
            }
            echo json_encode(['success' => true, 'contests' => $contests]);
            exit;   
        }
        echo json_encode(['success' => false, 'error' => $conn->error]);
        exit;
    }
    if($_POST['action'] == 'searchContest'){
        $contestCode = $_POST['contestCode'];
        $sql = "SELECT * FROM Contests WHERE ContestCode = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $contestCode);
        if($stmt->execute()){
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            echo json_encode(['success' => true, 'contest' => $row]);
            exit;
        }
        echo json_encode(['success' => false, 'error' => $conn->error]);
        exit;
    }
}
if(isset($_GET['action'])){
    if($_GET['action'] == 'requestAddBank'){
        $_SESSION['bankMode'] = 'add';
        $_SESSION['questionsBankId'] = '';
        echo json_encode([
            'success' => true,
            'message' => 'Request add bank'
        ]);
        exit;
    }
}
// If no action matched, return an error
echo json_encode([
    'success' => false,
    'message' => 'Invalid action'
]);
exit;
?>