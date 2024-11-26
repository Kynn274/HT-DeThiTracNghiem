// Thiết lập giá trị mặc định cho ngày thi (ngày hiện tại)
document.getElementById('examDate').valueAsDate = new Date();

function togglePasswordField() {
    const examMode = document.getElementById('examMode').value;
    const passwordSection = document.getElementById('passwordSection');
    const passwordInput = document.getElementById('password');

    if (examMode === 'contest') {
        passwordSection.style.display = 'block';
        passwordInput.required = true;
    } else {
        passwordSection.style.display = 'none';
        passwordInput.required = false;
        passwordInput.value = '';
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