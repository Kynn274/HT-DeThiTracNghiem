<?php
    // require_once("database.php");

    // class Question extends Database
    // {
    //     // Thêm câu hỏi với chủ đề và dạng câu hỏi
    //     public function add_question($description, $answer, $topic, $type, $difficulty)
    //     {
    //         if (!in_array($difficulty, [1, 2, 3])) {
    //             throw new Exception("Độ khó không hợp lệ. Chỉ chấp nhận 1 (Dễ), 2 (Trung), hoặc 3 (Khó).");
    //         }

    //         // Escape dữ liệu đầu vào để tránh SQL Injection
    //         $description = $this->escape_string($description);
    //         $answer = $this->escape_string($answer);
    //         $topic = $this->escape_string($topic);
    //         $type = $this->escape_string($type);

    //         $sql = "INSERT INTO Question (qDescription, qAnswer, qTopic, qType, qDifficulty)
    //                 VALUES ('{$description}', '{$answer}', '{$topic}', '{$type}', {$difficulty})";

    //         $this->set_query($sql);
    //         $this->excute_query();
    //     }

    //     // Cập nhật câu hỏi với chủ đề và dạng câu hỏi
    //     public function update_question($questID, $description, $answer, $topic, $type, $difficulty)
    //     {
    //         if (!in_array($difficulty, [1, 2, 3])) {
    //             throw new Exception("Độ khó không hợp lệ. Chỉ chấp nhận 1 (Dễ), 2 (Trung), hoặc 3 (Khó).");
    //         }

    //         // Escape dữ liệu đầu vào
    //         $description = $this->escape_string($description);
    //         $answer = $this->escape_string($answer);
    //         $topic = $this->escape_string($topic);
    //         $type = $this->escape_string($type);

    //         $sql = "UPDATE Question 
    //                 SET qDescription = '{$description}', qAnswer = '{$answer}', qTopic = '{$topic}', 
    //                     qType = '{$type}', qDifficulty = {$difficulty}
    //                 WHERE QuestID = {$questID}";

    //         $this->set_query($sql);
    //         $this->excute_query();
    //     }

    //     // Phương thức lấy câu hỏi ngẫu nhiên theo chủ đề và dạng câu hỏi
    //     public function get_random_questions($topic, $type, $limit = 10) {
    //         $sql = "SELECT * FROM questions WHERE qTopic = '$topic' AND qType = '$type' ORDER BY RAND() LIMIT $limit";
    //         $result = $this->conn->query($sql);
    //         return $result->fetch_all(MYSQLI_ASSOC); // Lấy tất cả câu hỏi ngẫu nhiên
    //     }

    //     // Xóa câu hỏi
    //     public function delete_question($questID)
    //     {
    //         $sql = "DELETE FROM Question WHERE QuestID = {$questID}";
    //         $this->set_query($sql);
    //         $this->excute_query();
    //     }

    //     // Lấy danh sách tất cả câu hỏi
    //     public function get_all_questions()
    //     {
    //         $sql = "SELECT * FROM Question";
    //         $this->set_query($sql);
    //         return $this->excute_query();
    //     }

    //     // Hàm escape để bảo vệ dữ liệu nhập vào
    //     private function escape_string($data)
    //     {
    //         return mysqli_real_escape_string($this->get_connection(), $data);
    //     }
    // }
?>