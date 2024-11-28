$(document).ready(function(){
    $('#contestEditSubmit').click(function(){
        let contestID = $('#editContestID').val();
        let examName = $('#editExamName').val();
        let school = $('#editSchool').val();
        let subject = $('#editSubject').val();
        let duration = $('#editDuration').val();
        let examDate = $('#editExamDate').val();
        let questionBank = $('#editQuestionBank').val();
        let totalQuestions = $('#editTotalQuestions').val();
        let easyQuestions = $('#editEasyQuestions').val();
        let mediumQuestions = $('#editMediumQuestions').val();
        let hardQuestions = $('#editHardQuestions').val();
        let examMode = $('#editExamMode').val();
        let password = $('#editPassword').val();
        let testTimes = $('#editTestTimes').val();
        let questionBankTotalQuestions = parseInt($('#editQuestionBankTotalQuestions').data('total-questions'));

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
                action: 'contestEdit', 
                contestID: contestID,
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
                    alert('Cập nhật đề thi thất bại! Lỗi: ' + data.error);
                }
            },
            error: function(xhr, status, error){
                console.log(xhr.responseText);
            }
        });
    });
});

function togglePasswordField() {
    const examMode = $('#editExamMode').val();

    if (examMode === 'contest') {
        $('#editPasswordSection').css('display', 'block');
        $('#editTestTimesSection').css('display', 'block');
        $('#editTestTimes').prop('required', true);
        $('#editPassword').prop('required', true);
    } else {
        $('#editPasswordSection').css('display', 'none');
        $('#editPassword').prop('required', false);
        $('#editPassword').val('');
        $('#editTestTimesSection').css('display', 'none');
        $('#editTestTimes').prop('required', false);
        $('#editTestTimes').val(1);
    }
}

function updateDifficultyLimits() {
    const total = parseInt(document.getElementById('editTotalQuestions').value);
    const easy = document.getElementById('editEasyQuestions');
    const medium = document.getElementById('editMediumQuestions');
    const hard = document.getElementById('editHardQuestions');

    // Cập nhật giới hạn cho từng loại
    [easy, medium, hard].forEach(input => {
        input.max = total;
        const currentVal = parseInt(input.value);
        if (currentVal > total) {
            input.value = Math.floor(total / 3);
        }
    });

    validateDifficultyDistribution();
}

function validateDifficultyDistribution() {
    const total = parseInt($('#editTotalQuestions').val());
    const easy = parseInt($('#editEasyQuestions').val()) || 0;
    const medium = parseInt($('#editMediumQuestions').val()) || 0;
    const hard = parseInt($('#editHardQuestions').val()) || 0;
    const currentTotal = easy + medium + hard;

    const distributionTotal = $('#editQuestionDistributionTotal');
    distributionTotal.text(`Tổng: ${currentTotal}/${total} câu`);
    distributionTotal.css('color', currentTotal === total ? 'var(--primary-color)' : 'var(--error-color)');

    return currentTotal === total;
}

// Khởi tạo ban đầu
togglePasswordField();
validateDifficultyDistribution();