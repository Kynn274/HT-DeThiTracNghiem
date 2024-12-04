const passwordField = $('#old_password');
const eyeIcon = $('#eyeIcon-old');
const togglePasswordNew = $('#togglePassword-new');
const passwordFieldNew = $('#new_password');
const eyeIconNew = $('#eyeIcon-new');
const togglePasswordConfirm = $('#togglePassword-confirm');
const passwordFieldConfirm = $('#confirm_password');
const eyeIconConfirm = $('#eyeIcon-confirm');

$('#togglePassword-old').click(function () {
	const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
	passwordField.attr('type', type);
			
	eyeIcon.toggleClass('bi-eye');
	eyeIcon.toggleClass('bi-eye-slash');
});
$('#togglePassword-new').click(function () {
	const type = passwordFieldNew.attr('type') === 'password' ? 'text' : 'password';
	passwordFieldNew.attr('type', type);
	eyeIconNew.toggleClass('bi-eye');
	eyeIconNew.toggleClass('bi-eye-slash');
});

$('#togglePassword-confirm').click(function () {
	const type = passwordFieldConfirm.attr('type') === 'password' ? 'text' : 'password';
	passwordFieldConfirm.attr('type', type);
	eyeIconConfirm.toggleClass('bi-eye');
	eyeIconConfirm.toggleClass('bi-eye-slash');
});

// Thêm validation khi submit form
$('form').on('submit', function(e) {
    const oldPassword = $('#old_password').val();
    const newPassword = $('#new_password').val();
    const confirmPassword = $('#confirm_password').val();
    let isValid = true;
    let errorMessage = '';

    // Kiểm tra các trường không được để trống
    if(!oldPassword || !newPassword || !confirmPassword) {
        errorMessage = 'Vui lòng điền đầy đủ thông tin';
        isValid = false;
    }
    // Kiểm tra độ dài mật khẩu mới
    else if(newPassword.length < 6) {
        errorMessage = 'Mật khẩu mới phải có ít nhất 6 ký tự';
        isValid = false;
    }
    // Kiểm tra mật khẩu mới không được trùng mật khẩu cũ
    else if(newPassword === oldPassword) {
        errorMessage = 'Mật khẩu mới không được trùng với mật khẩu cũ';
        isValid = false;
    }
    // Kiểm tra mật khẩu xác nhận
    else if(newPassword !== confirmPassword) {
        errorMessage = 'Mật khẩu xác nhận không khớp';
        isValid = false;
    }

    if(!isValid) {
        e.preventDefault();
        $('.error-message').text(errorMessage).show();
        return false;
    }
});

// Ẩn thông báo lỗi khi người dùng bắt đầu nhập lại
$('input[type="password"]').on('input', function() {
    $('.error-message').hide();
});

