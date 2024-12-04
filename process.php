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
            $_SESSION['user_fullname'] = $fullname;
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
                        $sql = "DELETE FROM Contests WHERE ContestID = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $contestID);
                        $stmt->execute();
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
    if($_POST['action'] == 'loadJoinedContest') {
        $userID = intval($_POST['userID']);
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $limit = 6; // Số cuộc thi mỗi trang
        $offset = ($page - 1) * $limit;
        
        // Kiểm tra userID
        if(!$userID) {
            echo json_encode([
                'success' => false, 
                'error' => 'Invalid userID',
                'message' => 'UserID is required'
            ]);
            exit;
        }

        // Đếm tổng số cuộc thi
        $countSql = "SELECT COUNT(*) as total FROM JoiningContests WHERE UserID = ?";
        $countStmt = $conn->prepare($countSql);
        $countStmt->bind_param("i", $userID);
        $countStmt->execute();
        $totalResult = $countStmt->get_result()->fetch_assoc();
        $total = $totalResult['total'];
        $totalPages = ceil($total / $limit);

        // Lấy danh sách cuộc thi theo trang
        $sql = "SELECT jc.*, c.* 
                FROM JoiningContests jc 
                INNER JOIN Contests c ON jc.ContestID = c.ContestID 
                WHERE jc.UserID = ? 
                ORDER BY jc.CreateDate DESC
                LIMIT ? OFFSET ?";
                
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $userID, $limit, $offset);
        
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
                    'totalPages' => $totalPages,
                    'currentPage' => $page,
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
        $createDate = date('Y-m-d');

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
                // Nếu chưa có bản ghi JoiningContests
                $sql = "SELECT * FROM Contests WHERE ContestID = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $contestID);
                
                if($stmt->execute()){
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
                    $testTimes = intval($row['TestTimes']) - 1;

                    $sql = "INSERT INTO JoiningContests (UserID, ContestID, TestTimes, CreateDate) VALUES (?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("iiis", $userID, $contestID, $testTimes, $createDate);
                    
                    if($stmt->execute()){
                        echo json_encode(['success' => true]);
                    }else{
                        echo json_encode([
                            'success' => false, 
                            'error' => $conn->error,
                            'message' => 'Could not create joining contest'
                        ]);
                    }
                    exit;
                }
            }
        }
        
        echo json_encode([
            'success' => false, 
            'error' => $conn->error,
            'message' => 'Could not check joining contest'
        ]);
        exit;
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
        $joiningContestID = $_POST['joiningContestID'];
        $questionsArray = $_POST['questionsArray'];
        $takingTime = $_POST['takingTime'];
        
        // Cập nhật thời gian làm bài (giờ lưu theo giây)
        $sql = "UPDATE JoiningContests SET TakingTime = ? WHERE JoiningContestID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $takingTime, $joiningContestID);
        $stmt->execute();
        
        // Tính điểm và lưu câu trả lời
        $correctAnswer = 0;
        foreach($questionsArray as $question) {
            $questionID = $question['QuestionID'];
            $selectedAnswer = $question['SelectedAnswer'];
            $isCorrect = 0;
            
            // Kiểm tra đáp án đúng
            if($selectedAnswer == $question['QuestionAnswerID']) {
                $correctAnswer++;
                $isCorrect = 1;
            }
            
            // Lưu câu trả lời
            $sql = "INSERT INTO JoiningContestAnswers (JoiningContestID, QuestionID, SelectedAnswer, IsCorrect) 
                    VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iiii", $joiningContestID, $questionID, $selectedAnswer, $isCorrect);
            $stmt->execute();
        }
        
        // Cập nhật số câu đúng
        $sql = "UPDATE JoiningContests SET CorrectAnswer = ? WHERE JoiningContestID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $correctAnswer, $joiningContestID);
        
        if($stmt->execute()) {
            echo json_encode([
                'success' => true,
                'message' => 'Nộp bài thành công'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Có lỗi xảy ra'
            ]);
        }
        exit;
    }
    if($_POST['action'] == 'moreTestTimes'){
        $userID = intval($_POST['userID']);
        $contestID = intval($_POST['contestID']);
        $sql = "UPDATE JoiningContests SET TestTimes = TestTimes + 1 WHERE UserID = ? AND ContestID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $userID, $contestID);
        if($stmt->execute()){
            echo json_encode(['success' => true]);
        }else{
            echo json_encode(['success' => false, 'error' => $conn->error]);
        }
        exit;
    }
    if($_POST['action'] == 'exportContestResult') {
        $contestID = $_POST['contestID'];
        
        // Lấy danh sách học sinh và thông tin cơ bản
        $sql = "SELECT 
                ud.UserID,
                ud.FullName,
                jc.JoiningContestID,
                jc.CreateDate as LastAttemptDate,
                jc.CorrectAnswer,
                jc.TakingTime,
                c.TotalQuestions,
                c.ContestName
                FROM JoiningContests jc
                INNER JOIN UserDetails ud ON jc.UserID = ud.UserID
                INNER JOIN Contests c ON jc.ContestID = c.ContestID
                WHERE jc.ContestID = ?
                GROUP BY ud.UserID";
                
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $contestID);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Tạo file CSV
        $filename = "KetQua_" . date('Y-m-d_H-i-s') . ".csv";
        
        // Headers để download file
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        // Tạo file handle
        $output = fopen('php://output', 'w');
        
        // Thêm BOM để Excel nhận diện UTF-8
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        $data = array();
        while($row = $result->fetch_assoc()) {
            // Lấy chi tiết câu hỏi và đáp án của mỗi học sinh
            $sql2 = "SELECT 
                    q.QuestionDescription,
                    jca.IsCorrect
                    FROM JoiningContestAnswers jca
                    INNER JOIN Questions q ON jca.QuestionID = q.QuestionID
                    WHERE jca.JoiningContestID = ?
                    ORDER BY q.QuestionID";
            
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param("i", $row['JoiningContestID']);
            $stmt2->execute();
            $result2 = $stmt2->get_result();
            
            $questionDetails = array();
            while($detail = $result2->fetch_assoc()) {
                $questionDetails[] = $detail['IsCorrect'] == 1 ? 'Đúng' : 'Sai';
            }
            
            $row['QuestionResults'] = $questionDetails;
            $data[] = $row;
        }
        
        // Tạo header cho file CSV
        $header = ['STT', 'Họ và tên', 'Ngày thi', 'Thời gian', 'Kết quả chung', 'Điểm'];
        
        // Thêm các cột câu hỏi vào header
        if(count($data) > 0 && isset($data[0]['QuestionResults'])) {
            for($i = 0; $i < count($data[0]['QuestionResults']); $i++) {
                $header[] = 'Câu ' . ($i + 1);
            }
        }
        
        // Ghi header vào file
        fputcsv($output, $header);
        
        // Ghi dữ liệu
        $stt = 1;
        foreach($data as $row) {
            $score = ($row['CorrectAnswer'] / $row['TotalQuestions']) * 100;
            $rowData = [
                $stt,
                $row['FullName'],
                $row['LastAttemptDate'],
                $row['TakingTime'],
                $row['CorrectAnswer'] . ' / ' . $row['TotalQuestions'] . ' câu',
                number_format($score, 2)
            ];
            
            // Thêm kết quả từng câu
            foreach($row['QuestionResults'] as $result) {
                $rowData[] = $result;
            }
            
            fputcsv($output, $rowData);
            $stt++;
        }
        $exportDate = date('Y-m-d');
        fputcsv($output, ['Ngày xuất file: ' . $exportDate]);
        fclose($output);
        exit();
    }
    if($_POST['action'] == 'previewContestResult') {
        $contestID = $_POST['contestID'];
        
        // Lấy danh sách học sinh và thông tin cơ bản
        $sql = "SELECT 
                ud.UserID,
                ud.FullName,
                jc.JoiningContestID,
                jc.CreateDate as LastAttemptDate,
                jc.CorrectAnswer,
                jc.TakingTime,
                c.TotalQuestions,
                c.ContestName
                FROM JoiningContests jc
                INNER JOIN UserDetails ud ON jc.UserID = ud.UserID
                INNER JOIN Contests c ON jc.ContestID = c.ContestID
                WHERE jc.ContestID = ?
                GROUP BY ud.UserID";
                
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $contestID);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $data = array();
        while($row = $result->fetch_assoc()) {
            // Lấy chi tiết câu hỏi và đáp án của mỗi học sinh
            $sql2 = "SELECT 
                    q.QuestionDescription,
                    jca.IsCorrect,
                    a.AnswerDescription as CorrectAnswerText,
                    (SELECT AnswerDescription FROM Answers WHERE AnswerID = jca.SelectedAnswer) as SelectedAnswerText
                    FROM JoiningContestAnswers jca
                    INNER JOIN Questions q ON jca.QuestionID = q.QuestionID
                    INNER JOIN Answers a ON q.QuestionAnswerID = a.AnswerID
                    WHERE jca.JoiningContestID = ?
                    ORDER BY q.QuestionID";
            
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param("i", $row['JoiningContestID']);
            $stmt2->execute();
            $result2 = $stmt2->get_result();
            
            $questionDetails = array();
            while($detail = $result2->fetch_assoc()) {
                $questionDetails[] = $detail;
            }
            
            $row['QuestionAndAnswer'] = $questionDetails;
            $data[] = $row;
        }
        
        echo json_encode([
            'success' => true,
            'data' => $data
        ]);
        exit();
    }
    if($_POST['action'] == 'sendMessage') {
        $userID = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        $senderName = $_POST['name'];
        $senderEmail = $_POST['email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];
        $messageContent = $subject . ' - ' . $message;
        $createDate = date('Y-m-d');

        $sql = "INSERT INTO Feedbacks (UserID, Name, Email, Message, CreateDate) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issss", $userID, $senderName, $senderEmail, $messageContent, $createDate);

        if($stmt->execute()) {
            echo json_encode([
                'success' => true,
                'message' => 'Gửi tin nhắn thành công!'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại!'
            ]);
        }
        exit;
    }
    if($_POST['action'] == 'getFeedbacks') {
        $userID = $_SESSION['user_id'];
        $userType = $_SESSION['user_type'];
        
        if($userType == 0) {
            // Admin sees all feedbacks
            $sql = "SELECT f.*, r.Reply, r.CreateDate as ReplyDate 
                    FROM Feedbacks f 
                    LEFT JOIN FeedbackReplies r ON f.FeedbackID = r.FeedbackID 
                    ORDER BY f.CreateDate DESC";
            $stmt = $conn->prepare($sql);
        } else {
            // Users see only their feedbacks
            $sql = "SELECT f.*, r.Reply, r.CreateDate as ReplyDate 
                    FROM Feedbacks f 
                    LEFT JOIN FeedbackReplies r ON f.FeedbackID = r.FeedbackID 
                    WHERE f.UserID = ? 
                    ORDER BY f.CreateDate DESC";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $userID);
        }
        
        if($stmt->execute()) {
            $result = $stmt->get_result();
            $feedbacks = array();
            while($row = $result->fetch_assoc()) {
                $feedbacks[] = $row;
            }
            echo json_encode([
                'success' => true,
                'feedbacks' => $feedbacks
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Không thể tải phản hồi'
            ]);
        }
        exit;
    }
    if($_POST['action'] == 'sendReply') {
        if($_SESSION['user_type'] != 0) {
            echo json_encode([
                'success' => false,
                'message' => 'Không có quyền thực hiện'
            ]);
            exit;
        }

        $feedbackID = $_POST['feedbackID'];
        $reply = $_POST['reply'];
        $createDate = date('Y-m-d');

        $sql = "INSERT INTO FeedbackReplies (FeedbackID, Reply, CreateDate) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $feedbackID, $reply, $createDate);

        if($stmt->execute()) {
            echo json_encode([
                'success' => true,
                'message' => 'Gửi phản hồi thành công'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Không thể gửi phản hồi'
            ]);
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