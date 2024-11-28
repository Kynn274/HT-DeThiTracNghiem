<?php
    require_once './method/database.php';

    function generateCode($length) {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $code = '';
        $maxIndex = strlen($characters) - 1;
    
        for ($i = 0; $i < $length; $i++) {
            $index = random_int(0, $maxIndex);
            $code .= $characters[$index];
        }
    
        return $code;
    }

    if(isset($_POST['action']) && $_POST['action'] == 'contestCreate'){
        
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
?>