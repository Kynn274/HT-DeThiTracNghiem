$(document).ready(function(){
    // Trang contest.php
    $('#contestCreateRequest').click(function(){
        window.location.href = 'contestCreate.php';
    });
    $('.reviewContest-btn').click(function(){
        const contestID = $(this).data('contest-id');
        $.ajax({
            url: 'process.php',
            type: 'POST',
            data: {
                action: 'reviewContest', 
                contestID: contestID
            },
            success: function(data){
                if(data.success){
                    window.location.href = `BatDauThi.php`;
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

// Thêm hàm xử lý xem PDF
function viewPDF(contestID) {
    // Mở URL trong tab mới
    window.open(`generatePDF.php?contestID=${contestID}`, '_blank');
}




