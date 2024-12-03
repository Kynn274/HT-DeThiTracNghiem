<footer class="site-footer">
    <div class="container">
        <div class="row">
            <!-- Cột thông tin -->
            <div class="col-lg-4 mb-5 mb-lg-0">
                <div class="mb-5">
                    <h3 class="footer-heading mb-4">GIỚI THIỆU</h3>
                    <p class="text-white-50">
                        Nền tảng của chúng tôi giúp đơn giản hóa quá trình tạo đề thi, cho phép bạn thiết kế các bài kiểm tra trắc nghiệm tùy chỉnh một cách dễ dàng và hiệu quả.
                    </p>
                </div>
                <div class="mb-5">
                    <h3 class="footer-heading mb-4">LIÊN HỆ</h3>
                    <ul class="list-unstyled footer-links">
                        <li class="d-flex mb-3">
                            <i class="bi bi-telephone-fill me-3 text-white-50"></i>
                            <a href="tel://0967785209" class="text-white-50">0967785209</a>
                        </li>
                        <li class="d-flex">
                            <i class="bi bi-envelope-fill me-3 text-white-50"></i>
                            <a href="mailto:4801103042@student.hcmue.edu.com" class="text-white-50">4801103042@student.hcmue.edu.com</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Cột menu -->
            <div class="col-lg-4 mb-5 mb-lg-0">
                <div class="row">
                    <!-- Menu chính -->
                    <div class="col-6">
                        <div class="mb-5">
                            <h3 class="footer-heading mb-4">MENU CHÍNH</h3>
                            <ul class="list-unstyled footer-links">
                                <li class="mb-3"><a href="index.php" class="text-white-50">Trang chủ</a></li>
                                <li class="mb-3">
                                    <a href="<?php echo $is_logged_in? 'contestZone.php' : 'DangNhap.php' ?>" class="text-white-50">
                                        Cuộc thi
                                    </a>
                                </li>
                                <li class="mb-3"><a href="LienHe.php" class="text-white-50">Liên hệ</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Menu phụ (phân quyền) -->
                    <div class="col-6">
                        <div class="mb-5">
                            <h3 class="footer-heading mb-4">CHỨC NĂNG</h3>
                            <ul class="list-unstyled footer-links">
                                <?php if($is_logged_in): ?>
                                    <?php if($user_type == 0): ?>
                                        <!-- Menu Admin -->
                                        <li class="mb-3">
                                            <a href="QuanLyNguoiDung.php" class="text-white-50 menu-admin">
                                                Quản lý người dùng
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if($user_type == 0 || $user_type == 2): ?>
                                        <!-- Menu Admin và Giáo viên -->
                                        <li class="mb-3">
                                            <a href="contest.php" class="text-white-50 menu-teacher">
                                                Tạo cuộc thi
                                            </a>
                                        </li>
                                        <li class="mb-3">
                                            <a href="questionsBank.php" class="text-white-50 menu-teacher">
                                                Ngân hàng câu hỏi
                                            </a>
                                        </li>
                                        <li class="mb-3">
                                            <a href="test.php" class="text-white-50 menu-teacher">
                                                Tạo đề thi
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <!-- Menu cho mọi user đã đăng nhập -->
                                    <?php if($is_logged_in): ?>
										<?php if($user_type == 1): ?>
                                            <li class="mb-3">
                                                <a href="#" class="text-white-50 menu-user">
                                                    Không có chức năng
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    <?php elseif (!$is_logged_in): ?>
                                        <li class="mb-3">
                                            <a href="DangNhap.php" class="text-white-50 menu-user">
                                                Không có chức năng
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cột liên kết -->
            <div class="col-lg-4">
                <div class="mb-5">
                    <h3 class="footer-heading mb-4">THEO DÕI CHÚNG TÔI</h3>
                    <div class="d-flex social-links">
                        <a href="#" class="d-flex align-items-center justify-content-center me-3">
                            <i class="bi bi-facebook text-white"></i>
                        </a>
                        <a href="#" class="d-flex align-items-center justify-content-center me-3">
                            <i class="bi bi-twitter text-white"></i>
                        </a>
                        <a href="#" class="d-flex align-items-center justify-content-center me-3">
                            <i class="bi bi-instagram text-white"></i>
                        </a>
                        <a href="#" class="d-flex align-items-center justify-content-center">
                            <i class="bi bi-linkedin text-white"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h3 class="footer-heading mb-4">LIÊN KẾT NHANH</h3>
                    <ul class="list-unstyled footer-links">
                        <li class="mb-3"><a href="#" class="text-white-50">Thông tin về chúng tôi</a></li>
                        <li class="mb-3"><a href="LienHe.php" class="text-white-50">Liên hệ với chúng tôi</a></li>
                        <li class="mb-3"><a href="#" class="text-white-50">Điều khoản sử dụng</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row mt-5 pt-4 border-top border-secondary">
            <div class="col-md-6 text-center text-md-start">
                <p class="text-white-50 mb-0">
                    &copy; <?php echo date('Y'); ?> MindBridge Institute. All rights reserved.
                </p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <p class="text-white-50 mb-0">
                    Designed with <i class="bi bi-heart-fill text-danger"></i> by MindBridge Team
                </p>
            </div>
        </div>
    </div>
</footer>

<!-- Preloader -->
<div id="overlayer"></div>
<div class="loader">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">LOADING...</span>
    </div>
</div>

<style>
.site-footer {
    padding: 70px 0;
    background: linear-gradient(140deg, var(--bs-dark) 0%, #3038e8 100%);
}

.footer-heading {
    color: white;
    font-size: 1.2rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.footer-links a {
    font-size: 0.9rem;
    padding: 5px 0;
    display: block;
    transition: all 0.3s ease;
}

.footer-links a[href="index.php"],
.footer-links a[href*="contestZone.php"],
.footer-links a[href="LienHe.php"],
.footer-links a[href="DangNhap.php"] {
    font-size: 1rem;
    font-weight: 600;
    color: rgba(255,255,255,0.7) !important;
}

.menu-admin {
    color: rgba(255,255,255,0.4) !important;
    border-left: 2px solid #dc3545;
    padding-left: 10px !important;
}

.menu-teacher {
    color: rgba(255,255,255,0.4) !important;
    border-left: 2px solid #198754;
    padding-left: 10px !important;
}

.menu-user {
    color: rgba(255,255,255,0.4) !important;
    border-left: 2px solid #0dcaf0;
    padding-left: 10px !important;
}

.footer-links a:hover {
    color: white !important;
    padding-left: 15px;
}

.menu-admin:hover {
    border-left-color: #ff4757;
}

.menu-teacher:hover {
    border-left-color: #2ecc71;
}

.menu-user:hover {
    border-left-color: #48dbfb;
}

.social-links a {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: rgba(255,255,255,0.1);
    transition: all 0.3s ease;
}

.social-links a:hover {
    background: white;
}

.social-links a:hover i {
    color: var(--bs-dark) !important;
}

.social-links i {
    font-size: 1.2rem;
    transition: all 0.3s ease;
}

.footer-logo {
    display: flex;
    align-items: center;
}

/* Responsive */
@media (max-width: 991.98px) {
    .footer-links a {
        font-size: 0.85rem;
    }
    .footer-heading {
        font-size: 1rem;
    }
}
</style>