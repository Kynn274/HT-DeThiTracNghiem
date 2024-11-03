<?php
    require_once("database.php");

    class User extends Database
    {
        // Tạo một người dùng mới và lưu cả thông tin vào bảng User và UserDetail
        public function create_1_user($username, $password, $fullname, $dob, $email, $phoneNumber, $type = 0)
        {
            // Mã hóa mật khẩu
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Thêm vào bảng User
            $sql = "INSERT INTO User (Username, Password, Type)
                    VALUES ('{$username}', '{$hashedPassword}', {$type})";
            $this->set_query($sql);
            $this->excute_query();

            // Lấy UserId vừa thêm
            $userId = $this->conn->insert_id;

            // Thêm chi tiết người dùng vào bảng UserDetail
            $sqlDetail = "INSERT INTO UserDetail (UserId, Fullname, DOB, Email, PhoneNumber)
                        VALUES ({$userId}, '{$fullname}', '{$dob}', '{$email}', '{$phoneNumber}')";
            $this->set_query($sqlDetail);
            $this->excute_query();

            $this->close();
        }
    }
?>
