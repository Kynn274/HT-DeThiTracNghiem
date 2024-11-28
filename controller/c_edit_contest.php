<?php
    // require_once '../models/m_contest.php';
    require_once './method/database.php';

    if(isset($_POST['action']) && $_POST['action'] == 'contestEdit'){
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
?>