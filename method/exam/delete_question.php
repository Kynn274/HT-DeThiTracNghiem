<?php
require_once("../m_question.php");
require_once("../init.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['questID']) && !empty($_POST['questID'])) {
        $questID = $_POST['questID'];
        $question = new Question();
        try {
            $question->delete_question($questID);
            echo "Câu hỏi đã được xóa thành công!";
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    } else {
        echo "Không tìm thấy ID câu hỏi.";
    }
}
?>

<h2>Xóa Câu Hỏi</h2>
<form method="post">
    <!-- ID câu hỏi (ẩn) -->
    <input type="hidden" name="questID" value="<?php echo isset($_GET['questID']) ? $_GET['questID'] : ''; ?>">
    <p>Bạn có chắc chắn muốn xóa câu hỏi này?</p>
    <input type="submit" value="Xóa Câu Hỏi">
</form>
