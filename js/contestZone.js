    function loadJoinedContest(userID, page = 1) {
        console.log(userID);
        $.ajax({
            url: 'process.php',
            type: 'POST',
            data: {
                action: 'loadJoinedContest',
                userID: userID,
                page: page
            },
            success: function(data){
                if(data.success){
                    console.log(data);
                    $('#examList').empty();
                    if(data.contests.length > 0){
                        data.contests.forEach(function(contest){
                            let div = $('<div>').addClass('col-md-4 mb-4');
                            let card = $('<div>').addClass('card bg-dark').attr('style', 'border-radius: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.3s;');
                            div.append(card);
                            let cardBody = $('<div>').addClass('card-body');
                            card.append(cardBody);
                            let h5 = $('<h5>').addClass('card-title text-white fw-bold').text(contest.ContestName);
                            cardBody.append(h5);
                            let p = $('<p>').addClass('card-text text-white').text(`Ngày thi: ${contest.TestDate}`);
                            cardBody.append(p);
                            let button = $('<button>').attr('id', `joinContest${contest.JoiningContestID}`).addClass('btn btn-success border-light my-2 mx-2 float-end').attr('style', 'border-radius: 25px;').text('Xem kết quả').data('bs-toggle', 'modal').data('bs-target', '#joinContestModal');
                            cardBody.append(button);
                            div.append(card);
                            $('#examList').append(div);
                            button.on('click', function(){
                                $('#joinContestModal').modal('show');
                                $('#joinContestModal').find('.modal-body').text(`Kết quả cuộc thi ${contest.ContestName} là ${contest.CorrectAnswer}/${contest.TotalQuestions} câu`);
                            });
                        });
                    } else {
                        $('#examList').append('<h5 class="text-center text-muted my-4">Không tìm thấy cuộc thi nào!</h5>');
                    }
                    loadPagination(data.totalPages, page);
                } else {
                    console.log(data.error);
                }
            },
            error: function(xhr, status, error){
                console.log(xhr.responseText);
            }
        });
    }

function loadPagination(totalPages, currentPage) {
    $('#pagination').empty();
    
    // Nút Previous
    $('#pagination').append(`
        <li class="page-item ${currentPage == 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" data-page="${currentPage - 1}" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
    `);
    
    // Các nút số trang
    for(let i = 1; i <= totalPages; i++) {
        $('#pagination').append(`
            <li class="page-item ${i == currentPage ? 'active' : ''}">
                <a class="page-link" href="#" data-page="${i}">${i}</a>
            </li>
        `);
    }
    
    // Nút Next
    $('#pagination').append(`
        <li class="page-item ${currentPage == totalPages ? 'disabled' : ''}">
            <a class="page-link" href="#" data-page="${currentPage + 1}" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    `);
    
    // Xử lý sự kiện click vào nút phân trang
    $('.page-link').on('click', function(e) {
        e.preventDefault();
        const page = $(this).data('page');
        if(page && !$(this).parent().hasClass('disabled')) {
            loadJoinedContest(userID, page);
        }
    });
}

function searchContest(contestCode, userID){
    if(contestCode == ''){
        loadJoinedContest(userID);
    }else{
        $.ajax({
            url: 'process.php',
            type: 'POST',
            data: {
                action: 'searchContest',
                contestCode: contestCode
            },
            success: function(data){
                if(data.success){
                    if(data.contest != null){
                        $('#examList').empty();
                        const date = new Date().toISOString().split('T')[0];
                        $('#examList').append(`<div class="col-md-4 mb-4">
                            <div class="card bg-dark" style="border-radius: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.3s;">
                                <div class="card-body">
                                    <h5 class="card-title text-white fw-bold">${data.contest.ContestName}</h5>
                                    <p class="card-text">Ngày thi: ${data.contest.TestDate}</p>
                                    <button onclick="checkContestAvailability(${data.contest.ContestID}, '${data.contest.TestDate}', ${data.contest.TestTimes}, ${data.contest.Status})" 
                                            class="btn ${data.contest.ContestStatus == 1 && data.contest.TestDate == date && data.contest.TestTimes > 0 ? 'btn-light' : 'btn-secondary'} border-light my-2 mx-2 float-end" 
                                            style="border-radius: 25px;">
                                        Tham gia
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>`);
                        loadPagination(1);
                    }else{
                        $('#examList').empty();
                        $('#examList').append(`<h5 class="text-center text-muted my-4">Không tìm thấy cuộc thi nào!</h5>`);
                    }
                }else{
                    console.log(data.error);
                }
            },
            error: function(xhr, status, error){
                console.log(xhr.responseText);
            }
        });
    }
}

// Thêm modal thông báo
$('body').append(`
    <div class="modal fade" id="contestAlert" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title">Thông báo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <i class="bi bi-exclamation-circle text-warning" style="font-size: 3rem;"></i>
                    <p class="mt-3" id="alertMessage"></p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
`);

function checkContestAvailability(contestID, testDate, testTimes, contestStatus) {
    const currentDate = new Date().toISOString().split('T')[0];
    const modal = new bootstrap.Modal(document.getElementById('contestAlert'));
    if (contestStatus !== 1) {
        document.getElementById('alertMessage').textContent = 'Cuộc thi không hoạt động!';
        modal.show();
        return;
    }
    
    if (testTimes <= 0) {
        document.getElementById('alertMessage').textContent = 'Bạn đã hết lượt thi!';
        modal.show();
        return;
    }
    
    if (testDate > currentDate) {
        document.getElementById('alertMessage').textContent = 'Cuộc thi chưa bắt đầu!';
        modal.show();
        return;
    }
    
    if (testDate < currentDate) {
        document.getElementById('alertMessage').textContent = 'Cuộc thi đã kết thúc!';
        modal.show();
        return;
    }
    
    // Nếu mọi điều kiện đều thỏa mãn
    window.location.href = `BatDauThi.php?id=${contestID}`;
}

