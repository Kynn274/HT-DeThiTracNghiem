<?php
require_once("../m_question.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $answers = [];

    foreach ($_SESSION['questions'] as $question) {
        $questionID = $question['qID'];
        if (isset($_POST['answer_' . $questionID])) {
            $answers[$questionID] = $_POST['answer_' . $questionID];
        }
    }

    // Xử lý kết quả (ví dụ: tính điểm, lưu kết quả vào cơ sở dữ liệu...)
    echo "<h3>Kết Quả Đề Thi:</h3>";
    foreach ($answers as $questionID => $answer) {
        echo "Câu hỏi " . $questionID . ": Đáp án của bạn là " . $answer . "<br>";
    }
}
?>
