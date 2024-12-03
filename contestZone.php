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
    <!-- Add content here -->
    
    <div class="hero overlay" style="height: 150px !important; max-height: 150px !important; min-height: 100px !important">
	</div>
    <div class="container mt-4" style="min-height: 250px;">
        <div class="row">
            <div class="col-md-12">
                <!-- Search Box -->
                <div class="mb-4 position-relative">
                    <input type="text" class="form-control" placeholder="Tìm kiếm cuộc thi..." id="searchBox" style="border-radius: 30px; padding: 10px 20px; border: 1px solid #ccc; font-size: 16px;">
                    <button class="bg-transparent border-0 position-absolute top-50 end-0 fs-5 translate-middle" id="searchButton"><i class="bi bi-search search-icon"></i></button>
                </div>
                
                <!-- Danh sách các cuộc thi -->
                <div class="row" id="examList">
                    
                    <!-- Giả lập 3 cuộc thi -->
                    
                </div>

                <!-- Nút chuyển trang -->
                <nav aria-label="Page navigation">
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
        <div class="modal" tabindex="-1" id="joinContestModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Kết quả cuộc thi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">        
                        <p>Modal body text goes here.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
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