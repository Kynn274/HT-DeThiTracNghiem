<?php
require("../m_question.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $description = $_POST['description'];
    $answer = $_POST['answer'];
    $type = $_POST['type'];
    $difficulty = $_POST['difficulty'];

    $question = new Question();
    $question->add_question($description, $answer, $type, $difficulty);
    echo "Câu hỏi đã được thêm thành công!";
}
?>

<form method="post">
    <label for="description">Mô tả câu hỏi:</label>
    <textarea name="description" required></textarea><br>
    <label for="answer">Đáp án:</label>
    <input type="text" name="answer" required><br>
    <label for="type">Loại câu hỏi:</label>
    <input type="text" name="type" required><br>
    <label for="difficulty">Độ khó:</label>
    <select name="difficulty" required>
        <option value="1">Dễ</option>
        <option value="2">Trung bình</option>
        <option value="3">Khó</option>
    </select><br>
    <input type="submit" value="Thêm Câu Hỏi">
</form>
