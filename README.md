# MindBridge Institute - Hệ Thống Thi Trực Tuyến

## Giới Thiệu
MindBridge Institute là nền tảng trực tuyến chuyên biệt cho phép giáo viên tạo và tổ chức các bài kiểm tra, đề thi một cách dễ dàng và hiệu quả. Hệ thống được thiết kế để đáp ứng nhu cầu đánh giá năng lực học sinh thông qua các bài kiểm tra trực tuyến.

## Tính Năng Chính

### Dành Cho Giáo Viên
- **Quản Lý Ngân Hàng Câu Hỏi**
  - Tạo và quản lý câu hỏi theo môn học
  - Phân loại độ khó (Dễ, Trung bình, Khó)
  - Tùy chỉnh đáp án và giải thích

- **Tạo Đề Thi**
  - Tạo đề thi với nhiều định dạng
  - Tùy chỉnh thời gian làm bài
  - Thiết lập số lượng câu hỏi và độ khó
  - Xuất đề thi dạng PDF

- **Quản Lý Cuộc Thi**
  - Tạo và quản lý các kỳ thi
  - Thiết lập thời gian thi
  - Kiểm soát số lần thi lại
  - Theo dõi tiến trình thi

- **Thống Kê và Báo Cáo**
  - Xem kết quả chi tiết từng học sinh
  - Phân tích thống kê kết quả
  - Xuất báo cáo dạng CSV
  - Đánh giá hiệu quả đề thi

### Dành Cho Học Sinh
- Tham gia các kỳ thi trực tuyến
- Xem kết quả ngay sau khi nộp bài
- Theo dõi lịch sử làm bài
- Gửi phản hồi cho giáo viên

## Yêu Cầu Hệ Thống
- PHP 7.4 trở lên
- MySQL 5.7 trở lên
- Web Server (Apache/Nginx)
- Modern Web Browser (Chrome, Firefox, Safari)

## Cài Đặt
1. Clone repository về máy local
2. Import file database từ thư mục `database`
3. Cấu hình kết nối database trong file `method/database.php`
4. Cấu hình domain trong file config
5. Khởi chạy ứng dụng

## Cấu Trúc Thư Mục 
mindbridge/
├── css/ # Style sheets
├── js/ # JavaScript files
├── images/ # Image assets
├── method/ # Core PHP functions
├── database/ # Database scripts
└── README.md # This file

## Công Nghệ Sử Dụng
- Frontend: HTML5, CSS3, JavaScript, jQuery, Bootstrap 5
- Backend: PHP, MySQL
- Libraries: html2pdf, DataTables, Chart.js

## Tính Năng Bảo Mật
- Mã hóa mật khẩu
- Phân quyền người dùng
- Bảo vệ form submission
- Chống SQL injection
- Session management

## Người Đóng Góp
- [Phạm Thiên Kim]
- [kimpham22072004@gmail.com]
- [Dương Bảo Trân]
- [Nguyễn Văn Hậu]
- [Huỳnh Thị Ngọc Hương]

## License
[Loại giấy phép]

## Liên Hệ Hỗ Trợ
Nếu bạn có bất kỳ câu hỏi hoặc góp ý nào, vui lòng liên hệ:
- Email: [kimpham22072004@gmail.com]
- Website: [website]
- Tel: [0967785209]

