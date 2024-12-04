<?php
    include 'head.php';
?>
<body>
    <?php
        include 'header.php';
    ?>
    <style>
        /* Hero Section */
        .hero.inner-page {
            position: relative;
            background: linear-gradient(135deg, #4154f1 0%, #2c3cdd 100%);
            min-height: 350px;
            display: flex;
            align-items: center;
            overflow: hidden;
        }

        .hero-background {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            overflow: hidden;
        }

        .hero-background::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('images/grid.png');
            opacity: 0.1;
            animation: backgroundMove 20s linear infinite;
        }

        /* Terms Section */
        .terms-container {
            margin-top: -100px;
            position: relative;
            z-index: 10;
            padding: 0 20px;
        }

        .terms-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: none;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 1000px;
            margin: 0 auto;
            margin-bottom: 50px;
        }

        .terms-header {
            background: linear-gradient(135deg, rgba(65, 84, 241, 0.05), rgba(44, 60, 221, 0.05));
            padding: 30px;
            text-align: center;
            border-bottom: 1px solid rgba(65, 84, 241, 0.1);
        }

        .terms-title {
            color: #2c3cdd;
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .terms-subtitle {
            color: #6c757d;
            font-size: 1.1rem;
        }

        .terms-body {
            padding: 40px;
        }

        .terms-section {
            margin-bottom: 40px;
        }

        .terms-section:last-child {
            margin-bottom: 0;
        }

        .section-title {
            color: #2c3cdd;
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title i {
            font-size: 1.6rem;
        }

        .section-content {
            color: #495057;
            line-height: 1.8;
            font-size: 1.05rem;
        }

        .section-content ul {
            padding-left: 20px;
            margin-top: 15px;
        }

        .section-content li {
            margin-bottom: 10px;
        }

        .highlight-box {
            background: linear-gradient(135deg, rgba(65, 84, 241, 0.05), rgba(44, 60, 221, 0.05));
            border-radius: 15px;
            padding: 20px;
            margin: 20px 0;
            border-left: 4px solid #4154f1;
        }

        @media (max-width: 768px) {
            .terms-container {
                margin-top: -50px;
            }

            .terms-body {
                padding: 30px 20px;
            }

            .terms-title {
                font-size: 1.5rem;
            }

            .section-title {
                font-size: 1.2rem;
            }
        }
    </style>

    <div class="hero inner-page">
        <div class="hero-background"></div>
        <div class="container">
            <div class="hero-content">
                <span class="text-gradient d-block mb-2 text-center" data-aos="fade-up">Điều Khoản</span>
                <h1 class="heading text-white mb-4 text-center" data-aos="fade-up" data-aos-delay="100" 
                    style="font-size: 3rem; font-weight: 700;">Điều Khoản Sử Dụng</h1>
                <p class="text-white-50 mb-0 text-center" data-aos="fade-up" data-aos-delay="200" 
                   style="font-size: 1.1rem;">
                    Vui lòng đọc kỹ các điều khoản trước khi sử dụng
                </p>
            </div>
        </div>
    </div>

    <div class="terms-container">
        <div class="terms-card">
            <div class="terms-header">
                <h2 class="terms-title">Điều Khoản & Điều Kiện</h2>
                <p class="terms-subtitle">Cập nhật lần cuối: <?php echo date('d/m/Y'); ?></p>
            </div>
            <div class="terms-body">
                <div class="terms-section">
                    <h3 class="section-title">
                        <i class="bi bi-info-circle"></i>
                        1. Giới Thiệu
                    </h3>
                    <div class="section-content">
                        <div class="highlight-box">
                            <p>MindBridge Institute là nền tảng trực tuyến chuyên biệt cho phép giáo viên tạo và tổ chức các bài kiểm tra, đề thi một cách dễ dàng và hiệu quả. Hệ thống được thiết kế để:</p>
                            <ul>
                                <li>Tạo và quản lý ngân hàng câu hỏi theo môn học</li>
                                <li>Tổ chức các kỳ thi trực tuyến với nhiều hình thức khác nhau</li>
                                <li>Đánh giá năng lực học sinh thông qua các bài kiểm tra</li>
                                <li>Theo dõi và phân tích kết quả học tập một cách chi tiết</li>
                            </ul>
                        </div>
                        <p class="mt-3">Bằng việc truy cập và sử dụng website của chúng tôi, bạn đồng ý tuân thủ và bị ràng buộc bởi các điều khoản và điều kiện được quy định dưới đây.</p>
                    </div>
                </div>

                <div class="terms-section">
                    <h3 class="section-title">
                        <i class="bi bi-person-check"></i>
                        2. Tài Khoản Người Dùng
                    </h3>
                    <div class="section-content">
                        <div class="highlight-box">
                            <p>Khi tạo tài khoản trên hệ thống, bạn phải cung cấp thông tin chính xác, đầy đủ và cập nhật. Việc không làm như vậy có thể dẫn đến việc tài khoản của bạn bị đình chỉ hoặc chấm dứt.</p>
                        </div>
                        <ul>
                            <li>Bạn chịu trách nhiệm bảo mật tài khoản và mật khẩu của mình</li>
                            <li>Không được phép chia sẻ tài khoản với người khác</li>
                            <li>Phải thông báo ngay cho chúng tôi về bất kỳ hành vi sử dụng trái phép nào</li>
                        </ul>
                    </div>
                </div>

                <div class="terms-section">
                    <h3 class="section-title">
                        <i class="bi bi-shield-check"></i>
                        3. Quyền Riêng Tư & Bảo Mật
                    </h3>
                    <div class="section-content">
                        <p>Chúng tôi coi trọng quyền riêng tư của bạn và cam kết bảo vệ thông tin cá nhân của bạn. Thông tin chi tiết về cách chúng tôi thu thập, sử dụng và bảo vệ dữ liệu của bạn được quy định trong Chính sách Bảo mật của chúng tôi.</p>
                    </div>
                </div>

                <div class="terms-section">
                    <h3 class="section-title">
                        <i class="bi bi-file-earmark-text"></i>
                        4. Nội Dung & Bản Quyền
                    </h3>
                    <div class="section-content">
                        <ul>
                            <li>Tất cả nội dung trên website thuộc quyền sở hữu của MindBridge Institute</li>
                            <li>Không được sao chép, phân phối hoặc sử dụng nội dung cho mục đích thương mại</li>
                            <li>Chỉ được phép sử dụng nội dung cho mục đích học tập cá nhân</li>
                        </ul>
                    </div>
                </div>

                <div class="terms-section">
                    <h3 class="section-title">
                        <i class="bi bi-exclamation-triangle"></i>
                        5. Hạn Chế Sử Dụng
                    </h3>
                    <div class="section-content">
                        <p>Bạn không được phép:</p>
                        <ul>
                            <li>Sử dụng bất kỳ thiết bị hoặc phần mềm nào để can thiệp vào hoạt động của website</li>
                            <li>Thực hiện các hành vi có thể gây tổn hại đến hệ thống</li>
                            <li>Thu thập thông tin người dùng khác mà không được phép</li>
                            <li>Sử dụng website cho các mục đích bất hợp pháp</li>
                        </ul>
                    </div>
                </div>

                <div class="terms-section">
                    <h3 class="section-title">
                        <i class="bi bi-patch-check"></i>
                        6. Cam Kết Của Chúng Tôi
                    </h3>
                    <div class="section-content">
                        <div class="highlight-box">
                            <p>Chúng tôi cam kết:</p>
                            <ul>
                                <li>Cung cấp dịch vụ chất lượng và ổn định</li>
                                <li>Bảo vệ thông tin cá nhân của người dùng</li>
                                <li>Liên tục cập nhật và cải thiện hệ thống</li>
                                <li>Hỗ trợ người dùng khi gặp vấn đề</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
        include 'footer.php';
        include 'javascript.php';
    ?>
</body>
</html> 