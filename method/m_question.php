<?php
    require_once("database.php");

    class Question extends Database
    {
        // Thêm một câu hỏi mới
        public function add_question($description, $answer, $type, $difficulty)
        {
            $sql = "INSERT INTO Question (qDescription, qAnswer, qType, qDifficulty)
                    VALUES ('{$description}', '{$answer}', '{$type}', {$difficulty})";
            $this->set_query($sql);
            $this->excute_query();
        }

        // Sửa câu hỏi
        public function update_question($questID, $description, $answer, $type, $difficulty)
        {
            $sql = "UPDATE Question 
                    SET qDescription = '{$description}', qAnswer = '{$answer}', qType = '{$type}', qDifficulty = {$difficulty}
                    WHERE QuestID = {$questID}";
            $this->set_query($sql);
            $this->excute_query();
        }

        // Xóa câu hỏi
        public function delete_question($questID)
        {
            $sql = "DELETE FROM Question WHERE QuestID = {$questID}";
            $this->set_query($sql);
            $this->excute_query();
        }

        // Lấy danh sách tất cả câu hỏi
        public function get_all_questions()
        {
            $sql = "SELECT * FROM Question";
            $this->set_query($sql);
            return $this->excute_query();
        }
    }
?>
