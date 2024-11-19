<?php
  include 'head.php';
?>
<body>
    <?php
        include 'header.php';
    ?>
    <style>
    input {
      border: none;
      background-color: transparent;
      width: fit-content;
      max-width: 100px;
    }
    .btn{
      padding: 10px 15px;
      height: 100%;
    }
    thead{
      background-color: #f8f9fa;
      text-align: center;
    }
    caption{
      font-size: 1.5rem;
      font-weight: bold;
    }
    td, th{
      vertical-align: middle;
    }
    tbody button i{
      font-size: 1rem;
      margin-right: 5px;
    }
    tbody button p{
      display: inline;
    }
    tbody button{
      margin: 5px;
    }
    
    @media (max-width: 1200px) {
      tbody button i{
        font-size: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0;
      }
      tbody button p{
        display: none;
      }
    }
    .show-info, .show-evidence{
      background-color: rgba(0, 0, 0, 0.5);
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      display: none;
      z-index: 5;
    }
    .show-info .container, .show-evidence .container{
      background-color: #fff;
      width: fit-content;
      height: fit-content;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      padding: 20px;
    }   
    .show-evidence img{
      width: 600px;
      height: 400px;
    }
    .show-info .container{
      width: fit-content;
      min-width: 300px;
      border-radius: 10px;
      box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1);
      padding: 20px;
    }
    .show-info .container h1{
      font-size: 1.5rem;
      font-weight: bold;
      margin: 10px 0;
      text-align: center;
    }
    .show-info .info-container label{
      font-size: 1rem;
      font-weight: bold;
    }
    .show-info .avatar img{
      width: 100px;
      height: 100px;
      border-radius: 50%;
    }
    .show-info .info-container{
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      gap: 10px;
      padding: 10px;
    }
    .show-info .info-item{
      width: 100%;
      display: flex;
      align-items: flex-start;
      flex-direction: column;
    }
    .show-info .info-item input{
      width: calc(100% - 20px);
      padding: 5px;
      background-color: transparent;
      border: none;
      margin: 0 10px;
    }
    .close-info, .close-evidence{
      z-index: 5;
      background-color: transparent;
      border: none;
      width: fit-content;
      height: fit-content;
      position: absolute;
      top: 20px;
      right: 20px;
    }
    .close-info i, .close-evidence i{
      font-size: 1.5rem;
      color: #fff;
    }
    /* Container for the table with scrolling */
    .container.article {
        max-height: 600px;
        overflow-y: auto;
        margin: 20px auto;
        border-radius: 8px;
        /* box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); */
    }

    /* Make the header sticky while scrolling */
    .table thead th {
        position: sticky;
        top: 0;
        background-color: #f8f9fa;
        z-index: 1;
    }

    /* Custom scrollbar styling */
    .container.article::-webkit-scrollbar {
        width: 8px;
    }

    .container.article::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .container.article::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }

    .container.article::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Ensure the table caption stays above the scrollable area */
    .table caption {
        position: sticky;
        top: 0;
        background-color: white;
        z-index: 2;
        padding: 10px 0;
    }

    /* Ensure proper spacing */
    .table {
        margin-bottom: 0;
    }
  </style>
    <!-- Add content here -->
    <div class="hero overlay" style="height: 150px !important; max-height: 150px !important; min-height: 100px !important">
    </div>

    <div class="section">
        <div class="container article">
            <table class="table table-hover caption-top">
                <caption>DANH SÁCH NGÂN HÀNG CÂU HỎI</caption>
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" style="display: none;">Mã ngân hàng câu hỏi</th>
                        <th scope="col">Tên ngân hàng câu hỏi</th>
                        <th scope="col">Ngày tạo</th>
                        <th scope="col">Số câu hỏi</th>
                        <th scope="col">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row" style="text-align: center;"></th>
                        <td style="display: none;"><input type="text" value="" disabled></td>
                        <td><input type="text" value="" disabled></td>
                        <td><input type="date" value="" disabled></td>
                        <td><input type="number" value="" disabled></td>
                        <td>
                            <button class="btn btn-primary editQuestionsBank-btn" value=""><i class="bi bi-pen"></i><p>Sửa</p></button>
                            <button class="btn btn-danger deleteQuestionsBank-btn" value=""><i class="bi bi-trash"></i><p>Xóa</p></button>
                        </td>
                    </tr>
                </tbody>
            </table>
            
        </div>
        <!-- Quản lý câu hỏi trong thư viện -->
        <div class="mb-4 container">
            <h4>Thêm Ngân Hàng Câu Hỏi</h4>
            <a href="manage_questions.php" class="btn btn-info">Thêm Ngân Hàng Câu Hỏi</a>
        </div>
    </div>
  
    <?php
        include 'footer.php';
        include 'javascript.php';
    ?>
</body>
</html>