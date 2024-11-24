<?php
require_once './method/database.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Ensure all responses are JSON
header('Content-Type: application/json');

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

        // Bắt đầu transaction
        $conn->begin_transaction();
        try {
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
                echo json_encode([
                    'success' => true,
                    'message' => 'Add question to bank'
                ]);
                header('Location: questionsAddition.php');
                exit;
            }

            // Commit transaction
            $conn->commit();
            $_SESSION['currentBankId'] = $bankID;
            
            exit;
        } catch(Exception $e) {
            // Rollback nếu có lỗi
            $conn->rollback();
            echo "Có lỗi xảy ra: " . $e->getMessage();
        }
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