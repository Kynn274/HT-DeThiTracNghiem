    function loadJoinedContest(userID){
        console.log(userID);
        $.ajax({
            url: 'process.php',
            type: 'POST',
            data: {
                action: 'loadJoinedContest',
                userID: userID
            },
            success: function(data){
                if(data.success){
                    console.log(data.contests);
                    if(data.contests.length > 0){
                        $('#examList').empty();
                        data.contests.forEach(function(contest){
                            let div = $('<div>').addClass('col-md-4 mb-4');
                            let card = $('<div>').addClass('card').attr('style', 'border-radius: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.3s;');
                            div.append(card);
                            let cardBody = $('<div>').addClass('card-body');
                            card.append(cardBody);
                            let h5 = $('<h5>').addClass('card-title').text(contest.ContestName);
                            cardBody.append(h5);
                            let p = $('<p>').addClass('card-text').text('Mô tả về cuộc thi');
                            cardBody.append(p);
                            let button = $('<button>').attr('id', `joinContest${contest.JoiningContestID}`).addClass('btn btn-primary my-2 mx-2').attr('style', 'border-radius: 25px;').text('Xem kết quả').data('bs-toggle', 'modal').data('bs-target', '#joinContestModal');
                            cardBody.append(button);
                            div.append(card);
                            $('#examList').append(div);
                            button.on('click', function(){
                                $('#joinContestModal').modal('show');
                                $('#joinContestModal').find('.modal-body').text(`Kết quả cuộc thi ${contest.ContestName} là ${contest.CorrectAnswer}/${contest.TotalQuestions} câu`);
                            });
                        });
                    }else{
                        $('#examList').empty();
                        $('#examList').append('<h5 class="text-center text-muted my-4">Không tìm thấy cuộc thi nào!</h5>');
                    }
                    loadPagination(data.contests.length);
                }else{
                    console.log(data.error);
                    console.log(data);
                }
            },
            error: function(xhr, status, error){
                console.log(xhr.responseText);
            }
        });
    }

function loadPagination(totalPage){
    $('#pagination').not($('#prevPage')).not($('#nextPage')).empty();
    for(let i = 1; i <= (totalPage % 9 == 0 ? totalPage / 9 : totalPage / 9 + 1); i++){
        $('#pagination').append(`<li class="page-item"><a class="page-link" href="#">${i}</a></li>`);
        console.log(i);
    }
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
                            <div class="card" style="border-radius: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.3s;">
                                <div class="card-body">
                                    <h5 class="card-title">${data.contest.ContestName}</h5>
                                    <p class="card-text">Mô tả về cuộc thi</p>
                                    <a href="BatDauThi.php?id=${data.contest.ContestID}" class="${data.contest.ContestStatus == 1 && data.contest.TestDate == date ? 'btn btn-success my-2 mx-2' : 'btn btn-primary my-2 mx-2'}" ${data.contest.ContestStatus == 1 && data.contest.TestDate == date ? 'disabled' : ''} style="border-radius: 25px;">Tham gia</a>
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

