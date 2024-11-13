const togglePassword = document.getElementById('togglePassword');
const passwordField = document.getElementById('mk');
const eyeIcon = document.getElementById('eyeIcon');

togglePassword.addEventListener('click', function () {
	// Chuyển đổi giữa loại mật khẩu và văn bản
	const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
	passwordField.setAttribute('type', type);
			
			// Thay đổi biểu tượng mắt
	eyeIcon.classList.toggle('bi-eye');
	eyeIcon.classList.toggle('bi-eye-slash');
});