<?php
    $conn = require 'database.php';

    $tableQueries = [
        // Tạo bảng người dùng
        "CREATE TABLE IF NOT EXISTS Users (
	        UserID INT AUTO_INCREMENT PRIMARY KEY, -- Mã người dùng
	        Username NVARCHAR(100) NOT NULL, -- Tên đăng nhập người dùng
	        Password NVARCHAR(100) NOT NULL, -- Mật khẩu người dùng
	        Type INT NOT NULL DEFAULT 1, -- Loại người dùng (0: Admin, 1: Học sinh, 2: Giáo viên)
	        JoiningDate DATE, -- Ngày tham gia
			Status INT NOT NULL DEFAULT 1 -- Trạng thái người dùng (0: Hạn chế, 1: Hoạt động)	
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

        // Tạo bảng thông tin người dùng
        "CREATE TABLE IF NOT EXISTS UserDetails(
	        UserDetailID INT AUTO_INCREMENT PRIMARY KEY, -- Mã thông tin người dùng
	        UserID INT NOT NULL, -- Mã người dùng
	        Fullname NVARCHAR(500), -- Tên đầy đủ người dùng
	        Email NVARCHAR(100), -- Email
	        PhoneNumber NVARCHAR(20), -- Số điện thoại người dùng
	        DateOfBirth DATE, -- Ngày sinh
	        Avatar VARCHAR(100), -- Ảnh đại diện
	        Evidence VARCHAR(100), -- Xác nhận nghề nghiệp
            FOREIGN KEY (UserID) REFERENCES Users(UserId) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

        // Tạo bảng phản hồi
        "CREATE TABLE IF NOT EXISTS Feedbacks (
	        FeedbackID INT AUTO_INCREMENT PRIMARY KEY, -- Mã phản hồi
	        UserID INT NOT NULL, -- Mã tài khoản phản hồi
	        Name NVARCHAR(500), -- Tên người phản hồi
	        Email NVARCHAR(100), -- Email người phản hồi
	        Message NVARCHAR(1000), -- Nội dung phản hồi
			CreateDate DATE, -- Ngày tạo
            FOREIGN KEY (UserID) REFERENCES Users(UserId) ON DELETE CASCADE
        )ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

        // Tạo bảng ngân hàng câu hỏi
        "CREATE TABLE IF NOT EXISTS QuestionBanks(
	        QuestionBankID INT AUTO_INCREMENT PRIMARY KEY, -- Mã ngân hàng câu hỏi
	        UserID INT NOT NULL, -- Mã người tạo
	        QuestionBankName NVARCHAR(500) NOT NULL, -- Tên ngân hàng câu hỏi
	        Subject NVARCHAR(100), -- Môn học
	        CreateDate DATE, -- Ngày tạo ngân hàng câu hỏi
	        TotalNumber INT NOT NULL DEFAULT 0, -- Số lượng câu hỏi trong ngân hàng câu hỏi
            FOREIGN KEY (UserID) REFERENCES Users(UserId) ON DELETE CASCADE
        )ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

        //  Tạo bảng câu hỏi
        "CREATE TABLE IF NOT EXISTS Questions(
	        QuestionID INT AUTO_INCREMENT PRIMARY KEY, -- Mã câu hỏi
	        QuestionBankID INT NOT NULL, -- Mã ngân hàng câu hỏi thuộc về
	        QuestionDescription NVARCHAR(1000) NOT NULL, -- Mô tả câu hỏi
			QuestionAnswerID INT NOT NULL DEFAULT 0, -- Mã đáp án đúng
	        Level INT NOT NULL, -- Độ khó của câu hỏi (1: Dễ, 2: Trung bình, 3: Khó) 
            FOREIGN KEY (QuestionBankID) REFERENCES QuestionBanks(QuestionBankID) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

        // Tạo bảng đáp án
        "CREATE TABLE IF NOT EXISTS Answers(
	        AnswerID INT AUTO_INCREMENT PRIMARY KEY, -- Mã đáp án
	        QuestionID INT NOT NULL, -- Mã câu hỏi của đáp án
	        AnswerDescription	NVARCHAR(1000) NOT NULL, -- Mô tả câu trả lời
	        AnswerStatus INT NOT NULL DEFAULT 0, -- Trạng thái câu trả lời (Đúng / Sai)
            FOREIGN KEY (QuestionID) REFERENCES Questions(QuestionID) ON DELETE CASCADE
        )ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

        // Tạo bảng đề thi / cuộc thi
        "CREATE TABLE IF NOT EXISTS Contests(
	        ContestID INT AUTO_INCREMENT PRIMARY KEY, -- Mã cuộc thi
	        UserID INT NOT NULL, -- Mã người tạo
	        QuestionBankID INT NOT NULL, -- Mã ngân hàng câu hỏi lấy câu hỏi
	        ContestName NVARCHAR(500) NOT NULL, -- Tên cuộc thi
	        School NVARCHAR(100), -- Tên trường
	        Subject NVARCHAR(100), -- Tên môn
	        CreateDate DATE NOT NULL, -- Ngày tạo
	        TestDate DATE NOT NULL, -- Ngày thi
	        Longtime INT NOT NULL, -- Thời gian thi (phút)
	        TotalQuestions INT NOT NULL, -- Tổng số lượng câu hỏi
	        EasyQuestions INT NOT NULL DEFAULT 0, -- Số lượng câu dễ
	        MediumQuestions INT NOT NULL DEFAULT 0, -- Số lượng câu hỏi trung bình
	        HardQuestions INT NOT NULL DEFAULT 0, -- Số lượng câu hỏi khó
	        ScorePerQuestion DECIMAL(5,2) DEFAULT 0, -- Số điểm 1 câu hỏi
	        Status INT NOT NULL DEFAULT 1, -- Trạng thái cuộc thi (0: không hoạt động, 1: hoạt động)
	        TestTimes INT NOT NULL DEFAULT 1, -- Số lần thi 
	        Type NVARCHAR(100) NOT NULL DEFAULT N'Contest', -- Loại xuất (PDF, Contest)
	        ContestPassword NVARCHAR(100), -- Mật khẩu cuộc thi
	        ContestCode NVARCHAR(100), -- Mã cuộc thi
            FOREIGN KEY (UserID) REFERENCES Users(UserId) ON DELETE CASCADE,
            FOREIGN KEY (QuestionBankID) REFERENCES QuestionBanks(QuestionBankID) ON DELETE CASCADE
        )ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

		// Tạo bảng câu hỏi đề thi
		"CREATE TABLE IF NOT EXISTS ContestQuestions(
			ContestID INT NOT NULL, -- Mã cuộc thi
			QuestionID INT NOT NULL, -- Mã câu hỏi
            FOREIGN KEY (ContestID) REFERENCES Contests(ContestID) ON DELETE CASCADE,
            FOREIGN KEY (QuestionID) REFERENCES Questions(QuestionID) ON DELETE CASCADE
		)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

        // Tạo bảng tham gia cuộc thi
        "CREATE TABLE IF NOT EXISTS JoiningContests(
	        JoiningContestID INT AUTO_INCREMENT PRIMARY KEY, -- Mã tham gia cuộc thi
	        UserID INT NOT NULL, -- Mã người tham gia cuộc thi
	        ContestID INT NOT NULL, -- Mã cuộc thi
	        TakingTime INT DEFAULT 0, -- Thời gian tiêu tốn để làm bài (tính bằng giây)
			CorrectAnswer INT DEFAULT 0, -- Số câu đúng
	        Score DECIMAL(5,2) DEFAULT 0, -- Điểm thi
			CreateDate DATE, -- Ngày tham gia
			TestTimes INT NOT NULL DEFAULT 0, -- Số lần thi
            FOREIGN KEY (UserID) REFERENCES Users(UserId) ON DELETE CASCADE,
            FOREIGN KEY (ContestID) REFERENCES Contests(ContestID) ON DELETE CASCADE
        )ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
        
		// Tạo bảng đáp án thi
		"CREATE TABLE IF NOT EXISTS JoiningContestAnswers(
			JoiningContestID INT NOT NULL, -- Mã tham gia cuộc thi
			QuestionID INT NOT NULL, -- Mã câu hỏi
			SelectedAnswer INT NOT NULL, -- Mã đáp án đã chọn
			IsCorrect INT NOT NULL DEFAULT 0, -- Trạng thái đúng / sai
            FOREIGN KEY (JoiningContestID) REFERENCES JoiningContests(JoiningContestID) ON DELETE CASCADE,
            FOREIGN KEY (QuestionID) REFERENCES Questions(QuestionID) ON DELETE CASCADE
		)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

        // Tạo bảng bảng điểm
        "CREATE TABLE IF NOT EXISTS ScoreTables(
	        ScoreTableID INT AUTO_INCREMENT PRIMARY KEY, -- Mã bảng điểm
	        ContestID INT NOT NULL, -- Mã cuộc thi tham gia
	        CreateDate DATE, -- Ngày tạo
            AverageScore DECIMAL(5,2) DEFAULT 0, -- Điểm trung bình
            TotalNumber INT DEFAULT 0, -- Số lượng tham gia
            LowerFive INT, -- Số lượng điểm dưới 5
            GreaterNine INT, -- Số lượng điểm lớn hơn hoặc bằng 9
            FOREIGN KEY (ContestID) REFERENCES Contests(ContestID) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

		// Tạo bảng yêu cầu khôi phục mật khẩu
		"CREATE TABLE IF NOT EXISTS ResetPasswordRequests(
			ResetPasswordRequestID INT AUTO_INCREMENT PRIMARY KEY, -- Mã yêu cầu khôi phục mật khẩu
			UserID INT NOT NULL, -- Mã người dùng
			CreateDate DATE, -- Ngày tạo
            FOREIGN KEY (UserID) REFERENCES Users(UserID) ON DELETE CASCADE
		)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

		// Tạo bảng phản hồi
        "CREATE TABLE IF NOT EXISTS FeedbackReplies (
            ReplyID INT AUTO_INCREMENT PRIMARY KEY,
            FeedbackID INT NOT NULL,
            Reply TEXT,
            CreateDate DATE,
            FOREIGN KEY (FeedbackID) REFERENCES Feedbacks(FeedbackID) ON DELETE CASCADE
        )ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
    ];

    foreach ($tableQueries as $tableQuery) {
        if ($conn->query($tableQuery) !== TRUE) {
            die("Error creating table: " . $conn->error);
        }
    }

    $conn->close();
?>
