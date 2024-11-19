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

