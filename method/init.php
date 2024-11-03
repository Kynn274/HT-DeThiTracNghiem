<?php

    require_once("database.php");

    class initDatabase extends Database
    {
        public function create_structure()
        {
            // Tạo bảng User
            $sql = "CREATE TABLE IF NOT EXISTS User (
                UserId INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                Username VARCHAR(50) NOT NULL UNIQUE,
                Password VARCHAR(255) NOT NULL,
                Type INT(1) NOT NULL DEFAULT 0
            )";
            $this->set_query($sql);
            $this->excute_query();

            // Tạo bảng UserDetail
            $sql = "CREATE TABLE IF NOT EXISTS UserDetail (
                UserId INT(11) UNSIGNED PRIMARY KEY,
                Fullname VARCHAR(100),
                DOB DATE,
                Email VARCHAR(100),
                PhoneNumber VARCHAR(15),
                FOREIGN KEY (UserId) REFERENCES User(UserId) ON DELETE CASCADE
            )";
            $this->set_query($sql);
            $this->excute_query();

            // Tạo bảng Question với độ khó từ 1 đến 3
            $sql = "CREATE TABLE IF NOT EXISTS Question (
                QuestID INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                qDescription TEXT NOT NULL,
                qAnswer VARCHAR(255) NOT NULL,
                qType VARCHAR(50) NOT NULL,
                qDifficulty ENUM('1', '2', '3') NOT NULL COMMENT '1=Dễ, 2=Trung, 3=Khó'
            )";
            $this->set_query($sql);
            $this->excute_query();

            // Tạo bảng Test
            $sql = "CREATE TABLE IF NOT EXISTS Test (
                TestID INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                tTitle VARCHAR(100) NOT NULL,
                tTime INT(4) NOT NULL,
                tNumOfQuest INT(3) NOT NULL
            )";
            $this->set_query($sql);
            $this->excute_query();

            $this->close();

            echo "INIT COMPLETE";
        }
    }

    $myinit = new initDatabase();
    $myinit->create_structure();

?>
