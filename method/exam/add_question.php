<?php
require("../m_question.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $description = $_POST['description'];
    $answer = $_POST['answer'];
    $topic = $_POST['topic'];  // Đổi từ 'category' thành 'topic'
    $type = $_POST['type'];
    $difficulty = $_POST['difficulty'];

    $question = new Question();
    $question->add_question($description, $answer, $topic, $type, $difficulty);  // Đổi 'category' thành 'topic'
    echo "Câu hỏi đã được thêm thành công!";
}
?>

<form method="post" action="add_question.php">
    <label for="description">Mô tả câu hỏi:</label>
    <textarea name="description" required></textarea><br>
    <label for="answer">Đáp án:</label>
    <input type="text" name="answer" required><br>
    <!-- Phân loại câu hỏi (thay 'category' bằng 'topic') -->
    <label for="topic">Phân loại câu hỏi:</label>
    <select name="topic" required>  <!-- Đổi 'category' thành 'topic' -->
        <option value="Địa lý">Địa lý</option>
        <option value="Lịch sử">Lịch sử</option>
        <option value="Khoa học">Khoa học</option>
        <option value="Toán học">Toán học</option>
    </select><br>
    <!-- Dạng câu hỏi -->
    <label for="type">Dạng câu hỏi:</label>
    <select name="type" required>
        <option value="Trắc nghiệm">Trắc nghiệm</option>
        <option value="Điền khuyết">Điền khuyết</option>
        <option value="Ghép nối">Ghép nối</option>
        <option value="Tự luận">Tự luận</option>
    </select><br>
    <label for="difficulty">Độ khó:</label>
    <select name="difficulty" required>
        <option value="1">Dễ</option>
        <option value="2">Trung bình</option>
        <option value="3">Khó</option>
    </select><br>
    <input type="submit" value="Thêm Câu Hỏi">
</form>
