<?php
    // require_once '../models/m_contest.php';

    if(isset($_POST['action']) && $_POST['action'] == 'selectContest'){
        $contestID = $_POST['contestID'];

        $sql = "SELECT * FROM `Contests` WHERE `ContestID` = '$contestID'";
        $result = mysqli_query($conn, $sql);
        $contest = mysqli_fetch_assoc($result);

        echo json_encode($contest);
    }
?>