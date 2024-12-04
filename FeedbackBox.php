<?php
    include 'head.php';
?>
<body>
    <?php
        include 'header.php';
        $userID = $_SESSION['user_id'];
        $userType = $_SESSION['user_type'];
    ?>
    <style>
        /* Hero Section Styling */
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

        @keyframes backgroundMove {
            0% { transform: translateX(0) translateY(0); }
            100% { transform: translateX(-50%) translateY(-50%); }
        }

        /* Floating Shapes */
        .shape {
            position: absolute;
            opacity: 0.1;
        }

        .shape-1 {
            top: 10%;
            left: 10%;
            width: 100px;
            height: 100px;
            background: white;
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            animation: float 6s ease-in-out infinite;
        }

        .shape-2 {
            top: 60%;
            right: 10%;
            width: 150px;
            height: 150px;
            background: white;
            border-radius: 63% 37% 54% 46% / 55% 48% 52% 45%;
            animation: float 8s ease-in-out infinite;
        }

        .shape-3 {
            bottom: 10%;
            left: 30%;
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 41% 59% 41% 59% / 41% 59% 41% 59%;
            animation: float 7s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(10deg); }
        }

        /* Feedback Section */
        .section {
            padding: 40px 0;
            background: linear-gradient(135deg, #f6f9ff 0%, #f1f4ff 100%);
        }

        .feedback-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
        }

        .feedback-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .feedback-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .feedback-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .feedback-sender {
            font-weight: 600;
            color: #2c3cdd;
        }

        .feedback-date {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .feedback-content {
            color: #495057;
            margin-bottom: 15px;
            cursor: pointer;
            padding: 10px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .feedback-content:hover {
            background: #f8f9ff;
        }

        .feedback-reply {
            background: #f8f9ff;
            border-radius: 10px;
            padding: 15px;
            margin-top: 15px;
        }

        .reply-header {
            font-weight: 600;
            color: #2c3cdd;
            margin-bottom: 10px;
        }

        .reply-form {
            margin-top: 15px;
            display: none;
        }

        .reply-form.show {
            display: block;
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .reply-form textarea {
            width: 100%;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 12px;
            margin-bottom: 10px;
            resize: vertical;
        }

        .reply-form textarea:focus {
            border-color: #4154f1;
            outline: none;
            box-shadow: 0 0 0 3px rgba(65, 84, 241, 0.1);
        }

        .btn-reply {
            background: linear-gradient(135deg, #4154f1, #2c3cdd);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-reply:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(65, 84, 241, 0.2);
        }

        /* Toast Notification */
        .toast-container {
            z-index: 1050;
        }
    </style>

    <!-- Hero Section -->
    <div class="hero inner-page">
        <div class="hero-background"></div>
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
        <div class="container">
            <div class="hero-content">
                <span class="text-gradient d-block mb-2 text-center" data-aos="fade-up">Hộp Thư</span>
                <h1 class="heading text-white mb-4 text-center" data-aos="fade-up" data-aos-delay="100" 
                    style="font-size: 3rem; font-weight: 700;">Phản Hồi</h1>
                <p class="text-white-50 mb-0 text-center" data-aos="fade-up" data-aos-delay="200" 
                   style="font-size: 1.1rem;">
                    <?php echo $userType == 0 ? 'Quản lý và phản hồi tin nhắn từ người dùng' : 'Xem các phản hồi từ quản trị viên'; ?>
                </p>
            </div>
        </div>
    </div>

    <!-- Feedback Section -->
    <div class="section">
        <div class="container feedback-container">
            <div id="feedbackList">
                <!-- Feedback items will be loaded here -->
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="toast-container position-fixed bottom-0 start-0 p-3">
        <div class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true" id="successToast">
            <div class="d-flex">
                <div class="toast-body">
                    Gửi phản hồi thành công!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        <div class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true" id="errorToast">
            <div class="d-flex">
                <div class="toast-body">
                    Không thể gửi được phản hồi!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            loadFeedbacks();

            function loadFeedbacks() {
                $.ajax({
                    url: 'process.php',
                    type: 'POST',
                    data: {
                        action: 'getFeedbacks'
                    },
                    success: function(response) {
                        if(response.success) {
                            let html = '';
                            if(response.feedbacks.length === 0) {
                                html = `
                                    <div class="text-center py-5">
                                        <i class="bi bi-envelope-open text-muted" style="font-size: 3rem;"></i>
                                        <h4 class="mt-3 text-muted">Chưa có thư nào</h4>
                                        <p class="text-muted">Hộp thư của bạn đang trống</p>
                                    </div>
                                `;
                            } else {
                                response.feedbacks.forEach(feedback => {
                                    html += `
                                        <div class="feedback-card">
                                            <div class="feedback-header">
                                                <div class="feedback-sender">${feedback.Name}</div>
                                                <div class="feedback-date">${feedback.CreateDate}</div>
                                            </div>
                                            <div class="feedback-content" onclick="toggleReplyForm(this)">${feedback.Message}</div>
                                            ${feedback.Reply ? `
                                                <div class="feedback-reply">
                                                    <div class="reply-header">Phản hồi từ Admin:</div>
                                                    <div class="reply-content">${feedback.Reply}</div>
                                                </div>
                                            ` : ''}
                                            ${<?php echo $userType; ?> == 0 && !feedback.Reply ? `
                                                <div class="reply-form">
                                                    <textarea class="form-control" placeholder="Nhập phản hồi của bạn"></textarea>
                                                    <button class="btn btn-reply" onclick="sendReply(${feedback.FeedbackID}, this)">
                                                        <i class="bi bi-reply"></i> Phản hồi
                                                    </button>
                                                </div>
                                            ` : ''}
                                        </div>
                                    `;
                                });
                            }
                            $('#feedbackList').html(html);
                        }
                    }
                });
            }

            window.toggleReplyForm = function(element) {
                // Đóng tất cả các form reply khác
                $('.reply-form.show').not($(element).siblings('.reply-form')).removeClass('show');
                
                // Toggle form reply hiện tại
                $(element).siblings('.reply-form').toggleClass('show');
            }

            window.sendReply = function(feedbackID, button) {
                const replyText = $(button).prev('textarea').val();
                if(!replyText) return;

                $.ajax({
                    url: 'process.php',
                    type: 'POST',
                    data: {
                        action: 'sendReply',
                        feedbackID: feedbackID,
                        reply: replyText
                    },
                    success: function(response) {
                        if(response.success) {
                            var toast = new bootstrap.Toast($('#successToast'));
                            toast.show();
                            loadFeedbacks();
                        } else {
                            var toast = new bootstrap.Toast($('#errorToast'));
                            toast.show();
                        }
                    },
                    error: function() {
                        var toast = new bootstrap.Toast($('#errorToast'));
                        toast.show();
                    }
                });
            }
        });
    </script>

    <?php
        include 'footer.php';
        include 'javascript.php';
    ?>
</body>
</html> 