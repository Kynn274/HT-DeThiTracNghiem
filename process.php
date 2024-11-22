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
    // if($_POST['action'] == 'getQuestionsByQuestionBankID'){
    //     $questionBankID = $_POST['questionBankID'];
    //     if($questionBankID != ''){
    //         $sql = "SELECT QuestionID, QuestionDescription, QuestionAnswerID, Level FROM Questions WHERE QuestionBankID = ?";
    //         $stmt = $conn->prepare($sql);
    //         $stmt->bind_param("i", $questionBankID);
    //         if($stmt->execute()){
    //             $result = $stmt->get_result();
    //             $questions = [];
    //             while($row = $result->fetch_assoc()){
    //                 $questions[] = $row;
    //                 $sql = "SELECT AnswerID, AnswerDescription FROM Answers WHERE QuestionID = ?";
    //                 $stmt = $conn->prepare($sql);
    //                 $stmt->bind_param("i", $row['QuestionID']);
    //                 $stmt->execute();
    //                 $result = $stmt->get_result();
    //                 $answers = [];
    //                 while($answer = $result->fetch_assoc()){
    //                     $answers[] = $answer;
    //                 }
    //                 $questions[$index]['answers'] = $answers;
    //             }
    //             echo json_encode([
    //                 'success' => true,
    //                 'data' => $questions
    //             ]);
    //             exit;
    //         }else{
    //             echo json_encode([
    //                 'success' => false,
    //                 'message' => 'Could not get questions'
    //             ]);
    //             exit;
    //         }
    //     }else{
    //         echo json_encode([
    //             'success' => true,
    //             'data' => []
    //         ]);
    //         exit;
    //     }

    // }
    if($_POST['action'] == 'getBankInfoById'){
        $bankID = $_POST['bankID'];
        $sql = "SELECT * FROM QuestionsBank WHERE BankID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $bankID);
        if($stmt->execute()){
            $result = $stmt->get_result();
            $bank = $result->fetch_assoc();
            echo json_encode([
                'success' => true,
                'data' => $bank
            ]);
            exit;
        }
        echo json_encode([
            'success' => false,
            'message' => 'Could not get bank info'
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
        $createdDate = date('Y-m-d');
        $userID = $_SESSION['user_id'];
        echo $bankName;
        echo $subject;
        echo $createdDate;
        echo $userID;
        $sql = "INSERT INTO QuestionBanks (QuestionBankName, Subject, CreateDate, UserID) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $bankName, $subject, $createdDate, $userID);
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