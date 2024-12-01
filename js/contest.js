$(document).ready(function(){
    $('#contestInfo').hide();

    // Trang contest.php
    $('#contestCreateRequest').click(function(){
        window.location.href = 'contestCreate.php';
    });
    $('.reviewContest-btn').click(function(){
        const contestID = $(this).data('contest-id');
        const contestCode = $(this).closest('tr').find('.getContestCode-btn').data('contest-code');
        window.location.href = `contestReview.php?contestID=${contestID}&contestCode=${contestCode}`;
    });
    $('.moreInfo-btn').click(function(){
        const contestID = $(this).data('contest-id');
        $.ajax({
            url: 'process.php',
            type: 'POST',
            data: {
                action: 'getContestInfo',
                contestID: contestID
            },
            success: function(data){
                if(data.success){
                    const contestInfoBody = $('#contestInfoBody');
                    contestInfoBody.empty('h5, p');
                    contestInfoBody.append(`
                                <h5 class="card-title fs-5">Ngày thi: </h5>
                                <p class="card-text fs-6">${data.contestInfo.TestDate}</p>
                                <h5 class="card-title fs-5">Thời gian thi: </h5>
                                <p class="card-text fs-6">${data.contestInfo.Longtime} phút</p>
                                <h5 class="card-title fs-5">Số lần thi: </h5>
                                <p class="card-text fs-6">${data.contestInfo.TestTimes}</p>
                                <h5 class="card-title fs-5">Mã cuộc thi: </h5>
                                <p class="card-text fs-6">${data.contestInfo.ContestCode == '' ? 'Không có mã cuộc thi' : data.contestInfo.ContestCode}</p>
                                <h5 class="card-title fs-5">Mật khẩu: </h5>
                                <p class="card-text fs-6">${data.contestInfo.ContestPassword == '' ? 'Không có mật khẩu' : data.contestInfo.ContestPassword}</p>
                                <h5 class="card-title fs-5">Số câu hỏi: </h5>
                                <p class="card-text fs-6">${data.contestInfo.TotalQuestions}</p>
                                <button class="btn btn-primary float-end" id="closeContestInfo">Đóng</button>
                    `);
                    $('#contestInfo').show();
                    $('#closeContestInfo').click(function(){
                        $('#contestInfo').hide();
                    });
                }else{
                    alert(data.message);
                }
            },
            error: function(xhr, status, error){
                console.log(xhr.responseText);
            }
        });
    });
    $('#closeContestInfo').click(function(){
        $('#contestInfo').hide();
    }); 
    $('.getContestCode-btn').click(function(){
        const contestCode = $(this).data('contest-code');
        if(contestCode != ''){
            navigator.clipboard.writeText(contestCode);
            alert('Đã copy mã cuộc thi vào clipboard!');
        }else{
            alert('Không có mã cuộc thi!');
        }
    });
    $('.deleteContest-btn').click(function(){
        const contestID = $(this).data('contest-id');
        $.ajax({
            url: 'process.php',
            type: 'POST',
            data: {
                action: 'deleteContest',
                contestID: contestID
            },
            success: function(data){
                if(data.success){
                    window.location.href = 'contest.php';
                }else{
                    alert(data.message);
                }
            },
            error: function(xhr, status, error){
                console.log(xhr.responseText);
            }
        });
    });
    // Trang contestCreate.php
    // Thiết lập giá trị mặc định cho ngày thi (ngày hiện tại)
    $('#examDate').valueAsDate = new Date();

    function togglePasswordField() {
        const examMode = $('#examMode').val();
        if (examMode === 'contest') {
            $('#passwordSection').css('display', 'block');
            $('#testTimesSection').css('display', 'block');
            $('#testTimes').prop('required', true);
            $('#password').prop('required', true);
        } else {
            $('#passwordSection').css('display', 'none');
            $('#testTimesSection').css('display', 'none');
            $('#testTimes').prop('required', false);
            $('#password').prop('required', false);
        }
    }

    function updateDifficultyLimits() {
        const total = parseInt($('#totalQuestions').val());
        const easy = $('#easyQuestions');
        const medium = $('#mediumQuestions');
        const hard = $('#hardQuestions');

        // Cập nhật giới hạn cho từng loại
        [easy, medium, hard].forEach(input => {
            input.max = total;
            const currentVal = parseInt(input.val());
            if (currentVal > total) {
                input.val(Math.floor(total / 3));
            }
        });

        validateDifficultyDistribution();
    }

    function validateDifficultyDistribution() {
        const total = parseInt($('#totalQuestions').val());
        const easy = parseInt($('#easyQuestions').val()) || 0;
        const medium = parseInt($('#mediumQuestions').val()) || 0;
        const hard = parseInt($('#hardQuestions').val()) || 0;
        const currentTotal = easy + medium + hard;

        const distributionTotal = $('#questionDistributionTotal');
        distributionTotal.text(`Tổng: ${currentTotal}/${total} câu`);
        distributionTotal.css('color', currentTotal === total ? 'var(--primary-color)' : 'var(--error-color)');

        return currentTotal === total;
    }

    // Khởi tạo ban đầu
    togglePasswordField();
    validateDifficultyDistribution();
    $('#contestCreateSubmit').click(function(){
        let examName = $('#examName').val().trim();
        let school = $('#school').val();
        let subject = $('#subject').val().trim();
        let duration = $('#duration').val().trim();
        let examDate = $('#examDate').val().trim();
        let questionBank = $('#questionBank').val().trim();
        let totalQuestions = $('#totalQuestions').val().trim();
        let easyQuestions = $('#easyQuestions').val();
        let mediumQuestions = $('#mediumQuestions').val();
        let hardQuestions = $('#hardQuestions').val();
        let examMode = $('#examMode').val().trim();
        let password = $('#password').val();
        let testTimes = $('#testTimes').val();
        let questionBankTotalQuestions = parseInt($('#questionBankTotalQuestions').data('total-questions'));

        if(parseInt(easyQuestions) + parseInt(mediumQuestions) + parseInt(hardQuestions) != parseInt(totalQuestions)){
            alert('Tổng số câu hỏi phân bố không khớp với tổng số câu hỏi yêu cầu!');
            return;
        }
        if(parseInt(totalQuestions) > questionBankTotalQuestions){
            alert('Tổng số câu hỏi không đủ!');
            return;
        }
        if(examName == '' || subject == '' || duration == '' || examDate == '' || questionBank == '' || totalQuestions == '' || easyQuestions == '' || mediumQuestions == '' || hardQuestions == '' || examMode == ''){
            alert('Vui lòng điền đẩy đủ các trường!');
            return;
        }
        $.ajax({
            url: 'process.php',
            type: 'POST',
            data: {
                action: 'contestCreate', 
                contestName: examName, 
                school: school, 
                subject: subject, 
                duration: parseInt(duration), 
                examDate: examDate, 
                questionBank: parseInt(questionBank), 
                totalQuestions: parseInt(totalQuestions), 
                easyQuestions: parseInt(easyQuestions), 
                mediumQuestions: parseInt(mediumQuestions), 
                hardQuestions: parseInt(hardQuestions), 
                examMode: examMode, 
                password: password,
                testTimes: parseInt(testTimes)
            },
            success: function(data){
                if(data.success){
                    window.location.href = 'contest.php';
                }else{
                    alert(data.message);
                }
            },
            error: function(xhr, status, error){
                console.log(xhr.responseText);
            }
        });
    });
    
});





