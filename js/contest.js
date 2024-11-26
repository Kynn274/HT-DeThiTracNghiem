$(document).ready(function(){
    // Trang contest.php
    $('#contestCreateRequest').click(function(){
        window.location.href = 'contestCreate.php';
    });

    // Trang contestCreate.php
    $('#contestCreateSubmit').click(function(){
        let examName = $('#examName').val();
        let school = $('#school').val();
        let subject = $('#subject').val();
        let duration = $('#duration').val();
        let examDate = $('#examDate').val();
        let questionBank = $('#questionBank').val();
        let totalQuestions = parseInt($('#totalQuestions').val());
        let easyQuestions = parseInt($('#easyQuestions').val());
        let mediumQuestions = parseInt($('#mediumQuestions').val());
        let hardQuestions = parseInt($('#hardQuestions').val());
        let examMode = $('#examMode').val();
        let password = $('#password').val();
        if(easyQuestions + mediumQuestions + hardQuestions != totalQuestions){
            alert('Tổng số câu hỏi phân bố không khớp với tổng số câu hỏi yêu cầu!');
            return;
        }
        if(totalQuestions > questionBankTotalQuestions){
            alert('Tổng số câu hỏi không đủ!');
            return;
        }
        
    });
    
});