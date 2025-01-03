const resetBtn = $('.reset-btn');


$('.show-evidence-btn').click(function() {
  const evidence = $(this).val();
    document.querySelector('.show-evidence').style.display = 'block';
    document.querySelector('.show-evidence img').src = 'images/' + evidence;
    console.log(evidence);
});

$('.show-info-btn').click(function() {
    const userID = $(this).val();
    $.ajax({
        url: 'process.php',
        type: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        data: {
            action: 'getUserInfo',
            userID: userID
        },
        success: function(data) {
            // const data = JSON.parse(response);
            console.log(data);
            if(data.success){
                if(data.data.Avatar != '' && data.data.Avatar != null){
                    $('.show-info .avatar img').attr('src', 'images/' + data.data.Avatar);
                }else{
                    $('.show-info .avatar img').attr('src', 'images/no-avatar.jpg');
                }
                $('#fullname').attr('value', data.data.Fullname || '');
                $('#email').attr('value', data.data.Email || '');
                $('#phone').attr('value', data.data.PhoneNumber || '');
                $('#birthday').attr('value', data.data.DateOfBirth || '');
                
                // Show the modal
                $('.show-info').css('display', 'block');
            } else {
                alert('Could not fetch user information');
            }
        },
        error: function(error, textStatus) {
            console.error('Error:', textStatus);
            alert('An error occurred while fetching user information');
        }
    });
});

// Add HTML for confirmation modal at the end of your QuanLyNguoiDung.php file
const confirmationHTML = `
<div class="confirmation-panel" style="display: none;">
    <div class="container">
        <h2>Xác nhận hành động</h2>
        <p>Bạn có chắc chắn muốn hạn chế tài khoản này không?</p>
        <div class="button-group">
            <button class="btn btn-secondary cancel-btn">Hủy</button>
            <button class="btn btn-danger confirm-btn">Xác nhận</button>
        </div>
    </div>
</div>
`;
document.body.insertAdjacentHTML('beforeend', confirmationHTML);

// Add CSS for confirmation panel
const style = document.createElement('style');
style.textContent = `
    .confirmation-panel {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        display: none;
    }
    .confirmation-panel .container {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        text-align: center;
        min-width: 300px;
        width: fit-content;
    }
    .confirmation-panel .button-group {
        margin-top: 20px;
        display: flex;
        justify-content: center;
        gap: 10px;
    }
`;
document.head.appendChild(style);

// Thêm function hiển thị toast
function showToast(type, title, message) {
    const toast = document.querySelector('.toast');
    const icon = toast.querySelector('.toast-content .bi');
    const title_text = toast.querySelector('.text.text-1');
    const message_text = toast.querySelector('.text.text-2');
    
    // Set icon và màu dựa vào type
    if (type === 'success') {
        icon.className = 'bi bi-check-circle-fill';
        toast.style.borderLeft = '6px solid #2dce89';
    } else {
        icon.className = 'bi bi-x-circle-fill';
        toast.style.borderLeft = '6px solid #f5365c';
    }
    
    title_text.textContent = title;
    message_text.textContent = message;
    
    toast.classList.add('active');
    
    // Tự động ẩn toast sau 5s
    setTimeout(() => {
        toast.classList.remove('active');
    }, 5000);
}

// Xử lý đóng toast khi click
document.querySelector('.toast .close').addEventListener('click', () => {
    document.querySelector('.toast').classList.remove('active');
});

// Cập nhật các hàm xử lý ban/activate để sử dụng toast
$('.ban-btn').click(function() {
    const userID = $(this).val();
    const username = $(this).closest('tr').find('input[type="text"]').val();
    const confirmationPanel = $('.confirmation-panel');
    const confirmBtn = confirmationPanel.find('.confirm-btn');
    const cancelBtn = confirmationPanel.find('.cancel-btn');

    confirmationPanel.find('p').text(`Bạn có chắc chắn muốn hạn chế tài khoản "${username}" không?`);
    confirmationPanel.css('display', 'block');

    cancelBtn.click(function() {
        confirmationPanel.css('display', 'none');
    });

    confirmBtn.click(function() {
        $.ajax({
            url: 'process.php',
            type: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            data: {
                action: 'banUser',
                userID: userID
            },
            success: function(response) {
                if (response.success) {
                    showToast('success', 'Thành công', response.message);
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    showToast('error', 'Lỗi', response.message);
                }
                confirmationPanel.css('display', 'none');
            },
            error: function(xhr, status, error) {
                showToast('error', 'Lỗi', 'Đã xảy ra lỗi khi thực hiện thao tác');
                confirmationPanel.css('display', 'none');
            }
        });
    });
});

$('.activate-btn').click(function() {
    const userID = $(this).val();
    $.ajax({
        url: 'process.php',
        type: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        data: {
            action: 'activateUser',
            userID: userID
        },
        success: function(response) {
            if(response.success){
                showToast('success', 'Thành công', response.message);
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                showToast('error', 'Lỗi', response.message);
            }
        },
        error: function(xhr, status, error) {
            showToast('error', 'Lỗi', 'Đã xảy ra lỗi khi thực hiện thao tác');
        }
    });
});

// Close confirmation panel when clicking outside
$('.confirmation-panel').click(function(e) {
    if (e.target === $('.confirmation-panel')) {
        $('.confirmation-panel').css('display', 'none');
    }
});

// Close buttons functionality
$('.close-info').click(function() {
    $('.show-info').css('display', 'none');
});

$('.close-evidence').click(function() {
    $('.show-evidence').css('display', 'none');
});