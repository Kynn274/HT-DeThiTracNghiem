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
        $questionID = intval($_POST['questionID']);
        
        // Xóa các answers liên quan
        $sql = "DELETE FROM Answers WHERE QuestionID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $questionID);
        $stmt->execute();
        
        // Xóa question
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
            'message' => 'Could not delete question',
            'error' => $conn->error
        ]);
        exit;
    }
    if($_POST['action'] == 'editQuestion'){
        

            // Lấy dữ liệu từ request
            $questionID = $_POST['questionID'];
            $questionDescription = $_POST['questionDescription'];
            $level = intval($_POST['level']);
            $correctAnswer = $_POST['correctAnswer'];
            
        // Cập nhật thông tin câu hỏi
        $sql = "UPDATE Questions SET QuestionDescription = ?, Level = ? WHERE QuestionID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sii", $questionDescription, $level, $questionID);
        if(!$stmt->execute()){
            echo json_encode([
                'success' => false,
                'message' => 'Could not edit question'
            ]);
            exit;
        }

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
                if(!$stmt->execute()){
                    echo json_encode([
                        'success' => false,
                        'message' => 'Could not edit question'
                    ]);
                    exit;
                }

                // Lưu ID của đáp án đúng
                if($isCorrect) {
                    $correctAnswerID = $answer['id'];
                }
            }

            // Cập nhật QuestionAnswerID trong bảng Questions
            $sql = "UPDATE Questions SET QuestionAnswerID = ? WHERE QuestionID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $correctAnswerID, $questionID);
            if($stmt->execute()){
                echo json_encode([
                    'success' => true,
                    'message' => 'Edit question'
                ]);
                exit;
            }

            echo json_encode([
                'success' => false,
                'message' => 'Could not edit question'
            ]);
        exit;
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
                    $sql = "SELECT * FROM Questions WHERE QuestionBankID = ? AND Level = ? ORDER BY RAND() LIMIT ?";
                    $stmt = $conn->prepare($sql);
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
            $sql = "SELECT * FROM Contests WHERE ContestID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $contestID);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            echo json_encode([
                'success' => true,
                'questions' => $questions,
                'contestInfo' => $row
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
        $userID = intval($_POST['userID']);
        
        // Kiểm tra userID
        if(!$userID) {
            echo json_encode([
                'success' => false, 
                'error' => 'Invalid userID',
                'message' => 'UserID is required'
            ]);
            exit;
        }

        $sql = "SELECT jc.*, c.* 
                FROM JoiningContests jc 
                INNER JOIN Contests c ON jc.ContestID = c.ContestID 
                WHERE jc.UserID = ? 
                ORDER BY jc.CreateDate DESC";
                
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userID);
        
        try {
            if($stmt->execute()){
                $result = $stmt->get_result();
                $contests = [];
                while($row = $result->fetch_assoc()){
                    $contests[] = $row;
                }
                echo json_encode([
                    'success' => true, 
                    'contests' => $contests,
                    'userID' => $userID
                ]);
                exit;   
            } else {
                throw new Exception($conn->error);
            }
        } catch(Exception $e) {
            echo json_encode([
                'success' => false, 
                'error' => $e->getMessage(),
                'message' => 'Could not load joined contests',
                'userID' => $userID,
                'sql' => $sql
            ]);
            exit;
        }
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
    if($_POST['action'] == 'startExam'){
        $userID = $_POST['userID'];
        $contestID = $_POST['contestID'];
        $sql = "SELECT * FROM JoiningContests WHERE UserID = ? AND ContestID = ? ORDER BY JoiningContestID DESC LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $userID, $contestID);
        if($stmt->execute()){
            $result = $stmt->get_result();
            if($result->num_rows > 0){
                $row = $result->fetch_assoc();
                $joiningContestID = intval($row['JoiningContestID']);
                $testTimes = intval($row['TestTimes']);
                if($testTimes > 0){
                    $testTimes--;
                    $sql = "UPDATE JoiningContests SET TestTimes = ? WHERE JoiningContestID = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ii", $testTimes, $joiningContestID);
                    if($stmt->execute()){
                        echo json_encode(['success' => true]);
                    }else{
                        echo json_encode(['success' => false, 'message' => 'Could not update test times']);
                    }
                    exit;
                }else{
                    echo json_encode(['success' => false, 'message' => 'You have reached the maximum number of attempts']);
                    exit;
                }
            }else{
                $sql = "SELECT * FROM Contests WHERE ContestID = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $contestID);
                if($stmt->execute()){
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
                    $testTimes = intval($row['TestTimes']);
                    $sql = "INSERT INTO JoiningContests (UserID, ContestID, TestTimes, CreateDate) VALUES (?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("iiis", $userID, $contestID, $testTimes, $createDate);
                    if($stmt->execute()){
                        echo json_encode(['success' => true]);
                        exit;
                    }else{
                        echo json_encode(['success' => false, 'error' => $conn->error]);
                        exit;
                    }
                }else{
                    echo json_encode(['success' => false, 'error' => $conn->error]);
                    exit;
                }
            }else{
                echo json_encode(['success' => false, 'error' => $conn->error]);
                exit;
            }
        }else{
            echo json_encode(['success' => false, 'error' => $conn->error]);
            exit;
        }
    }
    if($_POST['action'] == 'getJoiningContestID'){
        $userID = intval($_POST['userID']);
        $contestID = intval($_POST['contestID']);
        $sql = "SELECT * FROM JoiningContests WHERE UserID = ? AND ContestID = ? ORDER BY JoiningContestID DESC LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $userID, $contestID);
        if($stmt->execute()){
            $result = $stmt->get_result();
            $joiningContestID = 0;
            if($result->num_rows > 0){
                $row = $result->fetch_assoc();
                $joiningContestID = intval($row['JoiningContestID']);
            }else{
                echo json_encode([
                    'success' => false,
                    'message' => 'Could not get joining contest ID',
                ]);
                exit;
            }
            echo json_encode([
                'success' => true,
                'joiningContestID' => $joiningContestID
            ]);
            exit;
        }
        echo json_encode(['success' => false, 'error' => $conn->error]);
        exit;
    }
    if($_POST['action'] == 'submitAnswer'){
        $joiningContestID = intval($_POST['joiningContestID']);
        $questionsArray = $_POST['questionsArray'];
        $questionAndAnswer = [];
        $correctAnswer = 0;
        $totalQuestions = count($questionsArray);
        //  Xử lý dữ liệu
        $i = 0;
        foreach($questionsArray as $question){
            $questionAndAnswer[] = [
                'questionID' => intval($question['QuestionID']),
                'selectedAnswer' => intval($question['SelectedAnswer']),
                'isCorrect' => intval($question['SelectedAnswer'] == $question['QuestionAnswerID'] ? 1 : 0)
            ];
            
            if($questionAndAnswer[$i]['isCorrect'] == 1){
                $correctAnswer++;
            }
            $i++;
        }
        $sql = "INSERT INTO JoiningContestAnswers (JoiningContestID, QuestionID, SelectedAnswer, IsCorrect) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        foreach($questionAndAnswer as $question){
            $stmt->bind_param("iiii", $joiningContestID, $question['questionID'], $question['selectedAnswer'], $question['isCorrect']);
            if(!$stmt->execute()){
                echo json_encode(['success' => false, 'error' => $conn->error]);
                exit;
            }
        }
        $score = floatval($correctAnswer/$totalQuestions) * 10;
        $sql = "UPDATE JoiningContests SET Score = ?, CorrectAnswer = ? WHERE JoiningContestID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $score, $correctAnswer, $joiningContestID);
        if($stmt->execute()){
            echo json_encode(['success' => true]);
        }else{
            echo json_encode(['success' => false, 'error' => $conn->error]);
        }
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