<?php
    require_once("database.php");

    class Test extends Database
    {
        // Thêm một đề thi mới
        public function add_test($title, $time, $numOfQuestions)
        {
            $sql = "INSERT INTO Test (tTitle, tTime, tNumOfQuest)
                    VALUES ('{$title}', {$time}, {$numOfQuestions})";
            $this->set_query($sql);
            $this->excute_query();
        }

        // Sửa thông tin đề thi
        public function update_test($testID, $title, $time, $numOfQuestions)
        {
            $sql = "UPDATE Test 
                    SET tTitle = '{$title}', tTime = {$time}, tNumOfQuest = {$numOfQuestions}
                    WHERE TestID = {$testID}";
            $this->set_query($sql);
            $this->excute_query();
        }

        // Xóa một đề thi
        public function delete_test($testID)
        {
            $sql = "DELETE FROM Test WHERE TestID = {$testID}";
            $this->set_query($sql);
            $this->excute_query();
        }

        // Lấy tất cả các đề thi
        public function get_all_tests()
        {
            $sql = "SELECT * FROM Test";
            $this->set_query($sql);
            return $this->excute_query();
        }

        // Random câu hỏi cho đề thi
        public function random_questions($numOfQuestions)
        {
            $sql = "SELECT * FROM Question ORDER BY RAND() LIMIT {$numOfQuestions}";
            $this->set_query($sql);
            return $this->excute_query();
        }
    }
?>
