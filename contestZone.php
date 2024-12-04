<?php
  include 'head.php';
?>
<body>
    <?php
        include 'header.php';
    ?>
    <script>
        const userID = '<?php $userID = $_SESSION['user_id']; echo $userID; ?>';
    </script>

    <div class="hero inner-page">
        <div class="hero-background"></div>
        
        <!-- Floating Shapes -->
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
        
        <div class="container">
            <div class="hero-content">
            <span class="text-gradient d-block mb-2" data-aos="fade-up">Khu Vực Thi</span>
                    <h1 class="heading text-white mb-4" data-aos="fade-up" data-aos-delay="100" 
                        style="font-size: 3rem; font-weight: 700;">Cuộc Thi Của Bạn</h1>
                    <p class="text-white-50 mb-0" data-aos="fade-up" data-aos-delay="200" 
                       style="font-size: 1.1rem;">
                        Tham gia các cuộc thi trắc nghiệm để kiểm tra kiến thức của bạn
                    </p>
            </div>
        </div>
    </div>

    <div class="container mt-4 contest-zone-container">
        <div class="row">
            <div class="col-md-12">
                <!-- Search Box -->
                <div class="search-wrapper mb-4 position-relative" data-aos="fade-up">
                    <input type="text" class="form-control search-input" placeholder="Nhập mã cuộc thi..." id="searchBox">
                    <button class="search-button" id="searchButton">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
                
                <!-- Danh sách các cuộc thi -->
                <div class="row g-4" id="examList" data-aos="fade-up" data-aos-delay="100">
                    <!-- Nội dung sẽ được thêm bởi JavaScript -->
                </div>

                <!-- Phân trang -->
                <nav aria-label="Page navigation" class="mt-5" data-aos="fade-up" data-aos-delay="200">
                    <ul class="pagination justify-content-center" id="pagination">
                        <li class="page-item" id="prevPage">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item" id="nextPage">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="joinContestModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h5 class="modal-title">Kết quả cuộc thi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body fs-5">        
                        <p>Modal body text goes here.</p>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
    .hero > .container > .row{
        min-height: 450px !important;
    }
    @media (max-width: 992px){
        .hero > .container > .row {
            min-height: 200px !important;
        }
    }
        .hero-background-animation {
            position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('images/grid.png');
        opacity: 0.1;
        animation: backgroundMove 20s linear infinite;
    }

    .text-gradient {
        background: linear-gradient(to right, #4facfe 0%, #00f2fe 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .contest-zone-container {
        min-height: calc(100vh - 400px);
        padding: 40px 0;
    }

    .search-wrapper {
        max-width: 600px;
        margin: 0 auto 40px;
    }

    .search-input {
        height: 60px;
        border-radius: 30px;
        padding: 0 60px 0 30px;
        font-size: 1.1rem;
        border: 2px solid #e9ecef;
        background: white;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }

    .search-input:focus {
        border-color: var(--bs-primary);
        box-shadow: 0 15px 40px rgba(0,0,0,0.1);
    }

    .search-button {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        border: none;
        background: none;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: var(--bs-primary);
        transition: all 0.3s ease;
    }

    .search-button:hover {
        background: var(--bs-primary);
        color: white;
    }

    /* Card styling */
    .card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        height: 100%;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }

    .card-body {
        padding: 2rem;
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    /* Pagination styling */
    .pagination {
        gap: 5px;
    }

    .page-link {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px !important;
        border: none;
        font-weight: 500;
        color: #6c757d;
        transition: all 0.3s ease;
    }

    .page-link:hover {
        background: var(--bs-primary);
        color: white;
    }

    .page-item.active .page-link {
        background: var(--bs-primary);
        color: white;
        box-shadow: 0 5px 15px rgba(var(--bs-primary-rgb), 0.3);
    }

    /* Modal styling */
    .modal-content {
        border: none;
        border-radius: 20px;
    }

    .modal-header {
        padding: 1.5rem 2rem;
    }

    .modal-body {
        padding: 2rem;
    }

    .modal-footer {
        padding: 1.5rem 2rem;
    }

    .btn-secondary {
        padding: 0.5rem 1.5rem;
        border-radius: 10px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .search-input {
            height: 50px;
            font-size: 1rem;
        }

        .search-button {
            width: 35px;
            height: 35px;
            font-size: 1rem;
        }

        .card-body {
            padding: 1.5rem;
        }

    }

    .hero.overlay {
        display: flex;
        align-items: center;
    }

    @media (max-width: 768px) {
        .hero.overlay {
            height: 300px !important;
            min-height: 300px !important;
        }
        
        .heading {
            font-size: 2rem !important;
        }
        
        .text-gradient {
            font-size: 1rem;
        }
    }

    /* Hero Section Styling */
    .hero.inner-page {
        position: relative;
        background: linear-gradient(135deg, #4154f1 0%, #2c3cdd 100%);
        min-height: 350px;
        display: flex;
        align-items: center;
        overflow: hidden;
    }

    /* Background Animation */
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

    /* Content Styling */
    .hero-content {
        position: relative;
        z-index: 1;
        text-align: center;
        padding: 0 15px;
    }

    .hero-title {
        color: white;
        font-size: 2.8rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.8s ease forwards;
    }

    .hero-subtitle {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1.2rem;
        font-weight: 500;
        margin-bottom: 2rem;
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.8s ease 0.2s forwards;
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .hero.inner-page {
            min-height: 280px;
        }

        .hero-title {
            font-size: 2rem;
        }

        .hero-subtitle {
            font-size: 1rem;
        }

        .shape {
            display: none;
        }
    }
    </style>

    <script src="./js/contestZone.js"></script>
    <script>
        // Initialize contest list when page loads
        $(document).ready(function() {
            loadJoinedContest(userID);
            $('#searchBox').on('keyup', function(event){
                const contestCode = $('#searchBox').val();
                if(event.key == 'Enter'){
                    searchContest(contestCode, userID);
                }
            });
            $('#searchButton').on('click', function(){
                const contestCode = $('#searchBox').val();
                searchContest(contestCode, userID);
            });
        });
    </script>
    <?php
        include 'footer.php';
        include 'javascript.php';
    ?>
</body>
</html>