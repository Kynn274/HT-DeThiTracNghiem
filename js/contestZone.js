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
                                    <button ${data.contest.ContestStatus == 1 && data.contest.TestDate == date && data.contest.TestTimes > 0 ? 'onclick="window.location.href=\'BatDauThi.php?id=${data.contest.ContestID}\'"' : data.contest.TestTimes == 0 ? "onclick='alert(\"Bạn đã hết lượt thi!\")'" : data.contest.TestDate > date ? "onclick='alert(\"Cuộc thi chưa bắt đầu!\")'" : "onclick='alert(\"Cuộc thi đã kết thúc!\")'"} class="${data.contest.ContestStatus == 1 && data.contest.TestDate == date && data.contest.TestTimes > 0 ? 'btn btn-light border-light my-2 mx-2 text-dark float-end' : 'btn btn-secondary border-light my-2 mx-2 text-light float-end'}" ${data.contest.ContestStatus == 1 && data.contest.TestDate == date && data.contest.TestTimes > 0 ? 'disabled' : ''} style="border-radius: 25px;">Tham gia</button>
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

