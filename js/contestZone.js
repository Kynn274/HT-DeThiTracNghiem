function loadJoinedContest(userID){
    $.ajax({
        url: 'process.php',
        type: 'POST',
        data: {
            action: 'loadJoinedContest',
            userID: userID
        },
        success: function(data){
            if(data.success){
                if(data.contests.length > 0){
                    $('#examList').empty();
                    data.contests.forEach(function(contest){
                        $('#examList').append(`<div class="col-md-4 mb-4">
                        <div class="card" style="border-radius: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.3s;">
                            <div class="card-body">
                                <h5 class="card-title">${contest.ContestName}</h5>
                                <p class="card-text">Mô tả về cuộc thi</p>
                                <a href="BatDauThi.php?id=${contest.ContestID}" class="btn btn-primary my-2 mx-2" style="border-radius: 25px;">Tham gia</a>
                                <a href="edit_exam.php?id=${contest.ContestID}" class="btn btn-secondary my-2 mx-2" style="border-radius: 25px;">Chỉnh sửa</a>
                                </div>
                            </div>
                        </div>
                    </div>`);
                    });
                }else{
                    $('#examList').empty();
                    $('#examList').append('<h5 class="text-center text-muted my-4">Không tìm thấy cuộc thi nào!</h5>');
                }
                loadPagination(data.contests.length);
            }else{
                alert(data.error);
            }
        },
        error: function(xhr, status, error){
            console.log(xhr.responseText);
        }
    });
}

function loadPagination(totalPage){
    $('#pagination').empty().not($('#prevPage')).not($('#nextPage'));
    for(let i = 1; i <= (totalPage % 9 == 0 ? totalPage / 9 : totalPage / 9 + 1); i++){
        $('#pagination').append(`<li class="page-item"><a class="page-link" href="#">${i}</a></li>`);
        console.log(i);
    }
}

function searchContest(contestCode){
    if(contestCode == ''){
        loadJoinedContest('<?php $userID = $_SESSION[\'user_id\']; echo $userID; ?>');
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
                                    <a href="edit_exam.php?id=${data.contest.ContestID}" class="${data.contest.ContestStatus == 1 ? 'btn btn-secondary my-2 mx-2' : 'btn btn-secondary my-2 mx-2'}" style="border-radius: 25px;">Chỉnh sửa</a>
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
                    alert(data.error);
                }
            },
            error: function(xhr, status, error){
                console.log(xhr.responseText);
            }
        });
    }
}

$('#searchBox').on('keyup', function(event){
    const contestCode = $('#searchBox').val();
    if(event.key == 'Enter'){
        searchContest(contestCode);
    }
});
$('#searchButton').on('click', function(){
    const contestCode = $('#searchBox').val();
    searchContest(contestCode);
});
loadJoinedContest('<?php $userID = $_SESSION[\'user_id\']; echo $userID; ?>');
