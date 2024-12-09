# Hệ Thống Thi Trực Tuyến

## Công Nghệ Sử Dụng

### Frontend
- **HTML5/CSS3:** Xây dựng giao diện người dùng
- **JavaScript/jQuery:** Xử lý tương tác và hiệu ứng
- **Bootstrap 5:** Framework CSS cho giao diện responsive
- **AJAX:** Giao tiếp với backend không đồng bộ
- **Font Awesome & Bootstrap Icons:** Thư viện icon

### Backend
- **PHP:** Ngôn ngữ lập trình phía server
- **MySQL:** Hệ quản trị cơ sở dữ liệu
- **Apache:** Web server
- **PHPMailer:** Thư viện gửi email
- **PHP Sessions:** Quản lý phiên đăng nhập

## Yêu Cầu Phần Cứng & Phần Mềm

### Yêu Cầu Tối Thiểu
- **CPU:** Intel Core i3 hoặc AMD tương đương
- **RAM:** 4GB
- **Ổ cứng:** 10GB dung lượng trống
- **Kết nối mạng:** Tốc độ tối thiểu 5Mbps
- **Màn hình:** Độ phân giải 1366x768
- **Trình duyệt:** Chrome 88+, Firefox 85+, Edge 88+ hoặc Safari 14+

### Yêu Cầu Khuyến Nghị
- **CPU:** Intel Core i5/AMD Ryzen 5 hoặc cao hơn
- **RAM:** 8GB hoặc cao hơn
- **Ổ cứng:** 20GB dung lượng trống hoặc nhiều hơn
- **Kết nối mạng:** Tốc độ từ 10Mbps trở lên
- **Màn hình:** Độ phân giải 1920x1080 hoặc cao hơn
- **Trình duyệt:** Phiên bản mới nhất của Chrome, Firefox, Edge hoặc Safari

### Yêu Cầu Phần Mềm Server
- **Hệ điều hành:** Windows Server 2016/2019, Ubuntu 18.04/20.04 LTS
- **Web Server:** Apache 2.4+ hoặc Nginx 1.18+
- **PHP:** Phiên bản 7.4+ (Khuyến nghị PHP 8.0+)
- **MySQL:** Phiên bản 5.7+ (Khuyến nghị MySQL 8.0+)
- **SSL Certificate:** Yêu cầu cho bảo mật HTTPS

### Yêu Cầu Phần Mềm Client
- **Hệ điều hành:** Windows 10/11, macOS 10.15+, Ubuntu 18.04+
- **Trình duyệt web hiện đại với các tính năng:**
  - JavaScript được bật
  - Cookies được cho phép
  - Local Storage được hỗ trợ
  - WebSocket được hỗ trợ (cho tính năng real-time)

### Yêu Cầu Bảo Mật
- Firewall được cấu hình đúng
- Antivirus/Antimalware được cài đặt và cập nhật
- Chính sách mật khẩu mạnh
- Backup dữ liệu định kỳ

### Yêu Cầu Khác
- Camera (cho chức năng giám sát thi)
- Microphone (cho chức năng tương tác)
- Dung lượng lưu trữ cho tài liệu và bài thi
- Băng thông đủ cho số lượng người dùng đồng thời

## Hướng Dẫn Cài Đặt

1. **Cài đặt XAMPP/WAMP/LAMP**
   - Tải và cài đặt XAMPP từ trang chủ
   - Khởi động Apache và MySQL

2. **Cài đặt Database**
   - Import file SQL vào phpMyAdmin
   - Cấu hình kết nối trong file config

3. **Cấu hình Web Server**
   - Copy source code vào thư mục web root
   - Cấu hình virtual host (nếu cần)
   - Cấu hình SSL (nếu có)

4. **Kiểm tra và Khởi chạy**
   - Kiểm tra các quyền thư mục
   - Khởi động lại web server
   - Truy cập website qua trình duyệt

## Lưu ý Quan Trọng

- Đảm bảo tất cả extension PHP cần thiết được cài đặt
- Cấu hình PHP memory limit phù hợp
- Thiết lập cron jobs cho các tác vụ tự động
- Cấu hình backup tự động
- Theo dõi log files thường xuyên

### Công Cụ Kiểm Thử
- **Manual Testing:** Kiểm thử thủ công các test case
- **Selenium:** Tự động hóa kiểm thử UI
- **PHPUnit:** Unit testing cho PHP
- **Browser DevTools:** Kiểm tra request/response
- **Postman:** Kiểm thử API đăng nhập

### Môi Trường Kiểm Thử
- **Trình duyệt:** Chrome, Firefox, Safari, Edge
- **Thiết bị:** Desktop, Tablet, Mobile
- **Hệ điều hành:** Windows, macOS, Linux

