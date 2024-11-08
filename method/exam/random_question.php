<?php
require("../m_question.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $topic = $_POST['topic']; // Lấy chủ đề từ form
    $type = $_POST['type'];   // Lấy dạng câu hỏi từ form
    $limit = 10; // Số câu hỏi muốn lấy ngẫu nhiên

    // Khởi tạo đối tượng Question
    $question = new Question();
    
    // Lấy ngẫu nhiên các câu hỏi theo chủ đề và dạng câu hỏi
    $random_questions = $question->get_random_questions($topic, $type, $limit);

    // Hiển thị câu hỏi ngẫu nhiên
    foreach ($random_questions as $q) {
        echo "<div><strong>{$q['qDescription']}</strong></div>";
        echo "<div>{$q['qAnswer']}</div>";
    }
}
?>

<form method="POST" action="create_exam.php">
    <label for="topic">Chủ đề câu hỏi:</label>
    <select name="topic" required>
        <option value="Địa lý">Địa lý</option>
        <option value="Lịch sử">Lịch sử</option>
        <option value="Khoa học">Khoa học</option>
        <option value="Toán học">Toán học</option>
    </select><br>

    <label for="type">Dạng câu hỏi:</label>
    <select name="type" required>
        <option value="Trắc nghiệm">Trắc nghiệm</option>
        <option value="Điền khuyết">Điền khuyết</option>
        <option value="Ghép nối">Ghép nối</option>
        <option value="Tự luận">Tự luận</option>
    </select><br>

    <input type="submit" value="Tạo đề thi">
</form>
