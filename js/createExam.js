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
    const total = parseInt(document.getElementById('totalQuestions').value);
    const easy = parseInt(document.getElementById('easyQuestions').value) || 0;
    const medium = parseInt(document.getElementById('mediumQuestions').value) || 0;
    const hard = parseInt(document.getElementById('hardQuestions').value) || 0;
    const currentTotal = easy + medium + hard;

    const distributionTotal = document.getElementById('questionDistributionTotal');
    distributionTotal.textContent = `Tổng: ${currentTotal}/${total} câu`;
    distributionTotal.style.color = currentTotal === total ? 'var(--primary-color)' : 'var(--error-color)';

    return currentTotal === total;
}

function handleSubmit(event) {
    event.preventDefault();

    if (!validateDifficultyDistribution()) {
        alert('Tổng số câu hỏi phân bố không khớp với tổng số câu hỏi yêu cầu!');
        return;
    }

    // Thực hiện xử lý tạo đề thi
    const formData = new FormData(event.target);
    const data = Object.fromEntries(formData.entries());
    
    // Log dữ liệu để kiểm tra
    console.log('Dữ liệu đề thi:', data);
    
    // Có thể thêm code gửi dữ liệu lên server tại đây
    alert('Đề thi đã được tạo thành công!');
}

// Khởi tạo ban đầu
togglePasswordField();
validateDifficultyDistribution();