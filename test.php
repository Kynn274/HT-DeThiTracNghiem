<?php
  include 'head.php';
?>
<body>
    <?php
        include 'header.php';
        $sql = "SELECT * FROM Contests WHERE UserID = ? AND Type = 'pdf'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
    	$stmt->execute();
        $contests = $stmt->get_result();
        $subjects = [
            'toan' => 'Toán',
            'anh' => 'Tiếng Anh',
            'ly' => 'Vật lý',
            'hoa' => 'Hóa học',
            'sinh' => 'Sinh học',
            'van' => 'Ngữ văn'
        ];
    ?>
    <style>
    input {
        border: none;
        background-color: transparent;
        width: fit-content;
        max-width: 100px;
    }

    /* Style cho bảng */
    .table {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
        margin-bottom: 0;
    }

    .table thead {
        background: linear-gradient(135deg, #4154f1, #2c3cdd);
        color: white;
    }

    .table thead th {
        font-weight: 500;
        letter-spacing: 0.5px;
        padding: 15px;
        border: none;
        text-align: center;
        position: sticky;
        top: 0;
        z-index: 1;
    }

    .table tbody tr {
        transition: all 0.3s ease;
    }

    .table tbody tr:hover {
        background-color: #f8f9ff;
        transform: scale(1.01);
    }

    .table tbody td {
        padding: 12px 15px;
        vertical-align: middle;
        border-bottom: 1px solid #edf2f9;
        text-align: center;
    }

    .table caption {
        color: #2c3cdd;
        font-size: 1.8rem;
        font-weight: 600;
        margin-bottom: 20px;
        text-transform: uppercase;
        letter-spacing: 1px;
        position: sticky;
        top: 0;
        background-color: white;
        z-index: 2;
        padding: 10px 0;
    }

    /* Style cho buttons */
    .btn {
        padding: 8px 15px;
        border-radius: 8px;
        transition: all 0.3s ease;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        border: none;
        margin: 5px;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .btn-primary {
        background: linear-gradient(135deg, #4154f1, #2c3cdd);
        color: white;
    }

    .btn-danger {
        background: linear-gradient(135deg, #ff4d4d, #f73859);
        color: white;
    }

    .btn-warning {
        background: linear-gradient(135deg, #fb6340, #fbb140);
        color: white;
    }

    .btn-info {
        background: linear-gradient(135deg, #11cdef, #1171ef);
        color: white;
    }

    /* Container style */
    .container.article {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        max-height: 600px;
        overflow-y: auto;
        margin: 20px auto;
    }

    /* Action buttons container */
    .action-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        justify-content: center;
    }

    .action-buttons .btn {
        flex: 1;
        min-width: 120px;
        justify-content: center;
    }

    /* Modal styling */
    #contestInfo {
        background: rgba(0,0,0,0.5);
    }

    #contestInfo .card {
        border: none;
        box-shadow: 0 15px 35px rgba(0,0,0,0.2);
    }

    #contestInfo .card-header {
        background: linear-gradient(135deg, #4154f1, #2c3cdd);
        color: white;
        border-radius: 10px 10px 0 0;
    }

    #contestInfo .card-body {
        padding: 25px;
    }

    /* Add Test Section */
    .mb-4.container {
        background: white;
        border-radius: 15px;
        padding: 25px;
        margin-top: 20px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }

    .mb-4.container h4 {
        color: #2c3cdd;
        margin-bottom: 15px;
        font-weight: 600;
    }

    /* Custom scrollbar */
    .container.article::-webkit-scrollbar {
        width: 6px;
    }

    .container.article::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .container.article::-webkit-scrollbar-thumb {
        background: #4154f1;
        border-radius: 10px;
    }

    .container.article::-webkit-scrollbar-thumb:hover {
        background: #2c3cdd;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        tbody button i {
            font-size: 1.2rem;
            margin: 0;
        }
        
        tbody button p {
            display: none;
        }

        .action-buttons .btn {
            min-width: auto;
            padding: 8px;
        }
    }
    </style>

    <div class="hero overlay" style="height: 150px !important; max-height: 150px !important; min-height: 100px !important">
    </div>

    <div class="section">
        <div class="container article">
            <table class="table table-hover caption-top">
                <caption>DANH SÁCH ĐỀ THI</caption>
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" style="display: none;">Mã đề thi</th>
                        <th scope="col">Tên</th>
                        <th scope="col">Môn học</th>
                        <th scope="col">Ngày tạo</th>
                        <th scope="col">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($contests->num_rows > 0):
                        $i = 1;
                        while($contest = $contests->fetch_assoc()): ?>
                            <tr>
                                <th scope="col" class="text-center align-middle"><?php echo $i++; ?></th>
                                <td scope="col"><?php echo $contest['ContestName']; ?></td>
                                <td scope="col"><?php echo $subjects[$contest['Subject']] ?? 'Không xác định'; ?></td>
                                <td scope="col"><?php echo $contest['CreateDate']; ?></td>
                                <td scope="col">
                                    <div class="action-buttons">
                                        <button class="btn align-items-center btn-primary moreInfo-btn" data-contest-id="<?php echo $contest['ContestID']; ?>">
                                            <i class="bi bi-info-circle"></i><p class="m-0 align-middle">Thông tin</p>
                                        </button>
                                        <button class="btn align-items-center btn-warning editContest-btn" onclick="window.location.href='testEdit.php?contestID=<?php echo $contest['ContestID']; ?>'">
                                            <i class="bi bi-pen"></i><p class="m-0 align-middle">Sửa</p>
                                        </button>
                                        <button class="btn align-items-center btn-danger deleteContest-btn" data-contest-id="<?php echo $contest['ContestID']; ?>">
                                            <i class="bi bi-trash"></i><p class="m-0 align-middle">Xóa</p>
                                        </button>
                                    </div>
                                    <div class="action-buttons">
                                        <button class="btn align-items-center btn-info" onclick="generatePDF(<?php echo $contest['ContestID']; ?>)">
                                            <i class="bi bi-file-pdf"></i><p class="m-0 align-middle">Xem PDF</p>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">Không có đề thi nào</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mb-4 container">
            <h4>Thêm Đề Thi</h4>
            <button class="btn btn-info" id="contestCreateRequest">
                <i class="bi bi-plus-circle"></i>
                Thêm Đề Thi Mới
            </button>
        </div>
    </div>

    <!-- Modal Thông tin đề thi -->
    <div class="mb-4 container position-fixed top-0 left-0 w-100 h-100" style="z-index: 1000; max-width: 100vw !important; max-height: 100vh !important; background: rgba(0,0,0,0.5); display: none;" id="contestInfo">
        <div class="card position-absolute top-50 start-50 translate-middle" style="width: 500px;">
            <div class="card-header fs-4 fw-bold">
                Thông tin đề thi
            </div>
            <div class="card-body" id="contestInfoBody">
                <h5 class="card-title fs-5">Special title treatment</h5>
                <p class="card-text fs-6">With supporting text below as a natural lead-in to additional content.</p>
                <button class="btn btn-primary" id="closeContestInfo">Đóng</button>
            </div>
        </div>
    </div>

    <script src="./js/test.js"></script>
    <script src="https://unpkg.com/jspdf-invoice-template@1.4.0/dist/index.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
      // Khởi tạo jsPDF
      window.jsPDF = window.jspdf.jsPDF;

      function generatePDF(contestID) {
          var subject ={
            'toan' : 'Toán',
            'anh' : 'Tiếng Anh',
            'ly' : 'Vật lý',
            'hoa' : 'Hóa học',
            'sinh' : 'Sinh học',
            'van' : 'Ngữ văn',
            'su' : 'Sử',
            'dia' : 'Địa',
            'gdcd' : 'GDCD',
            'tin' : 'Tin học'
          }
          $.ajax({
              url: 'process.php',
              type: 'POST',
              data: {
                  action: 'getContestQuestions',
                  contestID: contestID
              },
              success: function(response) {
                  if(response.success) {
                      var contest = response.contestInfo;
                      var questions = response.questions;
                      
                      // Tạo HTML content
                      var htmlContent = `
                          <style>
                            .page {
                                padding: -5mm 0 0 0;
                                margin: 0;
                            }
                          </style>
                          <div id="pdf-content" style="font-family: Times New Roman, serif; font-size: 13pt; padding: 0 20mm 20mm 20mm;">
                              <!-- Trang đầu tiên với 4 câu -->
                              <div class="page" style="font-family: 'Times New Roman', Times, serif; font-size: 13pt; line-height: 1.15;">
                                  <div style="text-align: center;">
                                      <div style="width: 50%; float: left; text-transform: uppercase;">
                                          <p style="margin: 0;">TRƯỜNG: ${contest.School}</p>
                                          <p style="margin-top: 10pt;">KHOA:........................</p>
                                      </div>
                                      <div style="width: 50%; float: right; text-transform: uppercase; font-family: 'Times New Roman', Times, serif;">
                                          <h3 style="font-size: 13pt; font-weight: bold; margin: 0;">ĐỀ THI KẾT THÚC HỌC PHẦN</h3>
                                          <h3 style="font-size: 13pt; font-weight: bold; margin-top: 8pt;">HỌC KỲ ...... NĂM HỌC .................</h3>
                                      </div>
                                  </div>

                                  <div style="text-align: center; margin-top: 20pt;">
                                      <p style="margin: 0; font-weight: bold; font-size: 13pt;">MÔN THI: ${subject[contest.Subject]}</p>
                                      <p style="margin-top: 10pt; font-weight: bold;">Thời gian: ${contest.Longtime} phút. (không kể thời gian phát đề)</p>
                                  </div>

                                  <div style="border: 1px solid black; padding: 5pt; margin: 10pt 0; width: fit-content; margin-left: 0;">
                                      MÃ ĐỀ: ${contest.ContestCode}
                                  </div>

                                  <div style="text-align: center; margin: 10pt 0;">
                                      <label style="margin-right: 20pt;">
                                          □ Không sử dụng tài liệu
                                      </label>
                                      <label style="margin-right: 20pt;">
                                          □ Được sử dụng tài liệu
                                      </label>
                                      <br/>
                                      <label style="margin-right: 20pt;">
                                          □ Nộp lại đề thi
                                      </label>
                                      <label>
                                          □ Không nộp lại đề thi
                                      </label>
                                  </div>

                                  <div style="margin: 20pt 0;">
                                      <p>Họ và tên:.................................................... MSSV:.........................</p>
                                      <p style="margin: 0;">Lớp:.......................</p>
                                  </div>

                                  <div style="margin: 10pt 0;">
                                      <h4 style="text-align: center; font-size: 13pt; font-family: 'Times New Roman', Times, serif;"><b>NỘI DUNG ĐỀ THI</b></h4>
                                      
                                      <!-- 4 câu đầu tiên -->
                                      ${questions.slice(0, 4).map((question, index) => `
                                          <div style="margin-bottom: 15pt;">
                                              <p>Câu ${index + 1}: ${question.QuestionDescription}</p>
                                              <div style="margin-left: 20pt;">
                                                  <div style="display: flex;">
                                                      <p style="margin: 5pt 0; margin-right: 10pt; flex: 1;">a. ${question.Answer[0].AnswerDescription}</p>
                                                      <p style="margin: 5pt 0; margin-right: 10pt; flex: 1;">b. ${question.Answer[1].AnswerDescription}</p>
                                                  </div>
                                                  <div style="display: flex;">
                                                      <p style="margin: 5pt 0; margin-right: 10pt; flex: 1;">c. ${question.Answer[2].AnswerDescription}</p>
                                                      <p style="margin: 5pt 0; margin-right: 10pt; flex: 1;">d. ${question.Answer[3].AnswerDescription}</p>
                                                  </div>
                                              </div>
                                          </div>
                                      `).join('')}
                                  </div>

                                  <!-- Các trang tiếp theo, mỗi trang 7 câu -->
                                  ${Array.from({ length: Math.ceil((questions.length - 4) / 7) }, (_, pageIndex) => `
                                      <div class="page" style="page-break-before: always; padding: 5mm 0 0 0;font-family: 'Times New Roman', Times, serif; font-size: 13pt; line-height: 1.3;">
                                          ${questions.slice(4 + pageIndex * 7, 4 + (pageIndex + 1) * 7).map((question, index) => `
                                              <div style="margin-bottom: 15pt;">
                                                  <p>Câu ${4 + pageIndex * 7 + index + 1}: ${question.QuestionDescription}</p>
                                                  <div style="margin-left: 20pt;">
                                                      <div style="display: flex;">
                                                          <p style="margin: 5pt 0; margin-right: 10pt; flex: 1;">a. ${question.Answer[0].AnswerDescription}</p>
                                                          <p style="margin: 5pt 0; margin-right: 10pt; flex: 1;">b. ${question.Answer[1].AnswerDescription}</p>
                                                      </div>
                                                      <div style="display: flex;">
                                                          <p style="margin: 5pt 0; margin-right: 10pt; flex: 1;">c. ${question.Answer[2].AnswerDescription}</p>
                                                          <p style="margin: 5pt 0; margin-right: 10pt; flex: 1;">d. ${question.Answer[3].AnswerDescription}</p>
                                                      </div>
                                                  </div>
                                              </div>
                                          `).join('')}

                                      </div>
                                  `).join('')}
                              </div>
                          </div>
                      `;

                      // Tạo div tạm thời để chứa nội dung
                      var container = document.createElement('div');
                      container.innerHTML = htmlContent;
                      document.body.appendChild(container);

                      // Tạo modal xem trước
                      var previewModal = `
                          <div class="modal fade" id="pdfPreviewModal" tabindex="-1">
                              <div class="modal-dialog modal-xl">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <h5 class="modal-title">Xem trước PDF</h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                      </div>
                                      <div class="modal-body" style="height: 80vh;">
                                          <div id="pdfPreview" style="height: 100%;"></div>
                                      </div>
                                      <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                          <button type="button" class="btn btn-primary" id="downloadPDF">Tải xuống</button>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      `;
                      
                      // Thêm modal vào body nếu chưa có
                      if (!document.getElementById('pdfPreviewModal')) {
                          document.body.insertAdjacentHTML('beforeend', previewModal);
                      }

                      // Cấu hình cho html2pdf
                      var opt = {
                          margin: [0, 0, 0, 0],
                          filename: contest.ContestName + '.pdf',
                          image: { type: 'jpeg', quality: 0.98 },
                          html2canvas: { 
                              scale: 2,
                              useCORS: true,
                              letterRendering: true
                          },
                          jsPDF: { 
                              unit: 'mm', 
                              format: 'a4', 
                              orientation: 'portrait'
                          }
                      };

                      // Tạo PDF và hiển thị trong modal
                      var worker = html2pdf().set(opt).from(container);
                      
                      worker.outputPdf('datauristring').then(function(pdfAsString) {
                          // Hiển thị PDF trong modal
                          var modal = new bootstrap.Modal(document.getElementById('pdfPreviewModal'));
                          var pdfPreview = document.getElementById('pdfPreview');
                          pdfPreview.innerHTML = `<iframe src="${pdfAsString}" width="100%" height="100%" frameborder="0"></iframe>`;
                          modal.show();

                          // Xử lý sự kiện tải xuống
                          document.getElementById('downloadPDF').onclick = function() {
                              worker.save();
                              modal.hide();
                          };
                      });

                      // Xóa container sau khi modal đóng
                      document.getElementById('pdfPreviewModal').addEventListener('hidden.bs.modal', function () {
                          document.body.removeChild(container);
                      });
                  }
              }
          });
      }
    </script>
    <?php
        include 'footer.php';
        include 'javascript.php';
    ?>
</body>
</html>