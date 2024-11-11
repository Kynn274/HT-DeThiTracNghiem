<?php
session_start();

// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_management";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $token = bin2hex(random_bytes(50)); // Tạo token ngẫu nhiên

    $stmt = $pdo->prepare("UPDATE users SET reset_token = :token WHERE email = :email");
    $stmt->execute(['token' => $token, 'email' => $email]);

    $resetLink = "http://yourwebsite.com/reset_password.php?token=$token";
    echo "Vui lòng kiểm tra email của bạn để đặt lại mật khẩu!";
    // Gửi email chứa liên kết $resetLink tới người dùng.
}
?>

