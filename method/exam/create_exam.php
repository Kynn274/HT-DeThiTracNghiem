<?php
require_once("../m_question.php");
require_once("../Database.php");

session_start();

if (isset($_POST['submit'])) {
    $topic = $_POST['topic'];
    $type = $_POST['type'];
    $num_questions = $_POST['num_questions']; 

    $question = new Question();
    $questions = $question->get_random_questions($topic, $type, $num_questions);
    
    if ($questions) {
        $_SESSION['questions'] = $questions; // Lưu câu hỏi vào session
    } else {
        echo "Không có câu hỏi phù hợp!";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo đề thi</title>
</head>
<body>
<h2>Tạo Đề Thi Online</h2>
    
    <!-- Form chọn chủ đề và dạng câu hỏi -->
    <form method="post" action="creat_exam.php">
        <label for="topic">Chủ đề:</label>
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

        <label for="num_questions">Số lượng câu hỏi:</label>
        <input type="number" name="num_questions" min="1" max="100" value="10" required><br>

        <input type="submit" name="submit" value="Tạo Đề Thi">
    </form>

    <?php
    // Hiển thị câu hỏi nếu có
    if (isset($_SESSION['questions'])) {
        echo "<h3>Câu Hỏi Của Đề Thi:</h3>";
        echo "<form method='post' action='submit_exam.php'>";
        
        foreach ($_SESSION['questions'] as $index => $question) {
            echo "<div>";
            echo "<p><strong>Câu hỏi " . ($index + 1) . ": </strong>" . $question['qDescription'] . "</p>";
            
            // Hiển thị đáp án cho dạng Trắc nghiệm
            if ($question['qType'] == 'Trắc nghiệm') {
                $answers = json_decode($question['qAnswer'], true); // Giả sử đáp án là JSON
                foreach ($answers as $key => $answer) {
                    echo "<input type='radio' name='answer_" . $question['qID'] . "' value='" . $key . "'> " . $answer . "<br>";
                }
            }
            
            // Đối với các dạng câu hỏi khác, có thể thay thế với input khác (ví dụ: text cho điền khuyết)
            if ($question['qType'] != 'Trắc nghiệm') {
                echo "<input type='text' name='answer_" . $question['qID'] . "'><br>";
            }
            echo "</div>";
        }
        
        echo "<input type='submit' value='Nộp Đề Thi'>";
        echo "</form>";
    }
    ?>
</body>
</html>
