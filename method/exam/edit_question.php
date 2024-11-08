<?php
require("../m_question.php");
require("../init.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $questID = $_POST['questID'];
    $description = $_POST['description'];
    $answer = $_POST['answer'];
    $topic = $_POST['topic'];
    $type = $_POST['type'];
    $difficulty = $_POST['difficulty'];

    $question = new Question();
    try {
        $question->update_question($questID, $description, $answer, $topic, $type, $difficulty);
        echo "Cập nhật câu hỏi thành công!";
    } catch (Exception $e) {
        echo "Lỗi: " . $e->getMessage();
    }
}
?>
<h2>Chỉnh Sửa Câu Hỏi</h2>
<form method="post" action="edit_question.php">
    <input type="hidden" name="questID" value="<?php echo $questID; ?>">

    <label for="description">Mô tả câu hỏi:</label>
    <textarea name="description" required><?php echo $description; ?></textarea><br>

    <label for="answer">Đáp án:</label>
    <input type="text" name="answer" value="<?php echo $answer; ?>" required><br>

    <!-- Phân loại câu hỏi (thay 'category' bằng 'topic') -->
    <label for="topic">Phân loại câu hỏi:</label>
    <select name="topic" required>  <!-- Đổi 'category' thành 'topic' -->
        <option value="Địa lý" <?php echo ($topic == 'Địa lý') ? 'selected' : ''; ?>>Địa lý</option>
        <option value="Lịch sử" <?php echo ($topic == 'Lịch sử') ? 'selected' : ''; ?>>Lịch sử</option>
        <option value="Khoa học" <?php echo ($topic == 'Khoa học') ? 'selected' : ''; ?>>Khoa học</option>
        <option value="Toán học" <?php echo ($topic == 'Toán học') ? 'selected' : ''; ?>>Toán học</option>
    </select><br>

    <label for="type">Dạng câu hỏi:</label>
    <select name="type" required>
        <option value="Trắc nghiệm" <?php echo ($type == 'Trắc nghiệm') ? 'selected' : ''; ?>>Trắc nghiệm</option>
        <option value="Điền khuyết" <?php echo ($type == 'Điền khuyết') ? 'selected' : ''; ?>>Điền khuyết</option>
        <option value="Ghép nối" <?php echo ($type == 'Ghép nối') ? 'selected' : ''; ?>>Ghép nối</option>
        <option value="Tự luận" <?php echo ($type == 'Tự luận') ? 'selected' : ''; ?>>Tự luận</option>
    </select><br>

    <label for="difficulty">Độ khó:</label>
    <select name="difficulty" required>
        <option value="1" <?php echo ($difficulty == '1') ? 'selected' : ''; ?>>Dễ</option>
        <option value="2" <?php echo ($difficulty == '2') ? 'selected' : ''; ?>>Trung bình</option>
        <option value="3" <?php echo ($difficulty == '3') ? 'selected' : ''; ?>>Khó</option>
    </select><br>

    <input type="submit" value="Cập Nhật Câu Hỏi">
</form>