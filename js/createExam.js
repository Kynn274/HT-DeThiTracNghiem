// Thiết lập giá trị mặc định cho ngày thi (ngày hiện tại)
document.getElementById('examDate').valueAsDate = new Date();

function togglePasswordField() {
    const examMode = $('#examMode').val();

    if (examMode === 'contest') {
        $('#passwordSection').css('display', 'block');
        $('#testTimesSection').css('display', 'block');
        $('#testTimes').prop('required', true);
        $('#password').prop('required', true);
    } else {
        $('#passwordSection').css('display', 'none');
        $('#password').prop('required', false);
        $('#password').val('');
        $('#testTimesSection').css('display', 'none');
        $('#testTimes').prop('required', false);
        $('#testTimes').val(1);
    }
}

function updateDifficultyLimits() {
    const total = parseInt(document.getElementById('totalQuestions').value);
    const easy = document.getElementById('easyQuestions');
    const medium = document.getElementById('mediumQuestions');
    const hard = document.getElementById('hardQuestions');

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