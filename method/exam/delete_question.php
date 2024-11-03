<?php
require("../m_question.php");

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $questID = $_POST['questID'];

        $question = new Question();
        $question->delete_question($questID);
        echo "Câu hỏi đã được xóa thành công!";
    }
?>

<form method="post">
    <input type="hidden" name="questID" value="<?php echo $_GET['questID']; ?>">
    <p>Bạn có chắc chắn muốn xóa câu hỏi này?</p>
    <input type="submit" value="Xóa Câu Hỏi">
</form>
