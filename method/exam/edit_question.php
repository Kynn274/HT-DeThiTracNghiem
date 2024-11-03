<?php
require("../m_question.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $QuestID = $_POST['QuestID'];
    $qDescription = $_POST['qDescription'];
    $qAnswer = $_POST['qAnswer'];
    $qType = $_POST['qType'];
    $qDifficulty = $_POST['qDifficulty'];

    $question = new Question();
    $question->update_question($QuestID, $qDescription, $qAnswer, $qType, $qDifficulty);
    echo "Câu hỏi đã được cập nhật thành công trong hệ thống!";
}
?>

<h2>Chỉnh Sửa Câu Hỏi</h2>
<form method="post" action="">
    <label>ID câu hỏi:</label>
    <input type="number" name="QuestID" required><br>
    <label>Mô tả câu hỏi:</label>
    <input type="text" name="qDescription" required><br>
    <label>Đáp án:</label>
    <input type="text" name="qAnswer" required><br>
    <label>Loại câu hỏi:</label>
    <input type="text" name="qType" required><br>
    <label>Độ khó:</label>
    <select name="qDifficulty" required>
        <option value="1">Dễ</option>
        <option value="2">Trung bình</option>
        <option value="3">Khó</option>
    </select><br>
    <input type="submit" value="Cập Nhật Câu Hỏi">
</form>
